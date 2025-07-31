<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Enfant extends Model
{
    protected $fillable = [
        'declaration_naissance_id', 
        'date_naissance',
        'nombreEnf',
        'sexe',
    ];
    public function declaration_naissance()
    {
        return $this->belongsTo(DeclarationNaissance::class);
    }
}
