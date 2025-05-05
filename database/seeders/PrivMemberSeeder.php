<?php

namespace Database\Seeders;

use App\Models\PrivMember;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PrivMemberSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        PrivMember::factory()->count(10)->create();
    }
}
