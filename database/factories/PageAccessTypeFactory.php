<?php

namespace Database\Factories;

use App\Models\PageAccessType;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\PageAccessType>
 */
class PageAccessTypeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = PageAccessType::class;

    public function definition(): array
    {
        return [
            'page_access_type_name' => $this->faker->name(),
            'page_catagory_id' => $this->faker->numberBetween(1, 99),
            'page_access_type_url' => $this->faker->name(),
            'page_access_type_saved_by' => $this->faker->numberBetween(1, 99),
            'page_access_type_save_status' => $this->faker->randomElement([0, 1]),
            'page_access_type_timestamp' => $this->faker->dateTimeThisYear(),
        ];
    }
}
