<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DoctorDashboard extends Controller
{
    public function dashboard(Request $request)
        {
            try {
                $sousadmin = Auth::guard('doctor')->user();
                // $communeAdmin = $sousadmin->nomHop;
                // $sousAdminId = $sousadmin->id; // Récupérer l'ID du sous-administrateur

                // // Récupérer les déclarations de naissances du jour en cours
                // $declarationsRecents = NaissHop::where('NomEnf', $communeAdmin)
                //     ->where('sous_admin_id', $sousAdminId) // Filtrer par ID de sous-administrateur
                //     ->whereDate('created_at', now()->format('Y-m-d')) // Filtrer par date
                //     ->orderBy('created_at', 'desc')
                //     ->take(3)
                //     ->get();

                // // Récupérer les déclarations de décès du jour en cours
                // $decesRecents = DecesHop::where('nomHop', $communeAdmin)
                //     ->where('sous_admin_id', $sousAdminId) // Filtrer par ID de sous-administrateur
                //     ->whereDate('created_at', now()->format('Y-m-d')) // Filtrer par date
                //     ->orderBy('created_at', 'desc')
                //     ->take(3)
                //     ->get();

                // // Compter les déclarations par mois
                // $naisshopData = NaissHop::select(DB::raw("DATE_FORMAT(created_at, '%Y-%m') as month"), DB::raw('count(*) as count'))
                //     ->where('NomEnf', $communeAdmin)
                //     ->where('sous_admin_id', $sousAdminId) // Filtrer par ID de sous-administrateur
                //     ->groupBy('month')
                //     ->orderBy('month')
                //     ->pluck('count', 'month');

                // $deceshopData = DecesHop::select(DB::raw("DATE_FORMAT(created_at, '%Y-%m') as month"), DB::raw('count(*) as count'))
                //     ->where('nomHop', $communeAdmin)
                //     ->where('sous_admin_id', $sousAdminId) // Filtrer par ID de sous-administrateur
                //     ->groupBy('month')
                //     ->orderBy('month')
                //     ->pluck('count', 'month');

                // // Récupérer le mois et l'année sélectionnés
                // $selectedMonth = $request->input('month', date('m'));
                // $selectedYear = $request->input('year', date('Y'));

                // // Compter le total des déclarations de naissance et de décès pour le mois sélectionné
                // $naisshop = NaissHop::where('NomEnf', $communeAdmin)
                //     ->where('sous_admin_id', $sousAdminId) // Filtrer par ID de sous-administrateur
                //     ->whereMonth('created_at', $selectedMonth)
                //     ->whereYear('created_at', $selectedYear)
                //     ->count();

                // $deceshop = DecesHop::where('nomHop', $communeAdmin)
                //     ->where('sous_admin_id', $sousAdminId) // Filtrer par ID de sous-administrateur
                //     ->whereMonth('created_at', $selectedMonth)
                //     ->whereYear('created_at', $selectedYear)
                //     ->count();

                // // Récupérer les données pour les graphiques (Naissances)
                // $naissData = NaissHop::where('NomEnf', $communeAdmin)
                //     ->where('sous_admin_id', $sousAdminId) // Filtrer par ID de sous-administrateur
                //     ->whereYear('created_at', $selectedYear)
                //     ->selectRaw('MONTH(created_at) as month, COUNT(*) as count')
                //     ->groupBy('month')
                //     ->orderBy('month')
                //     ->pluck('count', 'month')
                //     ->toArray();

                // // Remplir les données manquantes pour les naissances
                // $naissData = array_replace(array_fill(1, 12, 0), $naissData);

                // // Calculer le total des déclarations
                // $total = $naisshop + $deceshop;

                // // Récupérer les données pour les graphiques (Décès)
                // $decesData = DecesHop::where('nomHop', $communeAdmin)
                //     ->where('sous_admin_id', $sousAdminId) // Filtrer par ID de sous-administrateur
                //     ->whereYear('created_at', $selectedYear)
                //     ->selectRaw('MONTH(created_at) as month, COUNT(*) as count')
                //     ->groupBy('month')
                //     ->orderBy('month')
                //     ->pluck('count', 'month')
                //     ->toArray();

                // // Remplir les données manquantes pour les décès
                // $decesData = array_replace(array_fill(1, 12, 0), $decesData);

                // Passer les données à la vue
                return view('doctor.dashboard');
            } catch (Exception $e) {
                // Gérer les erreurs
                return redirect()->back()->with('error', 'Une erreur s\'est produite lors de la récupération des données.');
            }
        }

        public function logout(){
            Auth::guard('doctor')->logout();
            return redirect()->route('doctor.login');
        }
}
