<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Finance extends Authenticatable
{
    use HasFactory, Notifiable;
    protected $guard = 'finance';
    protected $fillable = [
        'name',
        'prenom',
        'email',
        'contact',
        'password',
        'profile_picture',
        'commune',
        'communeM',
        'archived_at',
        'cas_urgence',
        'disponible',
    ];

    public function timbres()
    {
        return $this->hasMany(Timbre::class);
    }
}
