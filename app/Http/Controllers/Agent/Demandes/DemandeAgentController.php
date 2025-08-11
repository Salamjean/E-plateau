<?php

namespace App\Http\Controllers\Agent\Demandes;

use App\Http\Controllers\Controller;
use App\Models\DeclarationNaissance;
use App\Models\NaissanceCertificat;
use App\Models\NaissanceSimple;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DemandeAgentController extends Controller
{
    public function index()
    {
        $admin = Auth::guard('agent')->user();
        $naisshop = DeclarationNaissance::first();

        $naissances = NaissanceCertificat::where('commune', $admin->communeM)
            ->where('agent_id', $admin->id)
            ->where('etat', '!=', 'terminé')
            ->whereNull('archived_at')
            ->with('user')
            ->paginate(10);

        $naissancesD = NaissanceSimple::where('commune', $admin->communeM)
            ->where('agent_id', $admin->id)
            ->where('etat', '!=', 'terminé') 
            ->with('user')
            ->paginate(10);

        return view('agent.demandes.naissances.naissance', compact('naissances', 'naissancesD', 'naisshop'));
    }


    public function edit($id)
    {
        $naissance = NaissanceCertificat::findOrFail($id);

        // Les états possibles à afficher dans le formulaire
        $etats = ['en attente', 'réçu', 'terminé'];

        return view('agent.demandes.naissances.edit_etat_avec', compact('naissance', 'etats'));
    }

    public function updateEtat(Request $request, $id)
    {
        $naissance = NaissanceCertificat::findOrFail($id);
        
        // Validation de l'état (si nécessaire)
        $request->validate([
            'etat' => 'required|string|in:en attente,réçu,terminé', // Ajouter les états possibles
        ]);

        // Mise à jour de l'état
        $naissance->etat = $request->etat;
        $naissance->save();
        
        return redirect()->route('agent.demandes.naissance.index')->with('success', "Etat de la demande a été mis à jour.");
    }

    public function editSimple($id)
    {
        $naissanced = NaissanceSimple::findOrFail($id);

        // Les états possibles à afficher dans le formulaire
        $etats = ['en attente', 'réçu', 'terminé'];

        return view('agent.demandes.naissances.edit_etat_sans', compact('naissanced', 'etats'));
    }

    public function updateEtatSimple(Request $request, $id)
    {
        $naissanced = NaissanceSimple::findOrFail($id);
        
        // Validation de l'état (si nécessaire)
        $request->validate([
            'etat' => 'required|string|in:en attente,réçu,terminé', // Ajouter les états possibles
        ]);

        $naissanced->etat = $request->etat;
        $naissanced->save();
        
        return redirect()->route('agent.demandes.naissance.index')->with('success', 'Etat de la demande a été mis à jour.');
    }

    public function declarationNaissance() {
        $sousadmin = Auth::guard('agent')->user();
        
        // Récupérer la commune de l'administrateur
        $communeAdmin = $sousadmin->communeM; // Ajustez selon votre logique
    
        // Récupérer les déclarations de naissances filtrées par la commune de l'administrateur
        $naisshops = DeclarationNaissance::where('commune', $communeAdmin)
        ->with('enfants') // Chargement eager des relations 'enfants' pour éviter le problème N+1
        ->get();
    
        return view('agent.declarations.naissance', [
            'naisshops' => $naisshops,
            'sousadmin' => $sousadmin
        ]);
    }
}
