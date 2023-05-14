<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ShiftSeeder extends Seeder
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
                'shift_name' => 'Normal Shift',
                'senin_in' => '09:00',
                'senin_out' => '17:00',
                'selasa_in' => '09:00',
                'selasa_out' => '17:00',
                'rabu_in' => '09:00',
                'rabu_out' => '17:00',
                'kamis_in' => '09:00',
                'kamis_out' => '17:00',
                'jumat_in' => '09:00',
                'jumat_out' => '17:00',
                'sabtu_in' => '09:00',
                'sabtu_out' => '15:00',
                'minggu_in' => null,
                'minggu_out' => null,
                'is_active' => 1,
            ],
            // [
            //     'shift_name' => 'Shift 2',
            //     'senin_in' => '19:00',
            //     'senin_out' => '01:00',
            //     'selasa_in' => '19:00',
            //     'selasa_out' => '01:00',
            //     'rabu_in' => '19:00',
            //     'rabu_out' => '01:00',
            //     'kamis_in' => '19:00',
            //     'kamis_out' => '01:00',
            //     'jumat_in' => '19:00',
            //     'jumat_out' => '01:00',
            //     'sabtu_in' => '19:00',
            //     'sabtu_out' => '11:00',
            //     'minggu_in' => '00:00',
            //     'minggu_out' => '00:00',
            //     'is_active' => 1,
            // ],
            // [
            //     'shift_name' => 'Shift 3',
            //     'senin_in' => '03:00',
            //     'senin_out' => '08:00',
            //     'selasa_in' => '03:00',
            //     'selasa_out' => '08:00',
            //     'rabu_in' => '03:00',
            //     'rabu_out' => '08:00',
            //     'kamis_in' => '03:00',
            //     'kamis_out' => '08:00',
            //     'jumat_in' => '03:00',
            //     'jumat_out' => '08:00',
            //     'sabtu_in' => '03:00',
            //     'sabtu_out' => '07:00',
            //     'minggu_in' => null,
            //     'minggu_out' => null,
            //     'is_active' => 1,
            // ]
        ];
        DB::table('shifts')->insert($data);
    }
}
