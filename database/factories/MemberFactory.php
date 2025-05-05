<?php

namespace Database\Factories;

use App\Models\Member;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Member>
 */
class MemberFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Member::class;

    public function definition(): array
    {
        return [
            'member_type_id' => $this->faker->numberBetween(1, 99),
            'member_login' => $this->faker->userName(),
            'member_password' => 'pass1234',
            'member_new_password' => Hash::make('pass1234'),
            'member_email' => fake()->unique()->safeEmail(),
            'member_activation_id' => $this->faker->numberBetween(1, 99),
            'member_timestamp' => $this->faker->dateTimeThisYear(),
            'member_save_status' => $this->faker->randomElement([0, 1]),
            'pass_changed' => $this->faker->randomElement([0, 1]),
        ];
    }
}
