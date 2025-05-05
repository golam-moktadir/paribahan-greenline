<?php

namespace Database\Factories;

use App\Models\Department;
use App\Models\Employee;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Employee>
 */
class EmployeeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Employee::class;

    public function definition(): array
    {
        // random birth date (between 15 and 75 years ago)
        $birthDate = $this->faker->dateTimeBetween('-75 years', '-15 years')->format('Y-m-d');

        // joining date (at least 15 years after birth date)
        $birth = \Carbon\Carbon::parse($birthDate);
        $joiningDate = $this->faker->dateTimeBetween($birth->addYears(15), 'now')->format('Y-m-d');

        return [
            'transport_id' => $this->faker->numberBetween(37, 43),
            'department_id' => $this->faker->numberBetween(1, 5),
            'work_group_id' => $this->faker->numberBetween(1, 7),
            'employee_name' => $this->faker->name(),
            'employee_login' => $this->faker->unique()->userName(),
            'employee_password' => 'pass1234',
            'employee_new_password' => '$2y$12$uR/ZXAh6wEF4RHVGTkBn6eowoTe.ixMkSZx6qJrF8kMxTQJjvAvgW',
            // 'employee_new_password' => $this->faker->password(8, 30, true, true, true), // Mixed case, numbers, symbols
            'employee_birth_date' => $birthDate,
            'employee_joining_date' => $joiningDate,
            'employee_permanent_address' => $this->faker->streetAddress(),
            'employee_present_address' => $this->faker->streetAddress(),
            'employee_phone' => $this->faker->regexify('0[0-9]{9,10}'), // Starts with 0, 10-11 digits
            'employee_pre_experience' => $this->faker->numberBetween(0, 75),
            'employee_reference' => $this->faker->name(),
            'employee_save_status' => $this->faker->randomElement([0, 1]),
            'employee_timestamp' => $this->faker->dateTimeThisYear(),
            'employee_signature' => $this->faker->regexify('[a-zA-Z]{3,30}'), // Nullable
            'can_cancel_sold' => $this->faker->randomElement([0, 1]),
            'can_book' => $this->faker->randomElement([0, 1]),
            'can_sell_complimentary' => $this->faker->randomElement([0, 1]),
            'can_gave_discount' => $this->faker->randomElement([0, 1]),
            'max_discount' => $this->faker->numberBetween(0, 10000),
            'can_cancel_web_ticket' => $this->faker->randomElement([0, 1]),
            'employee_identity' => $this->faker->unique()->regexify('[A-Z][0-9]{8}'), // Nullable
            'nid_no' => $this->faker->unique()->regexify('[0-9]{8,20}'), // Nullable
            'birth_no' => $this->faker->unique()->regexify('[0-9]{8,20}'), // Nullable
            'avatar_url' => $this->faker->optional()->imageUrl(200, 200, 'people', true, 'avatar'),
            'employee_saved_by' => $this->faker->numberBetween(1, 10),
            'employee_activation_id' => (string) Str::uuid(), // From prepareForValidation
        ];
    }
}
