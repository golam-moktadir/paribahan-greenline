<?php

namespace Database\Factories;

use App\Models\MemberType;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\MemberType>
 */
class MemberTypeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = MemberType::class;

    public function definition(): array
    {
        return [
            // 'member_type_id' => $this->faker->unique()->numberBetween(1, 10), 
            'member_type_name' => $this->faker->word(),
            'member_type_url' => $this->faker->url(),
            'member_type_saved_by' => $this->faker->numberBetween(1, 99999),
            'member_type_save_status' => $this->faker->randomElement([0, 1]),
            'member_type_timestamp' => $this->faker->dateTimeThisYear(),
        ];
    }
}
