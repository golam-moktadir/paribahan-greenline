<?php

namespace Database\Seeders;

use App\Models\Driver;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class DriverSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        foreach (range(1, 20) as $i) {
            Driver::create([
                'transport_id' => $faker->numberBetween(37, 43),
                'department_id' => $faker->numberBetween(1, 5),
                'full_name' => $faker->name(),
                'father_name' => $faker->name('male'),
                'birth_date' => $faker->date('Y-m-d', '-15 years'),
                'phone' => $faker->regexify('0[0-9]{9,10}'), // Starts with 0, 10-11 digits
                'id_no' => 'DID' . $faker->numerify('#######'), // 10 digit
                'nid_no' => $faker->numerify('###############'), // 15 digit
                'driving_license_no' => 'DL' . $faker->numerify('################'), // 18 digit
                'insurance_no' => 'INS' . $faker->numerify('################'), // 18 digit
                'present_address' => $faker->address(),
                'permanent_address' => $faker->address(),
                'pre_experience' => $faker->numberBetween(0, 75),
                'joining_date' => $faker->date('Y-m-d'),
                'status' => $faker->numberBetween(0, 2),
                'reference' => $faker->name(),
                'avatar_url' => $faker->imageUrl(200, 200, 'people', true),
                'nid_attachment' => $faker->imageUrl(200, 200, 'nid', true),
                'driving_license_attachment' => $faker->imageUrl(200, 200, 'license', true),
                'insurance_attachment' => $faker->imageUrl(200, 200, 'insurance', true),
                'created_by' => 1,
            ]);
        }

    }
}
