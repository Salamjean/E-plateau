<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DecesCertificat extends Model
{
    protected $fillable = [
        'nomHopital',
        'dateDces',
        'nomDefunt',
        'dateNaiss',
        'lieuNaiss',
        'identiteDeclarant',
        'acteMariage',
        'deParLaLoi',
        'commune',
        'etat',
        'user_id',  
        'agent_id', 
        'livreur_id', 
        'statut_livraison', 
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
        $lastDeces = self::orderBy('id', 'desc')->first();
        if ($lastDeces) {
            return $lastDeces->id + 1;
        } else {
            return 1;
        }
    }
}
