<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Spatie\Permission\Models\Role;
use Illuminate\Database\Seeder;

class AsignRoleToPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        // SUPERADMIN Asign Permissions to Role
        $superadmin = Role::where(['name' => 'superadmin'])->first();
        $superadmin->givePermissionTo([
            
            'admin-dashboard',

            'admin-log-presensi-sidebar-menu',
            'admin-log-presensi-list',
            'admin-log-presensi-show',
            'admin-log-presensi-edit',
            'admin-log-presensi-update',
            'admin-log-presensi-create',
            'admin-log-presensi-store',
            'admin-log-presensi-delete',
            'admin-log-presensi-checkout',
        
            'admin-izin-sidebar-menu',
            'admin-izin-list',
            'admin-izin-show',
            'admin-izin-edit',
            'admin-izin-update',
            'admin-izin-create',
            'admin-izin-store',
            'admin-izin-delete',
            'admin-izin-validation',

            'admin-waktu-kerja-sidebar-menu',
            'admin-waktu-kerja-list',
            'admin-waktu-kerja-show',
            'admin-waktu-kerja-edit',
            'admin-waktu-kerja-update',
            'admin-waktu-kerja-create',
            'admin-waktu-kerja-store',
            'admin-waktu-kerja-delete',

            'admin-karyawan-sidebar-menu',
            'admin-karyawan-list',
            'admin-karyawan-show',
            'admin-karyawan-edit',
            'admin-karyawan-update',
            'admin-karyawan-create',
            'admin-karyawan-store',
            'admin-karyawan-delete',

            'admin-laporan-sidebar-menu',
            'admin-laporan-list',
            'admin-laporan-show',
            'admin-laporan-edit',
            'admin-laporan-update',
            'admin-laporan-create',
            'admin-laporan-store',
            'admin-laporan-delete',
            'admin-laporan-filter',
            'admin-laporan-download',

            'admin-jabatan-sidebar-menu',
            'admin-jabatan-list',
            'admin-jabatan-show',
            'admin-jabatan-edit',
            'admin-jabatan-update',
            'admin-jabatan-create',
            'admin-jabatan-store',
            'admin-jabatan-delete',

            'admin-pendidikan-sidebar-menu',
            'admin-pendidikan-list',
            'admin-pendidikan-show',
            'admin-pendidikan-edit',
            'admin-pendidikan-update',
            'admin-pendidikan-create',
            'admin-pendidikan-store',
            'admin-pendidikan-delete',

            'admin-jenis-izin-sidebar-menu',
            'admin-jenis-izin-list',
            'admin-jenis-izin-show',
            'admin-jenis-izin-edit',
            'admin-jenis-izin-update',
            'admin-jenis-izin-create',
            'admin-jenis-izin-store',
            'admin-jenis-izin-delete',
            
            'admin-jenis-lembur-sidebar-menu',
            'admin-jenis-lembur-list',
            'admin-jenis-lembur-show',
            'admin-jenis-lembur-edit',
            'admin-jenis-lembur-update',
            'admin-jenis-lembur-create',
            'admin-jenis-lembur-store',
            'admin-jenis-lembur-delete',

            'admin-users-sidebar-menu',
            'admin-users-list',
            'admin-users-show',
            'admin-users-edit',
            'admin-users-update',
            'admin-users-create',
            'admin-users-store',
            'admin-users-delete',
            'admin-users-platform-access',

            'admin-pengaturan-sidebar-menu',
            'admin-pengaturan-list',
            'admin-pengaturan-show',
            'admin-pengaturan-edit',
            'admin-pengaturan-update',
            'admin-pengaturan-create',
            'admin-pengaturan-store',
            'admin-pengaturan-delete',
            'admin-pengaturan-umum',
            'admin-pengaturan-absensi',

            'user-dashboard',

            'user-profile-sidebar-menu',
            'user-profile-show',
            'user-profile-edit',
            'user-profile-update',
            'user-profile-inactive',

            'user-presensi-sidebar-menu',
            'user-presensi-list',
            'user-presensi-show',
            'user-presensi-edit',
            'user-presensi-update',
            'user-presensi-create',
            'user-presensi-store',
            'user-presensi-delete',
            'user-presensi-checkin',
            'user-presensi-checkout',

            'user-izin-sidebar-menu',
            'user-izin-list',
            'user-izin-show',
            'user-izin-edit',
            'user-izin-update',
            'user-izin-create',
            'user-izin-store',
            'user-izin-delete',

        ]);
        
        // ADMIN Asign Permissions to Role
        $admin = Role::where(['name' => 'admin'])->first();
        $admin->givePermissionTo([
            
            'admin-dashboard',

            'admin-log-presensi-sidebar-menu',
            'admin-log-presensi-list',
            'admin-log-presensi-show',
            
            'admin-izin-sidebar-menu',
            'admin-izin-list',
            'admin-izin-show',
            'admin-izin-validation',

            'admin-waktu-kerja-sidebar-menu',
            'admin-waktu-kerja-list',
            'admin-waktu-kerja-show',

            'admin-karyawan-sidebar-menu',
            'admin-karyawan-list',
            'admin-karyawan-show',
            'admin-karyawan-edit',
            'admin-karyawan-is-active',

            'admin-laporan-sidebar-menu',
            'admin-laporan-list',
            'admin-laporan-show',
            'admin-laporan-edit',
            'admin-laporan-update',
            'admin-laporan-create',
            'admin-laporan-store',
            'admin-laporan-delete',
            'admin-laporan-filter',
            'admin-laporan-download',

            'admin-jabatan-sidebar-menu',
            'admin-jabatan-list',
            'admin-jabatan-show',

            'admin-pendidikan-sidebar-menu',
            'admin-pendidikan-list',
            
            'admin-jenis-izin-sidebar-menu',
            'admin-jenis-izin-list',
            'admin-jenis-izin-show',

            'admin-jenis-lembur-sidebar-menu',
            'admin-jenis-lembur-list',
            'admin-jenis-lembur-show',

        ]);

        // USER Asign Permissions to Role
        $user = Role::where(['name' => 'user'])->first();
        $user->givePermissionTo([
            'user-dashboard',

            'user-profile-sidebar-menu',
            'user-profile-show',
            'user-profile-edit',
            'user-profile-update',
            'user-profile-inactive',

            'user-presensi-sidebar-menu',
            'user-presensi-list',
            'user-presensi-show',
            'user-presensi-edit',
            'user-presensi-update',
            'user-presensi-create',
            'user-presensi-store',
            'user-presensi-delete',
            'user-presensi-checkin',
            'user-presensi-checkout',

            'user-izin-sidebar-menu',
            'user-izin-list',
            'user-izin-show',
            'user-izin-edit',
            'user-izin-update',
            'user-izin-create',
            'user-izin-store',
            'user-izin-delete',

        ]);

    }
}
