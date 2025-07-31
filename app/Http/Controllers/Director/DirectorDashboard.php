<?php

namespace App\Http\Controllers\Director;

use App\Http\Controllers\Controller;
use App\Models\Doctor;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DirectorDashboard extends Controller
{
     public function dashboard(Request $request) {
        // Récupérer le sousadmin connecté
        $director = auth('director')->user();
        
        // Récupérer les détails du sousadmin
        $sousadminDetails = Doctor::find($director->id);
        
        // // Récupérer le mois et l'année sélectionnés, ou la date actuelle par défaut
        $selectedMonth = $request->input('month', Carbon::now()->month);
        $selectedYear = $request->input('year', Carbon::now()->year);
        
        // Compter le total des déclarations pour le mois sélectionné
        $communeAdmin = $director->nomHop;
        $docteur = Doctor::where('nomHop', $communeAdmin)
            ->whereYear('created_at', $selectedYear)
            ->count();
        // $naisshop = NaissHop::where('NomEnf', $communeAdmin)
        //     ->whereYear('created_at', $selectedYear)
        //     ->count();
        // $deceshop = DecesHop::where('nomHop', $communeAdmin)
        //     ->whereYear('created_at', $selectedYear)
        //     ->count();
        
        // // Récupérer les données pour les graphiques
        // $naissData = NaissHop::where('NomEnf', $communeAdmin)
        //    ->whereYear('created_at', $selectedYear)
        //    ->selectRaw('MONTH(created_at) as month, COUNT(*) as count')
        //    ->groupBy('month')
        //    ->orderBy('month')
        //    ->pluck('count', 'month')->toArray();
        
        // // Remplir les données manquantes
        // $naissData = array_replace(array_fill(1, 12, 0), $naissData);
        // $total = $naisshop + $deceshop ;
        // // Récupérer les données de décès
        // $decesData = DecesHop::where('nomHop', $communeAdmin)
        //    ->whereYear('created_at', $selectedYear)
        //    ->selectRaw('MONTH(created_at) as month, COUNT(*) as count')
        //    ->groupBy('month')
        //    ->orderBy('month')
        //    ->pluck('count', 'month')->toArray();
        
        // // Remplir les données manquantes
        // $decesData = array_replace(array_fill(1, 12, 0), $decesData);
        
        // Passer les données à la vue
        return view('director.dashboard', compact('sousadminDetails' ,'docteur'));
    }

    public function logout(){
        auth('director')->logout();
        return redirect()->route('directeur.login');
    }
}
