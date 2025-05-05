<?php

namespace Database\Seeders;

use App\Models\Department;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class DepartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        // $departments = [
        //     ['id' => 2, 'name' => 'Marketing'],
        //     ['id' => 3, 'name' => 'Finance'],
        //     ['id' => 4, 'name' => 'Management'],
        //     ['id' => 5, 'name' => 'Accounting'],
        //     ['id' => 6, 'name' => 'Sales'],
        // ];

        // foreach ($departments as $department) {
        //     Department::updateOrCreate(
        //         ['department_id' => $department['id']],
        //         [
        //             'department_name' => $department['name'],
        //             'department_save_status' => 0
        //         ]
        //     );
        // }

        $path = database_path('samplesql/department_insert_data.sql');

        if (File::exists($path)) {
            $sql = File::get($path);
            DB::unprepared($sql);

            // Department::factory()->count(1000)->create();

        } else {
            $this->command->error("SQL file not found at: $path");
        }

    }
}
