<?php

namespace Database\Seeders;

use App\Models\WorkGroup;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class WorkGroupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // $workGroups = [
        //     ['id' => 1, 'name' => 'Admin'],
        //     ['id' => 2, 'name' => 'Owner'],
        //     ['id' => 3, 'name' => 'Manager'],
        //     ['id' => 4, 'name' => 'Driver'],
        //     ['id' => 5, 'name' => 'Conductor'],
        //     ['id' => 6, 'name' => 'Supervisor'],
        //     ['id' => 7, 'name' => 'Sales Executive'],
        // ];

        // // Insert into work_groups table
        // foreach ($workGroups as $workGroup) {
        //     WorkGroup::updateOrCreate(
        //         ['work_group_id' => $workGroup['id']],
        //         [
        //             'work_group_name' => $workGroup['name'],
        //             'work_group_save_status' => 0
        //         ]
        //     );
        // }

        $path = database_path('samplesql/work_group_insert_data.sql');

        if (File::exists($path)) {
            $sql = File::get($path);
            DB::unprepared($sql);

            // WorkGroup::factory()->count(1000)->create();

        } else {
            $this->command->error("SQL file not found at: $path");
        }



    }
}
