<?php

namespace Database\Factories;

use App\Models\Permission;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Permission>
 */
class PermissionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

    protected $model = Permission::class;

    public function definition(): array
    {
        return [
            'employee_id' => $this->faker->numberBetween(1, 10),
            'page_id' => $this->faker->numberBetween(1, 20),
            'permission_view' => $this->faker->numberBetween(0, 1),
            'permission_insert' => $this->faker->numberBetween(0, 1),
            'permission_update' => $this->faker->numberBetween(0, 1),
            'permission_delete' => $this->faker->numberBetween(0, 1),
            'permission_saved_by' => $this->faker->numberBetween(1, 5),
            'permission_save_status' => $this->faker->numberBetween(0, 1),
            'permission_time_stamp' => $this->faker->dateTimeThisYear(),
        ];
    }
}
