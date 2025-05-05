<?php

namespace Database\Factories;

use App\Models\PageCatagory;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\PageCatagory>
 */
class PageCatagoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

    protected $model = PageCatagory::class;

    public function definition(): array
    {
        return [
            'page_catagory_type' => $this->faker->name(),
            'page_catagory_saved_by' => $this->faker->numberBetween(1, 99),
            'page_catagory_save_status' => $this->faker->randomElement([0, 1]),
            'page_catagory_timestamp' => $this->faker->dateTimeThisYear(),
        ];
    }
}
