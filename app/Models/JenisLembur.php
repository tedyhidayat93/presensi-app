<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JenisLembur extends Model
{
    use HasFactory;

    protected $table = 'jenis_lembur';   
    protected $guarded = [];   
}
