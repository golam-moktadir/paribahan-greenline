<?php

namespace Database\Seeders;

use App\Models\Employee;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class EmployeeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $path = database_path('samplesql/employee_insert_data.sql');

        if (File::exists($path)) {
            $sql = File::get($path);
            DB::unprepared($sql);

            // Employee::factory()->count(50)->create();

        } else {
            $this->command->error("SQL file not found at: $path");
        }

        // $startId = Employee::max('employee_id') + 1;

        // $count = 10;

        // foreach (range(0, $count - 1) as $i) {
        //     Employee::factory()->create([
        //         'employee_id' => $startId + $i,
        //     ]);
        // }

    }
}
