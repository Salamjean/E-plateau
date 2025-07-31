<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;

class Hopital extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $guard = 'mairie';
    protected $fillable = [
        'name',
        'email',
        'contact',
        'password',
        'nomHop',
        'commune',
        'type',
        'profile_picture',
    ];

}
