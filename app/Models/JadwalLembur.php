<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JadwalLembur extends Model
{
    use HasFactory;

    protected $table = 'jadwal_lembur';   
    protected $guarded = [];   

    public function listAnggota() {
        return $this->hasMany(AnggotaLembur::class, 'lembur_id', 'id');
        // ->join('users', 'users.id', '=', 'anggota_jadwal_lembur.user_id')
        // ->select('users.full_name', 'anggota_jadwal_lembur.*')
        // ->orderBy('users.full_name', 'asc')->get();;
    }
}
