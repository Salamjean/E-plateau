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
    
    // Validation de l'état
    $request->validate([
        'etat' => 'required|string|in:en attente,réçu,terminé',
    ]);

    // Mise à jour de l'état
    $naissance->etat = $request->etat;

    // Si l'état est "terminé" ET choix_option = "livraison" ET pas encore de code
    if ($naissance->etat === 'terminé' && $naissance->choix_option === 'livraison' && is_null($naissance->livraison_code)) {
        // Générer un code de livraison unique
        $livraisonCode = 'LIVN' . str_pad(mt_rand(1, 9999999), 7, '0', STR_PAD_LEFT);

        // Vérifier que le code est unique
        while (NaissanceCertificat::where('livraison_code', $livraisonCode)->exists()) {
            $livraisonCode = 'LIVN' . str_pad(mt_rand(1, 9999999), 7, '0', STR_PAD_LEFT);
        }

        // Mettre à jour la demande
        $naissance->livraison_id = 1; // à remplacer si tu as une vraie table de livraisons
        $naissance->livraison_code = $livraisonCode;
        $naissance->statut_livraison = 'en attente';
    }

    // Sauvegarder
    $naissance->save();

    // Redirection en fonction de l'état
    if ($naissance->etat === 'terminé') {
        return redirect()->route('agent.history.taskend')
            ->with('success', 'État mis à jour avec succès' .
                ($naissance->choix_option === 'livraison' ? ' et livraison initiée (Code: ' . $naissance->livraison_code . ')' : ''));
    } else {
        return redirect()->route('agent.demandes.naissance.index')
            ->with('success', 'État mis à jour avec succès');
    }
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

        // Validation de l'état
        $request->validate([
            'etat' => 'required|string|in:en attente,réçu,terminé',
        ]);

        // Mise à jour de l'état
        $naissanced->etat = $request->etat;

        // Si l'état est "terminé" ET choix_option = "livraison" ET pas encore de code
        if ($naissanced->etat === 'terminé' && $naissanced->choix_option === 'livraison' && is_null($naissanced->livraison_code)) {
            // Générer un code de livraison unique
            $livraisonCode = 'LIVN' . str_pad(mt_rand(1, 9999999), 7, '0', STR_PAD_LEFT);

            // Vérifier que le code est unique
            while (NaissanceSimple::where('livraison_code', $livraisonCode)->exists()) {
                $livraisonCode = 'LIVN' . str_pad(mt_rand(1, 9999999), 7, '0', STR_PAD_LEFT);
            }

            // Mettre à jour la demande
            $naissanced->livraison_id = 1; // à adapter selon ta logique
            $naissanced->livraison_code = $livraisonCode;
            $naissanced->statut_livraison = 'en attente';
        }

        // Sauvegarder
        $naissanced->save();

        // Redirection en fonction de l'état
        if ($naissanced->etat === 'terminé') {
            return redirect()->route('agent.history.taskend')
                ->with('success', 'État mis à jour avec succès' .
                    ($naissanced->choix_option === 'livraison' ? ' et livraison initiée (Code: ' . $naissanced->livraison_code . ')' : ''));
        } else {
            return redirect()->route('agent.demandes.naissance.index')
                ->with('success', 'État mis à jour avec succès');
        }
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
