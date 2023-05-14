<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class JenisIzinSeeder extends Seeder
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
                'type' => 'Sakit',
                'slug' => Str::slug('Sakit'),
                'is_active' => 1,
            ],
            [
                'type' => 'Cuti',
                'slug' => Str::slug('Sakit'),
                'is_active' => 1,
            ],
            [
                'type' => 'Lainnya',
                'slug' => Str::slug('Lainnya'),
                'is_active' => 1,
            ],
            
        ];
        DB::table('jenis_izin')->insert($data);
    }
}
