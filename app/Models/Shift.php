<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Shift extends Model
{
    use HasFactory;

    protected $table = 'shifts';   
    protected $guarded = [];   

    public function karyawan() {
        return $this->hasMany(ShiftsUsers::class, 'shift_id')->select('user_id');
    }
}
