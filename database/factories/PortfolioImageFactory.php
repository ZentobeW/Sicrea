<?php

namespace Database\Factories;

use App\Models\PortfolioImage;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<PortfolioImage>
 */
class PortfolioImageFactory extends Factory
{
    protected $model = PortfolioImage::class;

    public function definition(): array
    {
        return [
            'path' => 'portfolio-gallery/demo-' . $this->faker->uuid() . '.jpg',
            'caption' => $this->faker->boolean(60) ? $this->faker->sentence(6) : null,
            'display_order' => 0,
        ];
    }
}
