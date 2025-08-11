<?php

namespace App\Http\Controllers\Agent\Demandes;

use App\Http\Controllers\Controller;
use App\Models\Mariage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DemandeMariageAgentController extends Controller
{
    public function index(Request $request)
    {
        // Récupérer l'admin connecté
        $admin = Auth::guard('agent')->user();

        // Initialiser la requête pour Mariage et filtrer par commune de l'admin
        $query = Mariage::where('commune', $admin->communeM)
        ->where('etat', '!=', 'terminé') // <-- uniquement celles qui ne sont pas terminées
            ->where('agent_id', $admin->id)
            ->with('user'); // Ajout de la récupération de la relation 'user'

        // Vérifier le type de recherche et appliquer le filtre
        if ($request->filled('searchType') && $request->filled('searchInput')) {
            if ($request->searchType === 'nomConjoint') {
                $query->where(function($q) use ($request) {
                    $q->where('nomEpoux', 'like', '%' . $request->searchInput . '%')
                        ->orWhere('nomEpouse', 'like', '%' . $request->searchInput . '%');
                });
            } elseif ($request->searchType === 'prenomConjoint') {
                $query->where(function($q) use ($request) {
                $q->where('prenomEpoux', 'like', '%' . $request->searchInput . '%')
                    ->orWhere('prenomEpouse', 'like', '%' . $request->searchInput . '%');
                });
            } elseif ($request->searchType === 'lieuNaissance') {
                $query->where(function($q) use ($request) {
                    $q->where('lieuNaissanceEpoux', 'like', '%' . $request->searchInput . '%')
                        ->orWhere('lieuNaissanceEpouse', 'like', '%' . $request->searchInput . '%');
                });
            }
        }
        
        // Récupérer tous les mariages correspondant aux critères de filtrage
        $mariages = $query->paginate(10);

        // Retourner la vue avec les mariages filtrés et les alertes
        return view('agent.demandes.mariages.index', compact('mariages'));
    }

    public function edit($id)
    {
        $mariage = Mariage::findOrFail($id);

        // Les états possibles à afficher dans le formulaire
        $etats = ['en attente', 'réçu', 'terminé'];

        return view('agent.demandes.mariages.edit', compact('mariage', 'etats'));
    }

    public function updateEtat(Request $request, $id)
    {
        $mariage = Mariage::findOrFail($id);
        
        // Validation de l'état (si nécessaire)
        $request->validate([
            'etat' => 'required|string|in:en attente,réçu,terminé', // Ajouter les états possibles
        ]);

        // Mise à jour de l'état
        $mariage->etat = $request->etat;
        $mariage->save();
        
        return redirect()->route('agent.demandes.wedding.index')->with('success', 'Etat de la demande a été mis à jour.');
    }

}
