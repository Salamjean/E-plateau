<?php

namespace App\Http\Controllers\Hopital;

use App\Http\Controllers\Controller;
use App\Models\DeclarationDeces;
use App\Models\DeclarationNaissance;
use App\Models\Doctor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use PDF;

class StatistiqueController extends Controller
{
    public function index(Request $request)
    {
        $sousadmin = Auth::guard('hopital')->user();
        $communeAdmin = $sousadmin->nomHop;
        $sousAdminId = $sousadmin->id;

        // Récupérer le mois et l'année sélectionnés
        $selectedMonth = $request->input('month', date('m'));
        $selectedYear = $request->input('year', date('Y'));

        // Compter le total des déclarations de naissance et de décès pour le mois sélectionné
        $docteur = Doctor::where('nomHop', $communeAdmin)
            ->whereMonth('created_at', $selectedMonth)
            ->whereYear('created_at', $selectedYear)
            ->count();

        $naisshop = DeclarationNaissance::where('NomEnf', $communeAdmin)
            ->whereMonth('created_at', $selectedMonth)
            ->whereYear('created_at', $selectedYear)
            ->count();

        $deceshop = DeclarationDeces::where('nomHop', $communeAdmin)
            ->whereMonth('created_at', $selectedMonth)
            ->whereYear('created_at', $selectedYear)
            ->count();

        // Récupérer les données pour les graphiques (Naissances)
        $naissData = DeclarationNaissance::where('NomEnf', $communeAdmin)
            ->whereYear('created_at', $selectedYear)
            ->selectRaw('MONTH(created_at) as month, COUNT(*) as count')
            ->groupBy('month')
            ->orderBy('month')
            ->pluck('count', 'month')
            ->toArray();

        // Remplir les données manquantes pour les naissances
        $naissData = array_replace(array_fill(1, 12, 0), $naissData);

        // Calculer le total des déclarations
        $total = $naisshop + $deceshop;

        // Récupérer les données pour les graphiques (Décès)
        $decesData = DeclarationDeces::where('nomHop', $communeAdmin)
            ->whereYear('created_at', $selectedYear)
            ->selectRaw('MONTH(created_at) as month, COUNT(*) as count')
            ->groupBy('month')
            ->orderBy('month')
            ->pluck('count', 'month')
            ->toArray();

        // Remplir les données manquantes pour les décès
        $decesData = array_replace(array_fill(1, 12, 0), $decesData);

        // Vérifier si le téléchargement en PDF est demandé
        if ($request->has('download_pdf')) {
            $pdf = PDF::loadView('hopital.stat.pdf', compact('naisshop', 'deceshop', 'total', 'selectedMonth', 'selectedYear', 'naissData', 'decesData'));
            return $pdf->download('statistiques_hopital.pdf');
        }

        return view('hopital.stat.index', compact('naisshop', 'deceshop', 'docteur', 'total', 'selectedMonth', 'selectedYear', 'naissData', 'decesData'));
    }

    public function download(Request $request)
    {
        $sousadmin = Auth::guard('doctor')->user();
        $communeAdmin = $sousadmin->nomHop;
        $hopitalName = $sousadmin->nomHop;

        // Récupérer le mois et l'année sélectionnés
        $selectedMonth = $request->input('month', date('m'));
        $selectedYear = $request->input('year', date('Y'));

        // Compter les naissances et décès
        $naisshopCount = DeclarationNaissance::count();
        $deceshopCount = DeclarationDeces::count();

        // Récupérer les données par mois pour les naissances
        $naissData = DeclarationNaissance::where('NomEnf', $communeAdmin)
            ->whereYear('created_at', $selectedYear)
            ->selectRaw('MONTH(created_at) as month, COUNT(*) as count')
            ->groupBy('month')
            ->orderBy('month')
            ->pluck('count', 'month')
            ->toArray();

        // Récupérer les données par mois pour les décès
        $decesData = DeclarationDeces::where('nomHop', $communeAdmin)
            ->whereYear('created_at', $selectedYear)
            ->selectRaw('MONTH(created_at) as month, COUNT(*) as count')
            ->groupBy('month')
            ->orderBy('month')
            ->pluck('count', 'month')
            ->toArray();

        // Préparer les données pour le PDF
        $data = [
            'naisshopCount' => $naisshopCount,
            'deceshopCount' => $deceshopCount,
            'hopitalName' => $hopitalName,
            'naissData' => $naissData,
            'decesData' => $decesData,
        ];

        // Générer le PDF
        $pdf = PDF::loadView('hopital.stat.pdf', $data);

        // Retourner le PDF en téléchargement
        return $pdf->download('statistiques_hopital.pdf');
    }
}
