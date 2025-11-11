<?php

namespace Database\Factories;

use App\Models\Event;
use App\Models\Portfolio;
use App\Models\PortfolioImage;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Portfolio>
 */
class PortfolioFactory extends Factory
{
    protected $model = Portfolio::class;

    public function configure(): static
    {
        return $this->afterCreating(function (Portfolio $portfolio) {
            $imageCount = $this->faker->numberBetween(1, 4);

            PortfolioImage::factory($imageCount)->create([
                'portfolio_id' => $portfolio->id,
            ]);
        });
    }

    public function definition(): array
    {
        return [
            'event_id' => Event::factory(),
            'title' => $this->faker->sentence(6),
            'description' => $this->faker->paragraph(),
            'media_url' => $this->faker->boolean(70) ? $this->faker->imageUrl(1280, 720, 'business', true) : null,
        ];
    }
}
