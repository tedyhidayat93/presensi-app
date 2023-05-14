<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;


class TimezoneSeeder extends Seeder
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
                    'timezone' => 'Asia/Jakarta',
                    'kode' => 'WIB',
                    'is_active' => 1,
                ],
                [
                    'timezone' => 'Asia/Jayapura',
                    'kode' => 'WIT',
                    'is_active' =>1,
                ],
                [
                    'timezone' => 'Asia/Ujung_Pandang',
                    'kode' => 'WITA',
                    'is_active' =>1,
                ]
            ];
        DB::table('timezones')->insert($data);
    }
}
