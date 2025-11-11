<?php

namespace Database\Factories;

use App\Enums\RegistrationStatus;
use App\Models\Event;
use App\Models\Registration;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

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
            'form_data' => [
                'full_name' => $this->faker->name(),
                'email' => $this->faker->safeEmail(),
                'phone' => $this->faker->phoneNumber(),
                'organization' => $this->faker->company(),
            ],
            'registered_at' => $registeredAt,
            'notes' => null,
        ];
    }
}
