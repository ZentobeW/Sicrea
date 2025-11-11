<?php

namespace Database\Factories;

use App\Enums\PaymentStatus;
use App\Models\Registration;
use App\Models\Transaction;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Arr;

/**
 * @extends Factory<Transaction>
 */
class TransactionFactory extends Factory
{
    protected $model = Transaction::class;

    public function definition(): array
    {
        $paidAt = $this->faker->optional()->dateTimeBetween('-1 month', 'now');
        $status = $paidAt ? PaymentStatus::AwaitingVerification : PaymentStatus::Pending;

        return [
            'registration_id' => Registration::factory(),
            'amount' => $this->faker->numberBetween(100_000, 650_000),
            'status' => $status,
            'payment_method' => config('payment.method', 'Virtual Account'),
            'payment_proof_path' => $paidAt ? 'payments/' . Arr::random(['proof1.jpg', 'proof2.jpg', 'proof3.jpg']) : null,
            'paid_at' => $paidAt,
            'verified_at' => null,
        ];
    }

    public function verified(): static
    {
        return $this->state(function (array $attributes) {
            $paidAt = $attributes['paid_at'] ?? now()->subDay();

            return [
                'status' => PaymentStatus::Verified,
                'paid_at' => $paidAt,
                'verified_at' => $attributes['verified_at'] ?? now(),
                'payment_proof_path' => $attributes['payment_proof_path'] ?? 'payments/' . Arr::random(['proof1.jpg', 'proof2.jpg', 'proof3.jpg']),
            ];
        });
    }

    public function refunded(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => PaymentStatus::Refunded,
            'verified_at' => $attributes['verified_at'] ?? now(),
        ]);
    }
}
