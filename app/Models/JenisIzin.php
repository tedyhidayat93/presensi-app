<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JenisIzin extends Model
{
    use HasFactory;

    protected $table = 'jenis_izin';   
    protected $guarded = [];   
}
