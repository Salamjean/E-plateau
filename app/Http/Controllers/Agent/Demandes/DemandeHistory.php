<?php

namespace App\Http\Controllers\Agent\Demandes;

use App\Http\Controllers\Controller;
use App\Models\DecesCertificat;
use App\Models\DecesSimple;
use App\Models\DeclarationNaissance;
use App\Models\Mariage;
use App\Models\NaissanceCertificat;
use App\Models\NaissanceSimple;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DemandeHistory extends Controller
{
    public function taskend() {
        // Récupérer l'admin connecté
        $admin = Auth::guard('agent')->user();
    
        // Récupération des mariages terminés
        $taskendnaissanceDs = NaissanceSimple::where('etat', 'terminé')
            ->where('agent_id', $admin->id) // Filtrage par agent
            ->latest()
            ->paginate(10);
    
        // Récupération des naissances terminées
        $taskendnaissances = NaissanceCertificat::where('etat', 'terminé')
            ->where('agent_id', $admin->id) // Filtrage par agent
            ->latest()
            ->paginate(10);
        $naisshop = DeclarationNaissance::first();
    
        return view('agent.demandes.history.taskends', compact(
            'taskendnaissanceDs',
            'taskendnaissances',
            'naisshop'
        ));
    }

    public function taskenddeces(){
        // Récupérer l'admin connecté
        $admin = Auth::guard('agent')->user();

         // Récupération des mariages terminés
         $taskenddeces = DecesCertificat::where('etat', 'terminé')
         ->where('agent_id', $admin->id) // Filtrage par agent
         ->latest()
         ->paginate(10);
 
        // Récupération des naissances terminées
        $taskenddecedejas = DecesSimple::where('etat', 'terminé')
         ->where('agent_id', $admin->id) // Filtrage par agent
         ->latest()
         ->paginate(10);

        return view('agent.demandes.history.taskenddeces',compact(
            'taskenddeces',
            'taskenddecedejas'
        ));
    }

    public function taskendmariages(){
        // Récupérer l'admin connecté
        $admin = Auth::guard('agent')->user();

         // Récupération des mariages terminés
         $taskendmariages = Mariage::where('etat', 'terminé')
         ->where('agent_id', $admin->id) // Filtrage par agent
         ->latest()
         ->paginate(10);

        return view('agent.demandes.history.taskendmariages',compact('taskendmariages'));
    }
}
