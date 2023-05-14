<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class EmployeeTypeSeeder extends Seeder
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
                'type' => 'Manager',
                'slug' => Str::slug('Manager'),
                'is_active' => 1,
            ],
            // [
            //     'type' => 'HRD',
            //     'slug' => Str::slug('HRD'),
            //     'is_active' => 1,
            // ],
            // [
            //     'type' => 'FINANCE',
            //     'slug' => Str::slug('FINANCE'),
            //     'is_active' => 1,
            // ],
            // [
            //     'type' => 'ADMIN',
            //     'slug' => Str::slug('ADMIN'),
            //     'is_active' => 1,
            // ],
            // [
            //     'type' => 'PIC',
            //     'slug' => Str::slug('PIC'),
            //     'is_active' => 1,
            // ],
            [
                'type' => 'Accounting',
                'slug' => Str::slug('Accounting'),
                'is_active' => 1,
            ],
            [
                'type' => 'Acrylic',
                'slug' => Str::slug('Acrylic'),
                'is_active' => 1,
            ],
            [
                'type' => 'Admin Acrylic',
                'slug' => Str::slug('Admin Acrylic'),
                'is_active' => 1,
            ],
            [
                'type' => 'Admin Umum',
                'slug' => Str::slug('Admin Umum'),
                'is_active' => 1,
            ],
            [
                'type' => 'Admin Gudang',
                'slug' => Str::slug('Admin Gudang'),
                'is_active' => 1,
            ],
            [
                'type' => 'Admin Personalia',
                'slug' => Str::slug('Admin Personalia'),
                'is_active' => 1,
            ],
            [
                'type' => 'Admin Printing',
                'slug' => Str::slug('Admin Printing'),
                'is_active' => 1,
            ],
            [
                'type' => 'Admin Schedulue PIC',
                'slug' => Str::slug('Admin Schedulue PIC'),
                'is_active' => 1,
            ],
            [
                'type' => 'Admin Implementasi',
                'slug' => Str::slug('Admin Implementasi'),
                'is_active' => 1,
            ],
            [
                'type' => 'Desainer Grafis',
                'slug' => Str::slug('Desainer Grafis'),
                'is_active' => 1,
            ],
            [
                'type' => 'Driver',
                'slug' => Str::slug('Driver'),
                'is_active' => 1,
            ],
            [
                'type' => 'Estimator Invoice',
                'slug' => Str::slug('Estimator Invoice'),
                'is_active' => 1,
            ],
            [
                'type' => 'Finance',
                'slug' => Str::slug('Finance'),
                'is_active' => 1,
            ],
            [
                'type' => 'Implementasi',
                'slug' => Str::slug('Implementasi'),
                'is_active' => 1,
            ],
            [
                'type' => 'Ka. HRD / TP',
                'slug' => Str::slug('Ka. HRD / TP'),
                'is_active' => 1,
            ],
            [
                'type' => 'Marketing',
                'slug' => Str::slug('Marketing'),
                'is_active' => 1,
            ],
            [
                'type' => 'PIC',
                'slug' => Str::slug('PIC'),
                'is_active' => 1,
            ],
            [
                'type' => 'PIC / TP',
                'slug' => Str::slug('PIC / TP'),
                'is_active' => 1,
            ],
            [
                'type' => 'PIC Printing',
                'slug' => Str::slug('PIC Printing'),
                'is_active' => 1,
            ],
            [
                'type' => 'Security',
                'slug' => Str::slug('Security'),
                'is_active' => 1,
            ],
            [
                'type' => 'Staff Accounting',
                'slug' => Str::slug('Staff Accounting'),
                'is_active' => 1,
            ],
        ];
        DB::table('employee_types')->insert($data);
    }
}
