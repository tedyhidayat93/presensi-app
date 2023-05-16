<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $guarded = [];
    // protected $fillable = [
    //     'name',
    //     'email',
    //     'password',
    // ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];



    public function shift()
    {
        return $this->belongsToMany(Shift::class, 'user_id', 'id', 'shift_id');
    }
    
    public function shifts()
    {
        return $this->belongsToMany(Shift::class, 'shifts_users', 'user_id', 'shift_id');
    }

    public function jabatan()
    {
        return $this->hasOne(EmployeeType::class, 'id', 'employee_type')->select('id', 'type');
    }
    public function shifft()
    {
        return $this->hasOne(Shift::class, 'id', 'shift')->select('id', 'shift_name');
    }
    public function education()
    {
        return $this->hasOne(Education::class, 'id', 'last_education')->select('id', 'education');
    }
}
