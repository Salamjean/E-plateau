<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Poste extends Authenticatable
{
   use HasFactory, Notifiable;
    protected $fillable = [
        'name',
        'prenom',
        'email',
        'contact',
        'password',
        'profile_picture',
        'commune',
        'communeM',
        'archived_at'
    ];

    public function naissances()
    {
        return $this->hasMany(NaissanceSimple::class, 'agent_id');
    }
    public function naissance()
    {
        return $this->hasMany(NaissanceCertificat::class, 'agent_id');
    }
    public function deces()
    {
        return $this->hasMany(DecesCertificat::class, 'agent_id');
    }
    public function decesdeja()
    {
        return $this->hasMany(DecesSimple::class, 'agent_id');
    }
    public function mariage()
    {
        return $this->hasMany(Mariage::class, 'agent_id');
    }

     /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
    ];

       /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function archive()
    {
        $this->update(['archived_at' => now()]);
    }
}
