<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Izin extends Model
{
    use HasFactory;

    protected $table = 'izin';   
    protected $guarded = [];   

    public function validator()
    {
        return $this->hasOne(User::class, 'id','validation_by');
    }
    public function user()
    {
        return $this->hasOne(User::class, 'id','created_by');
    }
    public function jenis()
    {
        return $this->hasOne(JenisIzin::class, 'id','jenis_izin_id');
    }
}
