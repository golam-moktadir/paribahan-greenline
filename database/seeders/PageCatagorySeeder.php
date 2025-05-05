<?php

namespace Database\Seeders;

use App\Models\PageCatagory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PageCatagorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        PageCatagory::factory()->count(10)->create();
    }
}
