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
        
        // Validation de l'état
        $request->validate([
            'etat' => 'required|string|in:en attente,réçu,terminé',
        ]);

        // Mise à jour de l'état
        $mariage->etat = $request->etat;

        // Si l'état est "terminé" ET choix_option = "livraison" ET pas encore de code
        if ($mariage->etat === 'terminé' && $mariage->choix_option === 'livraison' && is_null($mariage->livraison_code)) {
            // Générer un code de livraison unique
            $livraisonCode = 'LIVM' . str_pad(mt_rand(1, 9999999), 7, '0', STR_PAD_LEFT);

            // Vérifier que le code est unique
            while (Mariage::where('livraison_code', $livraisonCode)->exists()) {
                $livraisonCode = 'LIVM' . str_pad(mt_rand(1, 9999999), 7, '0', STR_PAD_LEFT);
            }

            // Mettre à jour la demande
            $mariage->livraison_id = 1; // à adapter si tu as une vraie gestion des livraisons
            $mariage->livraison_code = $livraisonCode;
            $mariage->statut_livraison = 'en attente';
        }

        // Sauvegarder
        $mariage->save();

        // Redirection en fonction de l'état
        if ($mariage->etat === 'terminé') {
            return redirect()->route('agent.history.taskendmariages')
                ->with('success', 'État mis à jour avec succès' .
                    ($mariage->choix_option === 'livraison' ? ' et livraison initiée (Code: ' . $mariage->livraison_code . ')' : ''));
        } else {
            return redirect()->route('agent.demandes.wedding.index')
                ->with('success', 'État mis à jour avec succès');
        }
    }


}
