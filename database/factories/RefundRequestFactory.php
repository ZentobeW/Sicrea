<?php

namespace Database\Factories;

use App\Enums\RefundStatus;
use App\Models\RefundRequest;
use App\Models\Registration;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<RefundRequest>
 */
class RefundRequestFactory extends Factory
{
    protected $model = RefundRequest::class;

    public function definition(): array
    {
        $requestedAt = $this->faker->dateTimeBetween('-2 weeks', 'now');

        return [
            'registration_id' => Registration::factory(),
            'status' => RefundStatus::Pending,
            'reason' => $this->faker->sentence(),
            'admin_note' => null,
            'requested_at' => $requestedAt,
            'processed_at' => null,
        ];
    }

    public function approved(): static
    {
        return $this->state(function (array $attributes) {
            $processedAt = $attributes['processed_at'] ?? Carbon::now();

            return [
                'status' => RefundStatus::Approved,
                'admin_note' => $attributes['admin_note'] ?? $this->faker->sentence(),
                'processed_at' => $processedAt,
            ];
        });
    }

    public function rejected(): static
    {
        return $this->state(function (array $attributes) {
            $processedAt = $attributes['processed_at'] ?? Carbon::now();

            return [
                'status' => RefundStatus::Rejected,
                'admin_note' => $attributes['admin_note'] ?? $this->faker->sentence(),
                'processed_at' => $processedAt,
            ];
        });
    }

    public function completed(): static
    {
        return $this->state(function (array $attributes) {
            $processedAt = $attributes['processed_at'] ?? Carbon::now();

            return [
                'status' => RefundStatus::Completed,
                'admin_note' => $attributes['admin_note'] ?? $this->faker->sentence(),
                'processed_at' => $processedAt,
            ];
        });
    }
}
