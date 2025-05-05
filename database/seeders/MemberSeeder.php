<?php

namespace Database\Seeders;

use App\Models\Member;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class MemberSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $path = database_path('samplesql/member_insert_data.sql');

        if (File::exists($path)) {
            $sql = File::get($path);
            DB::unprepared($sql);

            // Member::factory()->count(6)->create();

        } else {
            $this->command->error("SQL file not found at: $path");
        }

        // Ensure top member with ID  1 exists
        $superSuperAdmin = Member::find(1, 'member_id');

        if (!$superSuperAdmin) {
            Member::create([
                'member_id' => 1,
                'member_type_id' => 1,
                'member_login' => 'ssuperadmin',
                // 'member_email' => 'ssuperadmin@domain.com',
                'member_password' => bcrypt('super@123'),
                'member_new_password' => bcrypt('super@123'),
                'member_activation_id' => 0,
            ]);

            $this->command->info('Top Member with ID 1 created.');
        } else {
            $this->command->info('Top Member with ID 1 already exists.');
        }


    }
}
