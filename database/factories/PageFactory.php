<?php

namespace Database\Factories;

use App\Models\Page;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Page>
 */
class PageFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Page::class;

    public function definition(): array
    {
        return [
            'page_name' => $this->faker->name(),
            'page_title' => $this->faker->name(),
            'page_is_admin' => $this->faker->randomElement([0, 1]),
            'page_desc' => $this->faker->name(),
            'page_view_level' => $this->faker->numberBetween(1, 99),
            'page_saved_by' => $this->faker->numberBetween(1, 99),
            'page_save_status' => $this->faker->randomElement([0, 1]),
            'page_time_stamp' => $this->faker->dateTimeThisYear(),
            'page_type_id' => $this->faker->numberBetween(1, 99),
        ];
    }
}
