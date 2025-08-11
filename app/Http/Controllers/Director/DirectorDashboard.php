<?php

namespace App\Http\Controllers\Director;

use App\Http\Controllers\Controller;
use App\Models\DeclarationDeces;
use App\Models\DeclarationNaissance;
use App\Models\Doctor;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DirectorDashboard extends Controller
{
     public function dashboard(Request $request) {
        // Récupérer le sousadmin connecté
        $sousadmin = auth('director')->user();
        
        // Récupérer les détails du sousadmin
        $sousadminDetails = Doctor::find($sousadmin->id);
        
        // Récupérer le mois et l'année sélectionnés, ou la date actuelle par défaut
        $selectedMonth = $request->input('month', Carbon::now()->month);
        $selectedYear = $request->input('year', Carbon::now()->year);
        
        // Compter le total des déclarations pour le mois sélectionné
        $communeAdmin = $sousadmin->nomHop;
        $docteur = Doctor::where('nomHop', $communeAdmin)
            ->whereYear('created_at', $selectedYear)
            ->count();
        $naisshop = DeclarationNaissance::where('NomEnf', $communeAdmin)
            ->whereYear('created_at', $selectedYear)
            ->count();
        $deceshop = DeclarationDeces::where('nomHop', $communeAdmin)
            ->whereYear('created_at', $selectedYear)
            ->count();
        
        // Récupérer les données pour les graphiques
        $naissData = DeclarationNaissance::where('NomEnf', $communeAdmin)
           ->whereYear('created_at', $selectedYear)
           ->selectRaw('MONTH(created_at) as month, COUNT(*) as count')
           ->groupBy('month')
           ->orderBy('month')
           ->pluck('count', 'month')->toArray();
        
        // Remplir les données manquantes
        $naissData = array_replace(array_fill(1, 12, 0), $naissData);
        $total = $naisshop + $deceshop ;
        // Récupérer les données de décès
        $decesData = DeclarationDeces::where('nomHop', $communeAdmin)
           ->whereYear('created_at', $selectedYear)
           ->selectRaw('MONTH(created_at) as month, COUNT(*) as count')
           ->groupBy('month')
           ->orderBy('month')
           ->pluck('count', 'month')->toArray();
        
        // Remplir les données manquantes
        $decesData = array_replace(array_fill(1, 12, 0), $decesData);
        
        // Passer les données à la vue
        return view('director.dashboard', compact('sousadminDetails', 'naisshop', 'deceshop', 'docteur', 'total',
            'selectedMonth', 'selectedYear', 'naissData', 'decesData'));
    }

    public function logout(){
        auth('director')->logout();
        return redirect()->route('directeur.login');
    }


    public function doctor() {
        // Récupérer l'administrateur connecté
        $directors = auth('director')->user();
        
        // Récupérer la commune de l'administrateur
        $communeAdmin = $directors->nomHop; // Ajustez selon votre logique

        // Récupérer les sous-administrateurs filtrés par la commune
        $sousadmins = Doctor::where('nomHop', $communeAdmin)->get();

        return view('director.doctor', compact('sousadmins'));
    }

    public function birth() {
        // Récupérer l'administrateur connecté
        $directeur = Auth::guard('director')->user();
        
        // Récupérer la commune de l'administrateur
        $communeAdmin = $directeur->nomHop;
        
        // Récupérer les déclarations de naissances filtrées par la commune de l'administrateur 
        $naisshops = DeclarationNaissance::where('NomEnf', $communeAdmin)
                    ->with('enfants') // Chargement eager des relations 'enfants' pour éviter le problème N+1
                    ->get();
        
        return view('director.birth', ['naisshops' => $naisshops]);
    }

    public function death() {
        // Récupérer l'administrateur connecté
        $directeur = Auth::guard('director')->user();
        // Récupérer la commune de l'administrateur
        $communeAdmin = $directeur->nomHop;
        // Récupérer les déclarations de décès filtrées par la commune de l'administrateur et l'ID du sous-administrateur
        $deceshops = DeclarationDeces::where('nomHop', $communeAdmin)->get();

        return view('director.death', ['deceshops' => $deceshops]);
    }
}
