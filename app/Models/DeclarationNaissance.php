<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DeclarationNaissance extends Model
{
    use HasFactory;
    protected $fillable = [
        'NomM',
        'PrM',
        'contM',
        'dateM',
        'CNI_mere',
        'NomP',
        'PrP',
        'contP',
        'CNI_Pere',
        'NomEnf',
        'commune',
        'codeCMU',
        'lien',
        'codeDM',
        'codeCMN',
        'doctor_id',  // Ajout de sous_admin_id
    ];

     // Définir la relation avec le docteur
     public function doctor()
     {
         return $this->belongsTo(Doctor::class);
     }
     public function enfants()
    {
        return $this->hasMany(Enfant::class);
    }
}
