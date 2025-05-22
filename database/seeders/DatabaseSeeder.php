<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        $this->call([
            AddUserSeeder::class,
            WorkGroupSeeder::class,
            MemberTypeSeeder::class,
            MemberSeeder::class,
            PageCatagorySeeder::class,
            CitySeeder::class,
            TransportSeeder::class,
            PageAccessTypeSeeder::class,
            PageSeeder::class,
            SubPageSeeder::class,
            PrivMemberSeeder::class,
            PermissionSeeder::class,
            RoleSeeder::class,
            ImageSeeder::class,
            DepartmentSeeder::class,
            EmployeeSeeder::class,
            DriverSeeder::class,
            CategorySeeder::class,

        ]);

    }
}
