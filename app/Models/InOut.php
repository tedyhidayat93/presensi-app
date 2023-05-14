<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class InOut extends Model
{
    use HasFactory;

    protected $table = 'checklock_attendance';   
    protected $guarded = [];   

    public function karyawan() {
        return $this->hasOne(User::class, 'id', 'employee_id')->where('is_active', 1);
    }
    public function shift() {
        return $this->hasOne(Shift::class, 'id', 'shift_id')->where('is_active', 1);
    }

    public function jenisLembur() {
        return $this->hasOne(JenisLembur::class, 'id', 'id_jenis_lembur')->where('is_active', 1);
    }

    public function izin() {
        return $this->hasOne(Izin::class, 'id', 'id_izin')->where('is_active', 1);
    }
}
