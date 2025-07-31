<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Mairie extends Authenticatable
{
   use HasFactory, Notifiable;

    protected $guard = 'mairie';
    protected $fillable = [
        'name',
        'email',
        'password',
        'archived_at'
    ];
}
