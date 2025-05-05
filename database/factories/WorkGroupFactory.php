<?php

namespace Database\Factories;

use App\Models\WorkGroup;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\WorkGroup>
 */
class WorkGroupFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

    protected $model = WorkGroup::class;

    public function definition(): array
    {
        return [
            "work_group_name" => $this->faker->name,
            "work_group_saved_by" => $this->faker->numberBetween(1, 50),
            "work_group_save_status" => $this->faker->numberBetween(0, 1),
            "work_group_timestamp" => $this->faker->dateTimeThisYear(),
        ];
    }
}
