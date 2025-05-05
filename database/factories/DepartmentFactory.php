<?php

namespace Database\Factories;

use App\Models\Department;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Department>
 */
class DepartmentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Department::class;

    public function definition(): array
    {
        return [
            'department_name' => $this->faker->city(),
            'department_saved_by' => $this->faker->numberBetween(1, 50),
            'department_save_status' => $this->faker->randomElement([0, 1]),
            'department_timestamp' => $this->faker->dateTimeThisYear(),
        ];
    }
}
