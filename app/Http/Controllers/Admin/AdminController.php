<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Agent;
use App\Models\Caisse;
use App\Models\DecesCertificat;
use App\Models\DecesSimple;
use App\Models\DeclarationDeces;
use App\Models\DeclarationNaissance;
use App\Models\Doctor;
use App\Models\Mairie;
use App\Models\Mariage;
use App\Models\NaissanceCertificat;
use App\Models\NaissanceSimple;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
     public function dashboard(){
      $deces = DecesCertificat::count();
      $decesdeja = DecesSimple::count();
      $mariage = Mariage::count();
      $naissance = NaissanceCertificat::count();
      $naissanceD = NaissanceSimple::count();
      $naisshop = DeclarationNaissance::count();
      $deceshop = DeclarationDeces::count();
      $agents = Agent::count();
      $caisses = Caisse::count();

      $mairie = Mairie::whereNull('archived_at')->count();
      $sousadmin = Doctor::count();
      $total = $deces + $decesdeja + $mariage + $naissance + $naissanceD;


         // Récupérer le solde total de toutes les mairies
      $soldeTotalMairies = Mairie::whereNull('archived_at')->sum('solde');
      // Solde initial
      $soldeActuel =  $soldeTotalMairies;

      // Déduction pour chaque nouvelle demande
      $debit = 500; // Montant à déduire pour chaque demande
      $soldeDebite = $total * $debit; // Total débité basé sur le nombre de demandes
      $soldeRestant = $soldeActuel - $soldeDebite; // Calcul du solde restant

  

    return view('admin.dashboard', compact(
        'deces', 'decesdeja', 'mariage', 'naissance',
        'naissanceD', 'total', 'soldeActuel', 'soldeDebite', 'soldeRestant',
        'deceshop', 'naisshop', 'agents', 'caisses', 'mairie', 'sousadmin', 'soldeTotalMairies',
    ));
   }

   public function logout()
    {
        Auth::guard('admin')->logout();
        return redirect()->route('admin.login');
    }
}
