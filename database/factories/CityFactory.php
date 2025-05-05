<?php

namespace Database\Factories;

use App\Models\City;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\City>
 */
class CityFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = City::class;

    public function definition(): array
    {
        return [
            // 'city_id' => $this->faker->unique()->numberBetween(1, 10000),
            'city_name' => $this->faker->city(),
            'city_code' => $this->faker->countryCode(),
            'city_image_name' => $this->faker->imageUrl,
            'sms_available' => $this->faker->numberBetween(0, 1),
            'city_saved_by' => $this->faker->numberBetween(1, 100),
            'city_save_status' => $this->faker->randomElement([0, 1]),
            'city_timestamp' => $this->faker->dateTimeThisYear(),
        ];
    }
}
