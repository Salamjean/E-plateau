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
        'statut_livraison',
        'user_id',  // Ajout de user_id
        'agent_id',  // Ajout de agent_id
        'livreur_id',  // Ajout de livreur_id
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
    
    public function livreur()
    {
        return $this->belongsTo(Livreur::class, 'livreur_id');
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
