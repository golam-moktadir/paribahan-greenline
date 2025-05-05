<?php

namespace Database\Factories;

use App\Models\Image;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Image>
 */
class ImageFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Image::class;

    public function definition(): array
    {
        return [
            'image_description' => $this->faker->sentence(),
            'image_bin_data' => $this->faker->countryCode(),
            'image_name' => $this->faker->imageUrl,
            'image_size' => $this->faker->numberBetween(1, 5000),
            'image_type' => $this->faker->word(),
            'image_location' => $this->faker->imageUrl(),
        ];
    }
}
