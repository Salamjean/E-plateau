<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NaissanceSimple extends Model
{
   protected $fillable = [
        'type',
        'name',
        'prenom',
        'number',
        'commune',
        'etat',
        'user_id',  // Ajout de user_id
        'agent_id',  // Ajout de agent_id
    ];

    // Définir la relation avec l'utilisateur
    public function user()
    {
        return $this->belongsTo(User::class); // Associe à la table users
    }

    public function agent()
    {
        return $this->belongsTo(Agent::class, 'agent_id');
    }

    public static function getNextId()
    {
        $lastNaissanced = self::orderBy('id', 'desc')->first();
        if ($lastNaissanced) {
            return $lastNaissanced->id + 1;
        } else {
            return 1;
        }
    }
}
