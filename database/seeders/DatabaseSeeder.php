<?php

namespace Database\Seeders;

use App\Enums\PaymentStatus;
use App\Enums\RefundStatus;
use App\Enums\RegistrationStatus;
use App\Models\Admin;
use App\Models\Event;
use App\Models\Portfolio;
use App\Models\Refund;
use App\Models\Registration;
use App\Models\Transaction;
use App\Models\User;
use Carbon\Carbon;
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
            'password' => Hash::make('password'),
            'is_admin' => true,
        ]);

        Admin::create([
            'user_id' => $admin->id,
            'role' => 'Super Admin',
            'phone' => $faker->phoneNumber(),
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

                $registration = Registration::factory()
                    ->for($participant)
                    ->for($event)
                    ->state([
                        'registered_at' => $registeredAt,
                        'form_data' => [
                            'full_name' => $participant->name,
                            'email' => $participant->email,
                            'phone' => $faker->phoneNumber(),
                            'organization' => $faker->company(),
                        ],
                    ])
                    ->create();

                $transactionStatus = PaymentStatus::Pending;
                $paidAt = null;
                $verifiedAt = null;
                $proofPath = null;

                if ($faker->boolean(70)) {
                    $transactionStatus = $faker->boolean(75)
                        ? PaymentStatus::Verified
                        : PaymentStatus::AwaitingVerification;
                    $paidAt = $registeredAt->copy()->addDays($faker->numberBetween(0, 2));
                    $proofPath = 'payments/proof-' . Str::uuid() . '.jpg';

                    if ($transactionStatus === PaymentStatus::Verified) {
                        $verifiedAt = $paidAt->copy()->addDay();
                        $registration->update([
                            'status' => RegistrationStatus::Confirmed,
                        ]);
                    }
                }

                $transaction = Transaction::factory()
                    ->for($registration)
                    ->state([
                        'amount' => $event->price,
                        'status' => $transactionStatus,
                        'payment_proof_path' => $proofPath,
                        'paid_at' => $paidAt,
                        'verified_at' => $verifiedAt,
                    ])
                    ->create();

                if ($transaction->status === PaymentStatus::Verified && $faker->boolean(25)) {
                    $refundStatus = $faker->randomElement(RefundStatus::cases());
                    $requestedAt = ($transaction->verified_at ?? $registration->registered_at)
                        ->copy()
                        ->addDays($faker->numberBetween(1, 5));

                    $processedAt = in_array($refundStatus, [
                        RefundStatus::Approved,
                        RefundStatus::Rejected,
                        RefundStatus::Completed,
                    ], true)
                        ? $requestedAt->copy()->addDays($faker->numberBetween(1, 5))
                        : null;

                    Refund::factory()
                        ->for($transaction)
                        ->state([
                            'status' => $refundStatus,
                            'reason' => $faker->sentence(),
                            'admin_note' => $processedAt ? $faker->sentence() : null,
                            'requested_at' => $requestedAt,
                            'processed_at' => $processedAt,
                        ])
                        ->create();

                    if ($refundStatus === RefundStatus::Completed) {
                        $transaction->update(['status' => PaymentStatus::Refunded]);
                        $registration->update(['status' => RegistrationStatus::Refunded]);
                    } elseif ($refundStatus === RefundStatus::Approved) {
                        $registration->update(['status' => RegistrationStatus::Cancelled]);
                    }
                }
            });
        });

        $demoStart = Carbon::now()->addWeeks(4)->setTime(9, 0);
        $demoEnd = (clone $demoStart)->addHours(6);

        $demoEvent = Event::factory()
            ->published()
            ->for($admin, 'creator')
            ->for($admin, 'updater')
            ->create([
                'title' => 'Workshop Uji Transaksi',
                'description' => 'Sesi khusus untuk menguji alur transaksi, verifikasi, dan refund pada dashboard admin.',
                'start_at' => $demoStart,
                'end_at' => $demoEnd,
                'venue_name' => 'Studio Kreasi Hangat',
                'venue_address' => 'Jl. Demonstrasi No. 8, Jakarta Selatan',
                'tutor_name' => 'Tim Keuangan Kreasi',
                'capacity' => 30,
                'price' => 275_000,
            ]);

        $transactionScenarios = [
            [
                'status' => PaymentStatus::Pending,
                'registration_status' => RegistrationStatus::Pending,
            ],
            [
                'status' => PaymentStatus::AwaitingVerification,
                'registration_status' => RegistrationStatus::Pending,
                'paid_at' => (clone $demoStart)->subDays(5)->setTime(14, 30),
                'proof' => 'payments/demo-awaiting.jpg',
            ],
            [
                'status' => PaymentStatus::Verified,
                'registration_status' => RegistrationStatus::Confirmed,
                'paid_at' => (clone $demoStart)->subDays(6)->setTime(10, 0),
                'verified_at' => (clone $demoStart)->subDays(4)->setTime(11, 30),
                'proof' => 'payments/demo-verified.jpg',
            ],
            [
                'status' => PaymentStatus::Refunded,
                'registration_status' => RegistrationStatus::Refunded,
                'paid_at' => (clone $demoStart)->subDays(8)->setTime(9, 0),
                'verified_at' => (clone $demoStart)->subDays(7)->setTime(9, 45),
                'proof' => 'payments/demo-refunded.jpg',
                'refund' => [
                    'status' => RefundStatus::Completed,
                    'requested_at' => (clone $demoStart)->subDays(6)->setTime(13, 15),
                    'processed_at' => (clone $demoStart)->subDays(4)->setTime(15, 0),
                ],
            ],
        ];

        $users
            ->shuffle()
            ->take(count($transactionScenarios))
            ->values()
            ->each(function (User $participant, int $index) use ($transactionScenarios, $demoEvent, $faker) {
                $scenario = $transactionScenarios[$index];

                $registeredAt = $demoEvent->start_at->copy()->subDays(10)->setTime(9 + $index, 0);

                $registration = Registration::factory()
                    ->for($participant)
                    ->for($demoEvent)
                    ->state([
                        'status' => $scenario['registration_status'],
                        'registered_at' => $registeredAt,
                        'form_data' => [
                            'full_name' => $participant->name,
                            'email' => $participant->email,
                            'phone' => $faker->phoneNumber(),
                            'organization' => $faker->company(),
                        ],
                    ])
                    ->create();

                $transaction = Transaction::factory()
                    ->for($registration)
                    ->state([
                        'amount' => $demoEvent->price,
                        'status' => $scenario['status'],
                        'payment_proof_path' => $scenario['proof'] ?? (isset($scenario['paid_at']) ? 'payments/proof-' . Str::uuid() . '.jpg' : null),
                        'paid_at' => $scenario['paid_at'] ?? null,
                        'verified_at' => $scenario['verified_at'] ?? null,
                    ])
                    ->create();

                if (isset($scenario['refund'])) {
                    Refund::factory()
                        ->for($transaction)
                        ->state([
                            'status' => $scenario['refund']['status'],
                            'reason' => $faker->sentence(),
                            'admin_note' => $faker->sentence(),
                            'requested_at' => $scenario['refund']['requested_at'],
                            'processed_at' => $scenario['refund']['processed_at'],
                        ])
                        ->create();
                }
            });
    }
}
