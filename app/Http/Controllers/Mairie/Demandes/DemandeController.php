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
use Illuminate\Support\Facades\Auth;

class DemandeController extends Controller
{
    public function index()
    {
        // Récupérer l'admin connecté
        $admin = Auth::guard('mairie')->user();
        $naisshop = DeclarationNaissance::first();
    
        // Filtrer les naissances selon la commune de l'admin connecté
        $naissances = NaissanceCertificat::where('commune', $admin->name)->paginate(10); // Filtrage par commune
        $naissancesD = NaissanceSimple::where('commune', $admin->name)->paginate(10); // Filtrage par commune
    
        // Retourner la vue avec les données
        return view('mairie.demandes.naissance', compact('naissances', 'naissancesD','naisshop'));
    }

    public function indexDeces(Request $request)
    {
        // Récupérer l'admin connecté
        $admin = Auth::guard('mairie')->user();

        // Initialiser la requête pour Deces en filtrant par commune
        $query = DecesCertificat::where('commune', $admin->name); // Filtrer par commune
        $querys = DecesSimple::where('commune', $admin->name); // Filtrer par commune

        // Vérifier le type de recherche et appliquer le filtre
        if ($request->filled('searchType') && $request->filled('searchInput')) {
            if ($request->searchType === 'nomDefunt') {
                $query->where('nomDefunt', 'like', '%' . $request->searchInput . '%');
            } elseif ($request->searchType === 'nomHopital') {
                $query->where('nomHopital', 'like', '%' . $request->searchInput . '%');
            }
        }

        // Récupérer les résultats filtrés
        $deces = $query->get();
        $decesdeja = $querys->get();

        return view('mairie.demandes.deces', compact('deces', 'decesdeja'));
    }

    public function indexWedding(){
         // Récupérer la mairie connecté
        $admin = Auth::guard('mairie')->user();

         // Filtrer les demandes selon la commune de la mairie connecté
        $mariages = Mariage::where('commune', $admin->name)->paginate(10);

        return view('mairie.demandes.mariage', compact('mariages'));
    }
}
