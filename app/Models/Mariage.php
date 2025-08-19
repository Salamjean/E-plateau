<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Mariage extends Model
{
    protected $fillable = [
        'nomEpoux',
        'prenomEpoux',
        'dateNaissanceEpoux',
        'lieuNaissanceEpoux',
        'pieceIdentite',
        'extraitMariage',
        'commune',
        'etat',
        'agent_id',  
        'statut_livraison',  
        'livreur_id',  
    ];

    public function user()
    {
        return $this->belongsTo(User::class); 
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
        $lastMariage = self::orderBy('id', 'desc')->first();
        if ($lastMariage) {
            return $lastMariage->id + 1;
        } else {
            return 1;
        }
    }
    public function scopeTerminated($query) {
        return $query->where('etat', 'terminé');
    }
}
