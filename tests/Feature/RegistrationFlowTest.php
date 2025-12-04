<?php

namespace Tests\Feature;

use App\Enums\EventStatus;
use App\Enums\PaymentStatus;
use App\Enums\RegistrationStatus;
use App\Models\Event;
use App\Models\Registration;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RegistrationFlowTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_register_again_after_refund(): void
    {
        $user = User::factory()->create([
            'phone' => '08123456789',
            'province' => 'Jawa Barat',
            'city' => 'Bandung',
            'address' => 'Jalan Braga 1',
        ]);

        $event = Event::create([
            'title' => 'Test Event',
            'description' => 'Desc',
            'start_at' => now()->addDays(3),
            'end_at' => now()->addDays(3)->addHours(2),
            'venue_name' => 'Hall A',
            'venue_address' => 'Address',
            'tutor_name' => 'Tutor',
            'capacity' => 10,
            'price' => 100_000,
            'status' => EventStatus::Published,
            'published_at' => now(),
        ]);

        $refunded = Registration::create([
            'user_id' => $user->id,
            'event_id' => $event->id,
            'status' => RegistrationStatus::Refunded,
            'form_data' => [],
            'registered_at' => now()->subDay(),
        ]);

        $refunded->transaction()->create([
            'amount' => $event->price,
            'status' => PaymentStatus::Refunded,
            'payment_method' => 'Virtual Account',
        ]);

        $this
            ->actingAs($user)
            ->get(route('events.register', $event))
            ->assertOk();
    }

    public function test_pending_registration_holds_capacity(): void
    {
        $userOne = User::factory()->create([
            'phone' => '08123456780',
            'province' => 'Jawa Barat',
            'city' => 'Bandung',
            'address' => 'Jalan Merdeka 1',
        ]);

        $userTwo = User::factory()->create([
            'phone' => '08123456781',
            'province' => 'Jawa Barat',
            'city' => 'Bandung',
            'address' => 'Jalan Merdeka 2',
        ]);

        $event = Event::create([
            'title' => 'Full Event',
            'description' => 'Desc',
            'start_at' => now()->addDays(1),
            'end_at' => now()->addDays(1)->addHours(2),
            'venue_name' => 'Hall B',
            'venue_address' => 'Address',
            'tutor_name' => 'Tutor',
            'capacity' => 1,
            'price' => 150_000,
            'status' => EventStatus::Published,
            'published_at' => now(),
        ]);

        $pending = Registration::create([
            'user_id' => $userOne->id,
            'event_id' => $event->id,
            'status' => RegistrationStatus::Pending,
            'form_data' => [],
            'registered_at' => now(),
        ]);

        $pending->transaction()->create([
            'amount' => $event->price,
            'status' => PaymentStatus::AwaitingVerification,
            'payment_method' => 'Virtual Account',
        ]);

        $this
            ->actingAs($userTwo)
            ->from(route('events.register', $event))
            ->post(route('events.register.store', $event), [
                'form_data' => [
                    'name' => $userTwo->name,
                    'email' => $userTwo->email,
                    'phone' => $userTwo->phone,
                    'bank_name' => 'BCA',
                    'account_number' => '123456789',
                    'company' => null,
                ],
            ])
            ->assertRedirect(route('events.register', $event))
            ->assertSessionHasErrors('event');
    }
}
