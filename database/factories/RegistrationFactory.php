<?php

namespace Database\Factories;

use App\Enums\PaymentStatus;
use App\Enums\RegistrationStatus;
use App\Models\Event;
use App\Models\Registration;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Arr;

/**
 * @extends Factory<Registration>
 */
class RegistrationFactory extends Factory
{
    protected $model = Registration::class;

    public function definition(): array
    {
        $registeredAt = $this->faker->dateTimeBetween('-1 month', '+1 week');

        return [
            'user_id' => User::factory(),
            'event_id' => Event::factory(),
            'status' => RegistrationStatus::Pending,
            'payment_status' => PaymentStatus::Pending,
            'amount' => $this->faker->numberBetween(100_000, 650_000),
            'payment_proof_path' => null,
            'form_data' => [
                'full_name' => $this->faker->name(),
                'email' => $this->faker->safeEmail(),
                'phone' => $this->faker->phoneNumber(),
                'organization' => $this->faker->company(),
            ],
            'registered_at' => $registeredAt,
            'paid_at' => null,
            'verified_at' => null,
        ];
    }

    public function awaitingVerification(): static
    {
        return $this->state(function (array $attributes) {
            $paidAt = $attributes['paid_at'] ?? now();

            return [
                'status' => RegistrationStatus::Pending,
                'payment_status' => PaymentStatus::AwaitingVerification,
                'payment_proof_path' => $attributes['payment_proof_path'] ?? 'payments/' . Arr::random(['proof1.jpg', 'proof2.jpg', 'proof3.jpg']),
                'paid_at' => $paidAt,
                'verified_at' => null,
            ];
        });
    }

    public function verified(): static
    {
        return $this->state(function (array $attributes) {
            $paidAt = $attributes['paid_at'] ?? now()->subDay();

            return [
                'status' => RegistrationStatus::Confirmed,
                'payment_status' => PaymentStatus::Verified,
                'payment_proof_path' => $attributes['payment_proof_path'] ?? 'payments/' . Arr::random(['proof1.jpg', 'proof2.jpg', 'proof3.jpg']),
                'paid_at' => $paidAt,
                'verified_at' => $attributes['verified_at'] ?? now(),
            ];
        });
    }

    public function refunded(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => RegistrationStatus::Refunded,
            'payment_status' => PaymentStatus::Refunded,
        ]);
    }
}
