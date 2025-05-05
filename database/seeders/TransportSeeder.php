<?php

namespace Database\Seeders;

use App\Models\Transport;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class TransportSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $transports = [
            // 37: greenline
            // [
            //     'transport_id' => 37,
            //     'transport_name' => 'Green Line',
            //     'transport_organization_name' => 'Green Line',
            //     'transport_short_name' => 'Greenline',
            //     'transport_address' => '9/2 Outer Circular Road, Momenbagh, Rajarbagh, Dhaka',
            //     'transport_total_station' => 10,
            //     'transport_total_bus' => 15,
            //     'transport_total_employee' => 75,
            //     'transport_total_route' => 1,
            //     'transport_city_id' => 1,
            //     'transport_postcode' => 0,
            //     'transport_date_of_establishment' => '1988-02-15',
            //     'transport_phone' => '9339623, 8353005',
            //     'transport_mobile' => '',
            //     'transport_fax' => '',
            //     'transport_email' => 'green@hotmail.com',
            //     'transport_web' => 'http://www.greenlinebd.com',
            //     'transport_owner_name' => 'green',
            //     'transport_owner_phone' => '9339623',
            //     'transport_owner_mobile' => '',
            //     'transport_owner_email' => '',
            //     'transport_owner_fax' => '',
            //     'transport_comments' => '',
            //     'transport_administrative_login' => 'greenline1',
            //     'transport_administrative_password' => '000111',
            //     'image_id' => 4,
            //     'transport_homepage_text' => '',
            //     'transport_saved_by' => 0,
            //     'transport_save_status' => 0,
            //     'server_ip' => '127.0.0.1',
            //     'transport_rank' => 2,
            //     'server_lan_ip' => '127.0.0.1',
            //     'transport_code' => null,
            //     'transport_interest_2' => 2,
            // ],
            // 38: SR Travels
            [
                'transport_id' => 38,
                'transport_name' => 'SR Travels',
                'transport_organization_name' => 'SR Travels',
                'transport_short_name' => 'Srtravels',
                'transport_address' => 'Dhaka',
                'transport_total_station' => 9,
                'transport_total_bus' => 6,
                'transport_total_employee' => 12,
                'transport_total_route' => 1,
                'transport_city_id' => 1,
                'transport_postcode' => 1216,
                'transport_date_of_establishment' => '1990-02-15',
                'transport_phone' => '19339623, 18353005',
                'transport_mobile' => '',
                'transport_fax' => '',
                'transport_email' => '',
                'transport_web' => '',
                'transport_owner_name' => '',
                'transport_owner_phone' => '',
                'transport_owner_mobile' => '',
                'transport_owner_email' => 'srtravels@gmail.com',
                'transport_owner_fax' => '',
                'transport_comments' => '',
                'transport_administrative_login' => 'srtravels1',
                'transport_administrative_password' => '000112',
                'image_id' => 1,
                'transport_homepage_text' => '',
                'transport_saved_by' => 1,
                'transport_save_status' => 0,
                'server_ip' => '127.0.0.1',
                'transport_rank' => 2,
                'server_lan_ip' => '127.0.0.1',
                'transport_code' => null,
                'transport_interest_2' => 1
            ],
            // 39: Hanif Enterprise
            [
                'transport_id' => 39,
                'transport_name' => 'Hanif Enterprise',
                'transport_organization_name' => 'Hanif Enterprise',
                'transport_short_name' => 'Hanif',
                'transport_address' => '',
                'transport_total_station' => 9,
                'transport_total_bus' => 6,
                'transport_total_employee' => 12,
                'transport_total_route' => 1,
                'transport_city_id' => 1,
                'transport_postcode' => 1219,
                'transport_date_of_establishment' => '1990-02-15',
                'transport_phone' => '19339623, 18353005',
                'transport_mobile' => '',
                'transport_fax' => '',
                'transport_email' => '',
                'transport_web' => '',
                'transport_owner_name' => '',
                'transport_owner_phone' => '',
                'transport_owner_mobile' => '',
                'transport_owner_email' => 'hanif@gmail.com',
                'transport_owner_fax' => '',
                'transport_comments' => '',
                'transport_administrative_login' => 'srtravels1',
                'transport_administrative_password' => '000112',
                'image_id' => 1,
                'transport_homepage_text' => '',
                'transport_saved_by' => 1,
                'transport_save_status' => 0,
                'server_ip' => '127.0.0.1',
                'transport_rank' => 2,
                'server_lan_ip' => '127.0.0.1',
                'transport_code' => null,
                'transport_interest_2' => 0,
            ],
        ];

        foreach ($transports as $transport) {
            Transport::updateOrCreate(
                ['transport_id' => $transport['transport_id']],
                [
                    'transport_name' => $transport['transport_name'],
                    'transport_organization_name' => $transport['transport_organization_name'] ?: $transport['transport_name'],
                    'transport_short_name' => $transport['transport_short_name'] ?: 'shortname',
                    'transport_address' => $transport['transport_address'] ?: 'Dhaka, Bangladesh',
                    'transport_total_station' => $transport['transport_total_station'] ?? 10,
                    'transport_total_bus' => $transport['transport_total_bus'] ?? 50,
                    'transport_total_employee' => $transport['transport_total_employee'] ?? 100,
                    'transport_total_route' => $transport['transport_total_route'] ?? 20,
                    'transport_city_id' => $transport['transport_city_id'] ?? 1,
                    'transport_postcode' => $transport['transport_postcode'] ?? 0,
                    'transport_date_of_establishment' => $transport['transport_date_of_establishment'] ?? now(),
                    'transport_phone' => $transport['transport_phone'] ?? '',
                    'transport_mobile' => $transport['transport_mobile'] ?? '',
                    'transport_fax' => $transport['transport_fax'] ?? '',
                    'transport_email' => $transport['transport_email'] ?? '',
                    'transport_web' => $transport['transport_web'] ?? '',
                    'transport_owner_name' => $transport['transport_owner_name'] ?? '',
                    'transport_owner_phone' => $transport['transport_owner_phone'] ?? '',
                    'transport_owner_mobile' => $transport['transport_owner_mobile'] ?? '',
                    'transport_owner_email' => $transport['transport_owner_email'] ?? '',
                    'transport_owner_fax' => $transport['transport_owner_fax'] ?? '',
                    'transport_comments' => $transport['transport_comments'] ?? '',
                    'transport_administrative_login' => $transport['transport_administrative_login'] ?? '',
                    'transport_administrative_password' => $transport['transport_administrative_password'] ?? '',
                    'image_id' => $transport['image_id'] ?? 1,
                    'transport_homepage_text' => $transport['transport_homepage_text'] ?? '',
                    'transport_saved_by' => $transport['transport_saved_by'] ?? 1,
                    'transport_save_status' => 1, // Always active after seeding
                    'server_ip' => $transport['server_ip'] ?? '127.0.0.1',
                    'server_lan_ip' => $transport['server_lan_ip'] ?? '127.0.0.1',
                    'transport_rank' => $transport['transport_rank'] ?? 1,
                    'transport_code' => $transport['transport_code'] ?? null,
                    'transport_interest_2' => $transport['transport_interest_2']
                ]
            );
        }


        $path = database_path('samplesql/transport_insert_data.sql');

        if (File::exists($path)) {
            $sql = File::get($path);
            DB::unprepared($sql);

            // Transport::factory()->count(1000)->create();

        } else {
            $this->command->error("SQL file not found at: $path");
        }

    }
}
