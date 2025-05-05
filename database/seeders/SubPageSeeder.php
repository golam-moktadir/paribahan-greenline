<?php

namespace Database\Seeders;

use App\Models\SubPage;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SubPageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        SubPage::factory()->count(10)->create();
    }
}
