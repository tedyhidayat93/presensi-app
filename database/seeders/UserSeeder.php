<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $superadmin = User::create([
            'full_name' => 'Super Administartor',
            'type' => null,
            'status' => null,
            'username' => 'superadmin',
            'nik' => Str::upper(Str::random(16)),
            'nip' => Str::upper(Str::random(12)),
            'email' => 'superadmin@mail.com',
            'password' => bcrypt('secret'),
            'gender' => 'NA',
            'phone' => null,
            'address' => null,
            'role' => 'superadmin',
            'shift' => null,
            'is_active' => 1,
            'tanggal_masuk' => null,
            'email_verified_at' => Carbon::now()->toDateTimeString(),
            'actived_at' => Carbon::now()->toDateTimeString(),
            'registered_at' => Carbon::now()->toDateTimeString(),
        ]);
        $role_superadmin = Role::where(['name' => 'superadmin'])->first();
        $superadmin->assignRole([$role_superadmin->id]); 

        $admin = User::create([
            'full_name' => 'Admin',
            'type' => null,
            'status' => null,
            'username' => 'admin',
            'nik' => Str::upper(Str::random(16)),
            'nip' => Str::upper(Str::random(12)),
            'email' => 'admin@mail.com',
            'password' => bcrypt('secret'),
            'gender' => 'NA',
            'phone' => null,
            'address' => null,
            'role' => 'admin',
            'shift' => null,
            'is_active' => 1,
            'tanggal_masuk' => null,
            'email_verified_at' => Carbon::now()->toDateTimeString(),
            'actived_at' => Carbon::now()->toDateTimeString(),
            'registered_at' => Carbon::now()->toDateTimeString(),
        ]);
        $role_admin = Role::where(['name' => 'admin'])->first();
        $admin->assignRole([$role_admin->id]); 

        $user = User::create([
            'full_name' => 'Rahul',
            'type' => null,
            'status' => null,
            'username' => 'user',
            'nik' => Str::upper(Str::random(16)),
            'nip' => Str::upper(Str::random(12)),
            'email' => 'user@mail.com',
            'password' => bcrypt('secret'),
            'gender' => 'NA',
            'phone' => null,
            'address' => null,
            'role' => 'user',
            'shift' => null,
            'is_active' => 1,
            'tanggal_masuk' => null,
            'email_verified_at' => Carbon::now()->toDateTimeString(),
            'actived_at' => Carbon::now()->toDateTimeString(),
            'registered_at' => Carbon::now()->toDateTimeString(),
        ]);
        $role_user = Role::where(['name' => 'user'])->first();
        $user->assignRole([$role_user->id]); 
    }
}


















 











 





































