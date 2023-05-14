<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Location extends Model
{
    use HasFactory;

    protected $table = 'locations';   
    protected $guarded = [];   

    public function karyawan() {
        return $this->hasOne(User::class, 'id', 'employee_id')->where('is_active', 1);
    }
}
