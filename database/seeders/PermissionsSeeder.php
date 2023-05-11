<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Spatie\Permission\Models\Permission;
use Illuminate\Database\Seeder;

class PermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {


        // ==== Permissions Admin  ==== //

        // dashboard
        Permission::create(['name' => 'admin-dashboard']);

        // admin presensi
        Permission::create(['name' => 'admin-log-presensi-sidebar-menu']);
        Permission::create(['name' => 'admin-log-presensi-list']);
        Permission::create(['name' => 'admin-log-presensi-show']);
        Permission::create(['name' => 'admin-log-presensi-edit']);
        Permission::create(['name' => 'admin-log-presensi-update']);
        Permission::create(['name' => 'admin-log-presensi-create']);
        Permission::create(['name' => 'admin-log-presensi-store']);
        Permission::create(['name' => 'admin-log-presensi-delete']);
        Permission::create(['name' => 'admin-log-presensi-checkout']);

        // admin izin
        Permission::create(['name' => 'admin-izin-sidebar-menu']);
        Permission::create(['name' => 'admin-izin-list']);
        Permission::create(['name' => 'admin-izin-show']);
        Permission::create(['name' => 'admin-izin-edit']);
        Permission::create(['name' => 'admin-izin-update']);
        Permission::create(['name' => 'admin-izin-create']);
        Permission::create(['name' => 'admin-izin-store']);
        Permission::create(['name' => 'admin-izin-delete']);
        Permission::create(['name' => 'admin-izin-validation']);

        // admin waktu-kerja
        Permission::create(['name' => 'admin-waktu-kerja-sidebar-menu']);
        Permission::create(['name' => 'admin-waktu-kerja-list']);
        Permission::create(['name' => 'admin-waktu-kerja-show']);
        Permission::create(['name' => 'admin-waktu-kerja-edit']);
        Permission::create(['name' => 'admin-waktu-kerja-update']);
        Permission::create(['name' => 'admin-waktu-kerja-create']);
        Permission::create(['name' => 'admin-waktu-kerja-store']);
        Permission::create(['name' => 'admin-waktu-kerja-delete']);

        // admin karyawan
        Permission::create(['name' => 'admin-karyawan-sidebar-menu']);
        Permission::create(['name' => 'admin-karyawan-list']);
        Permission::create(['name' => 'admin-karyawan-show']);
        Permission::create(['name' => 'admin-karyawan-edit']);
        Permission::create(['name' => 'admin-karyawan-update']);
        Permission::create(['name' => 'admin-karyawan-create']);
        Permission::create(['name' => 'admin-karyawan-store']);
        Permission::create(['name' => 'admin-karyawan-delete']);
        Permission::create(['name' => 'admin-karyawan-is-active']);

        // admin laporan
        Permission::create(['name' => 'admin-laporan-sidebar-menu']);
        Permission::create(['name' => 'admin-laporan-list']);
        Permission::create(['name' => 'admin-laporan-show']);
        Permission::create(['name' => 'admin-laporan-edit']);
        Permission::create(['name' => 'admin-laporan-update']);
        Permission::create(['name' => 'admin-laporan-create']);
        Permission::create(['name' => 'admin-laporan-store']);
        Permission::create(['name' => 'admin-laporan-delete']);
        Permission::create(['name' => 'admin-laporan-filter']);
        Permission::create(['name' => 'admin-laporan-download']);
        
        // admin jabatan
        Permission::create(['name' => 'admin-jabatan-sidebar-menu']);
        Permission::create(['name' => 'admin-jabatan-list']);
        Permission::create(['name' => 'admin-jabatan-show']);
        Permission::create(['name' => 'admin-jabatan-edit']);
        Permission::create(['name' => 'admin-jabatan-update']);
        Permission::create(['name' => 'admin-jabatan-create']);
        Permission::create(['name' => 'admin-jabatan-store']);
        Permission::create(['name' => 'admin-jabatan-delete']);

        // admin pendidikan
        Permission::create(['name' => 'admin-pendidikan-sidebar-menu']);
        Permission::create(['name' => 'admin-pendidikan-list']);
        Permission::create(['name' => 'admin-pendidikan-show']);
        Permission::create(['name' => 'admin-pendidikan-edit']);
        Permission::create(['name' => 'admin-pendidikan-update']);
        Permission::create(['name' => 'admin-pendidikan-create']);
        Permission::create(['name' => 'admin-pendidikan-store']);
        Permission::create(['name' => 'admin-pendidikan-delete']);
         
        // admin Jenis izin
        Permission::create(['name' => 'admin-jenis-izin-sidebar-menu']);
        Permission::create(['name' => 'admin-jenis-izin-list']);
        Permission::create(['name' => 'admin-jenis-izin-show']);
        Permission::create(['name' => 'admin-jenis-izin-edit']);
        Permission::create(['name' => 'admin-jenis-izin-update']);
        Permission::create(['name' => 'admin-jenis-izin-create']);
        Permission::create(['name' => 'admin-jenis-izin-store']);
        Permission::create(['name' => 'admin-jenis-izin-delete']);
        
        // admin jenis-lembur
        Permission::create(['name' => 'admin-jenis-lembur-sidebar-menu']);
        Permission::create(['name' => 'admin-jenis-lembur-list']);
        Permission::create(['name' => 'admin-jenis-lembur-show']);
        Permission::create(['name' => 'admin-jenis-lembur-edit']);
        Permission::create(['name' => 'admin-jenis-lembur-update']);
        Permission::create(['name' => 'admin-jenis-lembur-create']);
        Permission::create(['name' => 'admin-jenis-lembur-store']);
        Permission::create(['name' => 'admin-jenis-lembur-delete']);

        // admin users
        Permission::create(['name' => 'admin-users-sidebar-menu']);
        Permission::create(['name' => 'admin-users-list']);
        Permission::create(['name' => 'admin-users-show']);
        Permission::create(['name' => 'admin-users-edit']);
        Permission::create(['name' => 'admin-users-update']);
        Permission::create(['name' => 'admin-users-create']);
        Permission::create(['name' => 'admin-users-store']);
        Permission::create(['name' => 'admin-users-delete']);
        Permission::create(['name' => 'admin-users-platform-access']);

        // admin pengaturan
        Permission::create(['name' => 'admin-pengaturan-sidebar-menu']);
        Permission::create(['name' => 'admin-pengaturan-list']);
        Permission::create(['name' => 'admin-pengaturan-show']);
        Permission::create(['name' => 'admin-pengaturan-edit']);
        Permission::create(['name' => 'admin-pengaturan-update']);
        Permission::create(['name' => 'admin-pengaturan-create']);
        Permission::create(['name' => 'admin-pengaturan-store']);
        Permission::create(['name' => 'admin-pengaturan-delete']);
        Permission::create(['name' => 'admin-pengaturan-umum']);
        Permission::create(['name' => 'admin-pengaturan-absensi']);


        // ==== Permissions User ==== //

        // dashboard
        Permission::create(['name' => 'user-dashboard']);

        // profile 
        Permission::create(['name' => 'user-profile-sidebar-menu']);
        Permission::create(['name' => 'user-profile-show']);
        Permission::create(['name' => 'user-profile-edit']);
        Permission::create(['name' => 'user-profile-update']);
        Permission::create(['name' => 'user-profile-inactive']);

        // presensi
        Permission::create(['name' => 'user-presensi-sidebar-menu']);
        Permission::create(['name' => 'user-presensi-list']);
        Permission::create(['name' => 'user-presensi-show']);
        Permission::create(['name' => 'user-presensi-edit']);
        Permission::create(['name' => 'user-presensi-update']);
        Permission::create(['name' => 'user-presensi-create']);
        Permission::create(['name' => 'user-presensi-store']);
        Permission::create(['name' => 'user-presensi-delete']);
        Permission::create(['name' => 'user-presensi-checkin']);
        Permission::create(['name' => 'user-presensi-checkout']);

        // izin
        Permission::create(['name' => 'user-izin-sidebar-menu']);
        Permission::create(['name' => 'user-izin-list']);
        Permission::create(['name' => 'user-izin-show']);
        Permission::create(['name' => 'user-izin-edit']);
        Permission::create(['name' => 'user-izin-update']);
        Permission::create(['name' => 'user-izin-create']);
        Permission::create(['name' => 'user-izin-store']);
        Permission::create(['name' => 'user-izin-delete']);
 
    }
}
