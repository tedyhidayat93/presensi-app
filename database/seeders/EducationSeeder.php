<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class EducationSeeder extends Seeder
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
                'education' => 'SD',
                'slug' => Str::slug('SD'),
                'is_active' => 1,
            ],
            [
                'education' => 'SMP',
                'slug' => Str::slug('SMP'),
                'is_active' => 1,
            ],
            [
                'education' => 'SMA',
                'slug' => Str::slug('SMA'),
                'is_active' => 1,
            ],
            [
                'education' => 'D1',
                'slug' => Str::slug('D1'),
                'is_active' => 1,
            ],
            [
                'education' => 'D2',
                'slug' => Str::slug('D2'),
                'is_active' => 1,
            ],
            [
                'education' => 'D3',
                'slug' => Str::slug('D3'),
                'is_active' => 1,
            ],
            [
                'education' => 'D4',
                'slug' => Str::slug('D4'),
                'is_active' => 1,
            ],
            [
                'education' => 'S1',
                'slug' => Str::slug('S1'),
                'is_active' => 1,
            ],
            [
                'education' => 'S2',
                'slug' => Str::slug('S2'),
                'is_active' => 1,
            ],
            [
                'education' => 'S3',
                'slug' => Str::slug('S3'),
                'is_active' => 1,
            ],
            
        ];
        DB::table('educations')->insert($data);
    }
}
