<?php

namespace Database\Seeders;

use App\Models\PageAccessType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PageAccessTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        PageAccessType::factory()->count(10)->create();
    }
}
