<?php

namespace Database\Seeders;

use App\Enums\PaymentStatus;
use App\Enums\RefundStatus;
use App\Enums\RegistrationStatus;
use App\Models\Event;
use App\Models\Portfolio;
use App\Models\RefundRequest;
use App\Models\Registration;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $faker = fake();

        $admin = User::factory()->create([
            'name' => 'Administrator',
            'email' => 'admin@example.com',
            'is_admin' => true,
            'password' => Hash::make('password'),
        ]);

        $users = User::factory(15)->create();

        $publishedEvents = Event::factory()
            ->count(4)
            ->published()
            ->for($admin, 'creator')
            ->for($admin, 'updater')
            ->create();

        $draftEvents = Event::factory()
            ->count(2)
            ->draft()
            ->for($admin, 'creator')
            ->for($admin, 'updater')
            ->create();

        $events = $publishedEvents->concat($draftEvents);

        $events->each(function (Event $event) use ($faker, $users) {
            Portfolio::factory()
                ->count($faker->numberBetween(1, 3))
                ->for($event)
                ->create();

            $participants = $users
                ->shuffle()
                ->take($faker->numberBetween(3, min(8, $users->count())));

            $participants->each(function (User $participant) use ($event, $faker) {
                $registeredAt = $event->start_at->copy()
                    ->subDays($faker->numberBetween(7, 30))
                    ->setTime($faker->numberBetween(8, 19), $faker->numberBetween(0, 59));

                $registrationState = [
                    'amount' => $event->price,
                    'registered_at' => $registeredAt,
                    'form_data' => [
                        'full_name' => $participant->name,
                        'email' => $participant->email,
                        'phone' => $faker->phoneNumber(),
                        'organization' => $faker->company(),
                    ],
                    'status' => RegistrationStatus::Pending,
                    'payment_status' => PaymentStatus::Pending,
                    'payment_proof_path' => null,
                    'paid_at' => null,
                    'verified_at' => null,
                ];

                if ($faker->boolean(70)) {
                    $paymentStatus = $faker->boolean(75)
                        ? PaymentStatus::Verified
                        : PaymentStatus::AwaitingVerification;

                    $paidAt = $registeredAt->copy()->addDays($faker->numberBetween(0, 2));

                    $registrationState['payment_status'] = $paymentStatus;
                    $registrationState['payment_proof_path'] = 'payments/proof-' . Str::uuid() . '.jpg';
                    $registrationState['paid_at'] = $paidAt;

                    if ($paymentStatus === PaymentStatus::Verified) {
                        $registrationState['status'] = RegistrationStatus::Confirmed;
                        $registrationState['verified_at'] = $paidAt->copy()->addDay();
                    }
                }

                $registration = Registration::factory()
                    ->for($participant)
                    ->for($event)
                    ->state($registrationState)
                    ->create();

                if ($registration->payment_status === PaymentStatus::Verified && $faker->boolean(25)) {
                    $refundStatus = $faker->randomElement(RefundStatus::cases());
                    $requestedAt = ($registration->verified_at ?? $registration->registered_at)
                        ->copy()
                        ->addDays($faker->numberBetween(1, 5));

                    $processedAt = in_array($refundStatus, [
                        RefundStatus::Approved,
                        RefundStatus::Rejected,
                        RefundStatus::Completed,
                    ], true)
                        ? $requestedAt->copy()->addDays($faker->numberBetween(1, 5))
                        : null;

                    RefundRequest::factory()
                        ->for($registration)
                        ->state([
                            'status' => $refundStatus,
                            'reason' => $faker->sentence(),
                            'admin_note' => $processedAt ? $faker->sentence() : null,
                            'requested_at' => $requestedAt,
                            'processed_at' => $processedAt,
                        ])
                        ->create();

                    if ($refundStatus === RefundStatus::Completed) {
                        $registration->update([
                            'status' => RegistrationStatus::Refunded,
                            'payment_status' => PaymentStatus::Refunded,
                        ]);
                    } elseif ($refundStatus === RefundStatus::Approved) {
                        $registration->update([
                            'status' => RegistrationStatus::Cancelled,
                        ]);
                    }
                }
            });

            if ($event->capacity) {
                $event->forceFill([
                    'available_slots' => max($event->capacity - $event->registrations()->count(), 0),
                ])->save();
            }
        });
    }
}
