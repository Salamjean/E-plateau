<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NaissanceCertificat extends Model
{
    protected $fillable = [
        'nomHopital',
        'nomDefunt',
        'dateNaiss',
        'lieuNaiss',
        'identiteDeclarant',
        'cdnaiss',
        'acteMariage',
        'commune',
        'nom',
        'prenom',
        'archived_at',
        'nompere',
        'prenompere',
        'datepere',
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
    

public static function getNextId() // Rendez la méthode publique et statique
{
    // Récupérer le dernier ID et incrémenter
    $lastNaissance = self::orderBy('id', 'desc')->first();
    if ($lastNaissance) {
        return $lastNaissance->id + 1;
    } else {
        return 1; // Si c'est le premier enregistrement
    }
}

public function archive()
{
    $this->update(['archived_at' => now()]);
}

public function scopeTerminated($query) {
    return $query->where('etat', 'terminé');
}
}
