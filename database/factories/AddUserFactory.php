<?php

namespace Database\Factories;

use App\Models\AddUser;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\AddUser>
 */
class AddUserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

    protected $model = AddUser::class;

    public function definition(): array
    {
        return [
            'user_password' => "pass1234",
            'user_new_password' => Hash::make('pass1234'),
            'user_save_time' => $this->faker->dateTimeThisYear(),
        ];
    }
}
