<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class JenisLemburSeeder extends Seeder
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
                'type' => 'Operan Malam',
                'slug' => Str::slug('Operan Malam'),
                'is_active' => 1,
            ],
            [
                'type' => 'Operan Pagi',
                'slug' => Str::slug('Operan Pagi'),
                'is_active' => 1,
            ],
            [
                'type' => 'Lembur Workshop',
                'slug' => Str::slug('Lembur Workshop'),
                'is_active' => 1,
            ],
            
        ];
        DB::table('jenis_lembur')->insert($data);
    }
}
