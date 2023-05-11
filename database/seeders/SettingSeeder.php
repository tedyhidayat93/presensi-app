<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;


class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
                [
                    'site_name' => 'E-KEHADIRAN',
                    'favico' => null,
                    'logo' => null,
                    'email' => 'mail@company.com',
                    'phone' => '02179187867',
                    'address' => 'Jakarta',
                    'start_overtime' => '19:00:00',
                    'is_using_radius' => 1,
                    'radius' => null,
                    'lat_loc' => null,
                    'long_loc' => null,
                    'copyright_footer' =>'Copyright &copy; 2023. E-KEHADIRAN By TheightDev.',
                    'status' => 1,
                ]
            ];
        DB::table('general_site_settings')->insert($data);
    }
}
