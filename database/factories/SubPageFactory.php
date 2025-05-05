<?php

namespace Database\Factories;

use App\Models\SubPage;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\SubPage>
 */
class SubPageFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = SubPage::class;

    public function definition(): array
    {
        return [
            'page_id' => $this->faker->numberBetween(1, 99),
            'subpage_name' => $this->faker->name(),
            'subpage_title' => $this->faker->name(),
            'subpage_saved_by' => $this->faker->numberBetween(1, 99),
            'subpage_save_status' => $this->faker->randomElement([0, 1]),
            'subpage_timestamp' => $this->faker->dateTimeThisYear(),
        ];
    }
}
