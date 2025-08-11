<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use App\Models\DeclarationDeces;
use App\Models\DeclarationNaissance;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use PDF;

class StatistiqueController extends Controller
{
    public function statistique(Request $request)
    {
        $sousadmin = Auth::guard('doctor')->user();
        $communeAdmin = $sousadmin->nomHop;
        $sousAdminId = $sousadmin->id;

        // Récupérer le mois et l'année sélectionnés
        $selectedMonth = $request->input('month', date('m'));
        $selectedYear = $request->input('year', date('Y'));

        // Compter le total des déclarations de naissance et de décès pour le mois sélectionné
        $naisshop = DeclarationNaissance::where('NomEnf', $communeAdmin)
            ->whereMonth('created_at', $selectedMonth)
            ->where('doctor_id', $sousAdminId)
            ->whereYear('created_at', $selectedYear)
            ->count();

        $deceshop = DeclarationDeces::where('nomHop', $communeAdmin)
            ->whereMonth('created_at', $selectedMonth)
            ->where('doctor_id', $sousAdminId)
            ->whereYear('created_at', $selectedYear)
            ->count();

        // Récupérer les données pour les graphiques (Naissances)
        $naissData = DeclarationNaissance::where('NomEnf', $communeAdmin)
            ->where('doctor_id', $sousAdminId)
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
            ->where('doctor_id', $sousAdminId)
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
            $pdf = PDF::loadView('doctor.stat.pdf', compact('naisshop', 'deceshop', 'total', 'selectedMonth', 'selectedYear', 'naissData', 'decesData'));
            return $pdf->download('statistiques_doctor.pdf');
        }

        return view('doctor.stat.index', compact('naisshop', 'deceshop', 'total', 'selectedMonth', 'selectedYear', 'naissData', 'decesData'));
    }

    public function download(Request $request)
    {
        Carbon::setLocale('fr');
        $sousadmin = Auth::guard('doctor')->user();
        $hopitalName = $sousadmin->nomHop;
        $sousAdminId = $sousadmin->id;

        // Récupérer le mois et l'année sélectionnés
        $selectedMonth = $request->input('month', date('m'));
        $selectedYear = $request->input('year', date('Y'));

        // Compter les naissances et décès
        $naisshopCount = DeclarationNaissance::where('doctor_id', $sousAdminId)->count();
        $deceshopCount = DeclarationDeces::where('doctor_id', $sousAdminId)->count();

        // Récupérer les données par mois pour les naissances
        $naissData = DeclarationNaissance::where('doctor_id', $sousAdminId)
            ->where('doctor_id', $sousAdminId)
            ->whereYear('created_at', $selectedYear)
            ->selectRaw('MONTH(created_at) as month, COUNT(*) as count')
            ->groupBy('month')
            ->orderBy('month')
            ->pluck('count', 'month')
            ->toArray();

        // Récupérer les données par mois pour les décès
        $decesData = DeclarationDeces::where('doctor_id', $sousAdminId)
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
        $pdf = PDF::loadView('doctor.stat.pdf', $data);

        // Retourner le PDF en téléchargement
        return $pdf->download('statistiques_doctor.pdf');
    }

    public function signature()
    {
        $sousAdmin = Auth::guard('doctor')->user();
        return view('doctor.stat.signature', compact('sousAdmin'));
    }

    public function updateSignature(Request $request) 
    {
        $sousAdmin = Auth::guard('doctor')->user();

        if ($request->hasFile('signature')) {
            // Valider et stocker la nouvelle signature
            $path = $request->file('signature')->store('signatures', 'public');

            // Supprimer l'ancienne signature si elle existe
            if ($sousAdmin->signature && Storage::disk('public')->exists($sousAdmin->signature)) {
                Storage::disk('public')->delete($sousAdmin->signature);
            }

            $sousAdmin->signature = $path;
        }

        $sousAdmin->update();
        return redirect()->route('doctor.signature')->with('success', 'Signature mise à jour avec succès.');
    }
}
