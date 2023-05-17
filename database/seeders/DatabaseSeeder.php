<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            JenisIzinSeeder::class,
            JenisLemburSeeder::class,
            EmployeeTypeSeeder::class,
            ShiftSeeder::class,
            EducationSeeder::class,
            SettingSeeder::class,
            TimezoneSeeder::class,
            RoleSeeder::class,
            PermissionsSeeder::class,
            AsignRoleToPermissionsSeeder::class,
            UserSeeder::class,
        ]);
    }
}
