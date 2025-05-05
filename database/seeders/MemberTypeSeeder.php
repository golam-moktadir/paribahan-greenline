<?php

namespace Database\Seeders;

use App\Models\MemberType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class MemberTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $path = database_path('samplesql/member_type_insert_data.sql');

        if (File::exists($path)) {
            $sql = File::get($path);
            DB::unprepared($sql);

            // MemberType::factory()->count(7)->create();

        } else {
            $this->command->error("SQL file not found at: $path");
        }

    }
}
