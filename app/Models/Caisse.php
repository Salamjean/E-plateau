<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class Caisse extends Authenticatable
{
    protected $guard = 'caisse';
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
    public function decesSimple()
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

    protected $guarded = [];

    public function archive()
    {
        $this->update(['archived_at' => now()]);
    }
}
