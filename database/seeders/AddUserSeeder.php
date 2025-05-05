<?php

namespace Database\Seeders;

use App\Models\AddUser;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AddUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        AddUser::factory()->count(5)->create();
    }
}
