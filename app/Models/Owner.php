<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable; // <- important for login
use Illuminate\Notifications\Notifiable;

class Owner extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'owners';   // database table name

    protected $fillable = [
        'username',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];
}
