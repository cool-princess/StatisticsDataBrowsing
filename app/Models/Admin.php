<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens; 

class Admin extends Authenticatable
{
    use HasFactory, Notifiable;
    use HasApiTokens;
    protected $table="admin";
    protected $guard  = 'admins';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'admin_id', 
        'password', 
        'department_name', 
        'job_title', 
        'name', 
        'furi_name', 
        'email', 
        'phone', 
        'break',
        'pwd_store'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'admin_id_verified_at' => 'datetime',
    ];
}
