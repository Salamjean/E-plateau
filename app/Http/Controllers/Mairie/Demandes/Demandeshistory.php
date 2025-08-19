<?php

namespace App\Http\Controllers\Mairie\Demandes;

use App\Http\Controllers\Controller;
use App\Models\DecesCertificat;
use App\Models\DecesSimple;
use App\Models\DeclarationNaissance;
use App\Models\Mariage;
use App\Models\NaissanceCertificat;
use App\Models\NaissanceSimple;
use Illuminate\Http\Request;

class Demandeshistory extends Controller
{
    public function taskend() {
        // Récupération des mariages terminés
        $taskendnaissanceDs = NaissanceSimple::where('etat', 'terminé')
            ->latest()
            ->paginate(10);
    
        // Récupération des naissances terminées
        $taskendnaissances = NaissanceCertificat::where('etat', 'terminé')
            ->latest()
            ->paginate(10);
        $naisshop = DeclarationNaissance::first();
    
        return view('mairie.demandes.history.taskends', compact(
            'taskendnaissanceDs',
            'taskendnaissances',
            'naisshop'
        ));
    }

    public function taskenddeces(){
         // Récupération des mariages terminés
         $taskenddeces = DecesCertificat::where('etat', 'terminé')
         ->latest()
         ->paginate(10);
 
        // Récupération des naissances terminées
        $taskenddecedejas = DecesSimple::where('etat', 'terminé')
         ->latest()
         ->paginate(10);
        return view('mairie.demandes.history.taskenddeces',compact(
            'taskenddeces',
            'taskenddecedejas'
        ));
    }

    public function taskendmariages(){
         // Récupération des mariages terminés
         $taskendmariages = Mariage::where('etat', 'terminé')
            ->latest()
            ->paginate(10);

        return view('mairie.demandes.history.taskendmariages',compact(
            'taskendmariages',
        ));
    }
}
