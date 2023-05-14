<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AnggotaLembur extends Model
{
    use HasFactory;

    protected $table = 'anggota_jadwal_lembur';   
    protected $guarded = [];   

    
    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id')->select('id', 'type', 'full_name','employee_type');
    }
}
