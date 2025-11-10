<?php

namespace Database\Factories;

use App\Enums\EventStatus;
use App\Models\Event;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Event>
 */
class EventFactory extends Factory
{
    protected $model = Event::class;

    public function definition(): array
    {
        $title = $this->faker->sentence(4);
        $startAt = $this->faker->dateTimeBetween('+1 week', '+3 months');
        $endAt = Carbon::instance($startAt)->addHours($this->faker->numberBetween(2, 8));
        $status = $this->faker->randomElement(EventStatus::cases());
        $capacity = $this->faker->numberBetween(15, 80);
        $booked = $this->faker->numberBetween(0, (int) floor($capacity * 0.7));

        return [
            'title' => $title,
            'description' => $this->faker->paragraphs(3, true),
            'start_at' => $startAt,
            'end_at' => $endAt,
            'venue_name' => $this->faker->company() . ' Studio',
            'venue_address' => $this->faker->streetAddress() . ', ' . $this->faker->city(),
            'tutor_name' => $this->faker->name(),
            'capacity' => $capacity,
            'available_slots' => max($capacity - $booked, 0),
            'price' => $this->faker->numberBetween(100_000, 650_000),
            'status' => $status,
            'published_at' => $status === EventStatus::Published
                ? Carbon::instance($startAt)->subDays($this->faker->numberBetween(5, 20))
                : null,
        ];
    }

    public function published(): static
    {
        return $this->state(function (array $attributes) {
            $startAt = isset($attributes['start_at'])
                ? Carbon::parse($attributes['start_at'])
                : Carbon::now()->addWeeks(2);

            return [
                'status' => EventStatus::Published,
                'published_at' => Carbon::parse($attributes['published_at'] ?? $startAt)->subDays(7),
                'available_slots' => $attributes['capacity'] ?? 40,
            ];
        });
    }

    public function draft(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => EventStatus::Draft,
            'published_at' => null,
        ]);
    }

    public function archived(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => EventStatus::Archived,
            'published_at' => null,
        ]);
    }
}
