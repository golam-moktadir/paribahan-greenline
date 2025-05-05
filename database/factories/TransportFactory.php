<?php

namespace Database\Factories;

use App\Models\Transport;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Transport>
 */
class TransportFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Transport::class;

    public function definition(): array
    {
        return [
            'transport_name' => $this->faker->name,
            'transport_organization_name' => $this->faker->name,
            'transport_short_name' => $this->faker->userName(),
            'transport_address' => $this->faker->address,
            'transport_total_station' => $this->faker->numberBetween(1, 50),
            'transport_total_bus' => $this->faker->numberBetween(1, 100),
            'transport_total_employee' => $this->faker->numberBetween(1, 500),
            'transport_total_route' => $this->faker->numberBetween(1, 10),
            'transport_city_id' => $this->faker->numberBetween(1, 100),
            'transport_postcode' => (int) $this->faker->numerify(str_repeat('#', rand(4, 6))),
            'transport_date_of_establishment' => $this->faker->date(),
            'transport_phone' => $this->faker->phoneNumber,
            'transport_mobile' => $this->faker->phoneNumber,
            'transport_fax' => $this->faker->phoneNumber,
            'transport_email' => $this->faker->safeEmail,
            'transport_web' => $this->faker->url,
            'transport_owner_name' => $this->faker->name,
            'transport_owner_phone' => $this->faker->phoneNumber,
            'transport_owner_mobile' => $this->faker->phoneNumber,
            'transport_owner_email' => $this->faker->safeEmail,
            'transport_owner_fax' => $this->faker->phoneNumber,
            'transport_interest_1' => $this->faker->numberBetween(0, 1),
            'transport_interest_2' => $this->faker->numberBetween(0, 1),
            'transport_interest_3' => $this->faker->numberBetween(0, 1),
            'transport_interest_4' => $this->faker->numberBetween(0, 1),
            'transport_interest_5' => $this->faker->numberBetween(0, 1),
            'transport_interest_6' => $this->faker->numberBetween(0, 1),
            'transport_comments' => $this->faker->sentence,
            'transport_administrative_login' => $this->faker->userName,
            'transport_administrative_password' => 'password1234',
            'image_id' => $this->faker->numberBetween(1, 50),
            'transport_homepage_text' => $this->faker->sentence,
            'transport_saved_by' => $this->faker->numberBetween(1, 10),
            'transport_save_status' => $this->faker->numberBetween(0, 1),
            'server_ip' => $this->faker->ipv4,
            'transport_rank' => $this->faker->numberBetween(1, 10),
            'transport_timestamp' => now(),
            'server_lan_ip' => $this->faker->ipv4,
            'transport_code' => $this->faker->countryCode(),
        ];
    }
}
