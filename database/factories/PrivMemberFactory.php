<?php

namespace Database\Factories;

use App\Models\PrivMember;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\PrivMember>
 */
class PrivMemberFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = PrivMember::class;

    public function definition(): array
    {
        return [
            'priv_member_name' => $this->faker->name(),
            'priv_member_sl_no' => $this->faker->unique()->numerify('SL-####'),
            'priv_member_father' => $this->faker->name('male'),
            'priv_member_spouse' => $this->faker->name('female'),
            'priv_member_occupation_id' => $this->faker->numberBetween(1, 5),
            'priv_member_designation_id' => $this->faker->numberBetween(1, 5),
            'priv_member_office_institute' => $this->faker->company,
            'priv_member_address' => $this->faker->address,
            'priv_member_phone_office' => $this->faker->phoneNumber,
            'priv_member_phone_mobile' => $this->faker->phoneNumber,
            'priv_member_phone_residence' => $this->faker->phoneNumber,
            'priv_member_blood' => $this->faker->randomElement(['A+', 'A-', 'B+', 'B-', 'AB+', 'AB-', 'O+', 'O-']),
            'priv_member_date' => $this->faker->date(),
            'priv_member_saved_by' => $this->faker->numberBetween(1, 3),
            'priv_member_save_status' => $this->faker->numberBetween(0, 1),
            'priv_member_timestamp' => now(),
            'priv_member_transport_id' => $this->faker->numberBetween(1, 10),
            'general_member_id' => $this->faker->numberBetween(1, 10),
            'pic_name' => $this->faker->imageUrl(200, 200, 'people', true, 'Pic'),
        ];
    }
}
