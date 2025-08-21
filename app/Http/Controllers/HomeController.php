<?php

namespace App\Http\Controllers;

use App\Models\DecesCertificat;
use App\Models\DecesSimple;
use App\Models\Mariage;
use App\Models\NaissanceCertificat;
use App\Models\NaissanceSimple;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function home(){
        return view('home.home');
    }

    public function recherche(Request $request){
        $etatDemande = null; // Initialisation de l'état de la demande
        $reference = null; // Initialisation de la référence recherchée

        if ($request->isMethod('post')) { // Vérifier si c'est une requête POST (formulaire soumis)
            $reference = $request->input('reference_naissance'); // On utilise toujours le même nom de champ depuis la vue

            if ($reference) {
                // Rechercher dans la table 'naissances'
                $naissance = NaissanceCertificat::where('reference', $reference)->first();
                if ($naissance) {
                    $etatDemande = $naissance->etat;
                    return view('home.recherche', compact('etatDemande', 'reference')); // Passer $etatDemande et $reference à la vue
                }

                // Rechercher dans la table 'naissance_d_s' (en supposant que votre modèle est NaissanceDS)
                $naissanceDS = NaissanceSimple::where('reference', $reference)->first();
                if ($naissanceDS) {
                    $etatDemande = $naissanceDS->etat;
                    return view('home.recherche', compact('etatDemande', 'reference'));
                }

                // Rechercher dans la table 'deces'
                $deces = DecesCertificat::where('reference', $reference)->first();
                if ($deces) {
                    $etatDemande = $deces->etat;
                    return view('home.recherche', compact('etatDemande', 'reference'));
                }

                // Rechercher dans la table 'decesdejas' (en supposant que votre modèle est Decesdeja)
                $decesdeja = DecesSimple::where('reference', $reference)->first();
                if ($decesdeja) {
                    $etatDemande = $decesdeja->etat;
                    return view('home.recherche', compact('etatDemande', 'reference'));
                }

                // Rechercher dans la table 'mariages'
                $mariage = Mariage::where('reference', $reference)->first();
                if ($mariage) {
                    $etatDemande = $mariage->etat;
                    return view('home.recherche', compact('etatDemande', 'reference'));
                }

                $etatDemande = false; // Aucune demande trouvée pour cette référence dans aucune table
            }
        }

        return view('home.recherche', compact('etatDemande', 'reference')); // Passer $etatDemande et $reference à la vue
    }

    public function about(){
        return view('home.about');
    }

    public function service(){
        return view('home.service');
    }
    public function department(){
        return view('home.department');
    }
    public function birth(){
        return view('home.naissance');
    }
    public function death(){
        return view('home.deces');
    }
    public function wedding(){
        return view('home.mariage');
    }

    public function rendezvous(){
        return view('home.rendezvous');
    }
    public function contact(){
        return view('home.contact');
    }
}
