<?php

namespace App\Http\Controllers\Mairie\Declaration;

use App\Http\Controllers\Controller;
use App\Models\DeclarationDeces;
use App\Models\DeclarationNaissance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DeclarationController extends Controller
{
    public function naissance() {
        $sousadmin = Auth::guard('mairie')->user();
        
        // Récupérer la commune de l'administrateur
        $communeAdmin = $sousadmin->name; // Ajustez selon votre logique
    
        // Récupérer les déclarations de naissances filtrées par la commune de l'administrateur
        $naisshops = DeclarationNaissance::where('commune', $communeAdmin)
            ->with('enfants')
            ->get();
    
        return view('mairie.declarations.naissance', [
            'naisshops' => $naisshops,
            'sousadmin' => $sousadmin
        ]);
    }

    public function deces(){

        $sousadmin = Auth::guard('mairie')->user();
        // Récupérer la commune de l'administrateur
        $communeAdmin = $sousadmin->name; 

        // Récupérer les déclarations de naissances filtrées par la commune de l'administrateur
        $deceshops = DeclarationDeces::where('commune', $communeAdmin)->get();
    
        return view('mairie.declarations.deces', [
            'deceshops' => $deceshops,
            'sousadmin' => $sousadmin
        ]);
    }
}
