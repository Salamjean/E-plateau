<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DeclarationDeces extends Model
{
    use HasFactory;
    protected $fillable = [
        'NomM',
        'PrM',
        'DateNaissance',
        'DateDeces',
        'Remarques',
        'nomHop',
        'choix',
        'commune',
        'codeDM',
        'codeCMD',
        'doctor_id', 
    ];

     // Définir la relation avec le docteur
    public function doctor()
    {
        return $this->belongsTo(Doctor::class);
    }
}
