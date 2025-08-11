<?php

namespace App\Http\Controllers\Agent\Demandes;

use App\Http\Controllers\Controller;
use App\Models\DecesCertificat;
use App\Models\DecesSimple;
use App\Models\DeclarationDeces;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DemandeDecesAgentController extends Controller
{
    public function index(Request $request)
    {
        // Récupérer l'admin connecté
        $admin = Auth::guard('agent')->user();

        // Requête pour Deces
        $decesQuery = DecesCertificat::where('commune', $admin->communeM)
            ->where('agent_id', $admin->id)
            ->where('etat', '!=', 'terminé') // <-- uniquement celles qui ne sont pas terminées
            ->with('user'); // Filtrage par agent et récupération des relations

        // Requête pour Decesdeja
        $decesdejaQuery = DecesSimple::where('commune', $admin->communeM)
            ->where('agent_id', $admin->id)
            ->where('etat', '!=', 'terminé') // <-- uniquement celles qui ne sont pas terminées
            ->with('user'); // Filtrage par agent et récupération des relations

        // Appliquer les filtres de recherche pour Deces
        if ($request->filled('searchType') && $request->filled('searchInput')) {
            if ($request->searchType === 'nomDefunt') {
                $decesQuery->where('nomDefunt', 'like', '%' . $request->searchInput . '%');
            } elseif ($request->searchType === 'nomHopital') {
                $decesQuery->where('nomHopital', 'like', '%' . $request->searchInput . '%');
            }
        }

        // Appliquer les filtres de recherche pour Decesdeja
        if ($request->filled('searchType') && $request->filled('searchInput')) {
            if ($request->searchType === 'nomDefunt') {
                $decesdejaQuery->where('nomDefunt', 'like', '%' . $request->searchInput . '%');
            } elseif ($request->searchType === 'nomHopital') {
                $decesdejaQuery->where('nomHopital', 'like', '%' . $request->searchInput . '%');
            }
        }

        // Paginer les résultats
        $deces = $decesQuery->paginate(10);
        $decesdeja = $decesdejaQuery->paginate(10);

        // Passer les données à la vue
        return view('agent.demandes.deces.deces', compact('deces', 'decesdeja'));
    }

    public function edit($id)
    {
        $deces = DecesCertificat::findOrFail($id);

        // Les états possibles à afficher dans le formulaire
        $etats = ['en attente', 'réçu', 'terminé'];

        return view('agent.demandes.deces.edit_etat_avec', compact('deces', 'etats'));
    }

    public function updateEtat(Request $request, $id)
    {
        $deces = DecesCertificat::findOrFail($id);
        $request->validate([
            'etat' => 'required|string|in:en attente,réçu,terminé', // Ajouter les états possibles
        ]);

        // Mise à jour de l'état
        $deces->etat = $request->etat;
        $deces->save();
        
        return redirect()->route('agent.demandes.deces.index')->with('success', 'Etat de la demande a été mis à jour.');
    }

    public function editSimple($id)
    {
        $decesdeja = DecesSimple::findOrFail($id);

        // Les états possibles à afficher dans le formulaire
        $etats = ['en attente', 'réçu', 'terminé'];

        return view('agent.demandes.deces.edit_etat_sans', compact('decesdeja', 'etats'));

    }

    public function updateEtatSimple(Request $request, $id)
    {
        $decesdeja = DecesSimple::findOrFail($id);
        $request->validate([
            'etat' => 'required|string|in:en attente,réçu,terminé', 
        ]);

        // Mise à jour de l'état
        $decesdeja->etat = $request->etat;
        $decesdeja->save();
        
        return redirect()->route('agent.demandes.deces.index')->with('success', 'Etat de la demande a été mis à jour.');
    }

    public function declarationDeces(){

        $sousadmin = Auth::guard('agent')->user();
        
        // Récupérer la commune de l'administrateur
        $communeAdmin = $sousadmin->communeM; // Ajustez selon votre logique
    
        // Récupérer les déclarations de naissances filtrées par la commune de l'administrateur
        $deceshops = DeclarationDeces::where('commune', $communeAdmin)->get();
    
        return view('agent.declarations.deces', [
            'deceshops' => $deceshops,
            'sousadmin' => $sousadmin
        ]);
    }
}
