<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable; 
use Illuminate\Notifications\Notifiable;

class Doctor extends Authenticatable
{
    use HasFactory, Notifiable;

        protected $guard = 'doctor';
        protected $fillable = [
            'name',
            'email',
            'password',
            'fonction',
            'sexe',
            'profile_picture',
            'archived_at'
        ];
}
