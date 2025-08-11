<?php

namespace App\Http\Controllers\Mairie;

use App\Http\Controllers\Controller;
use App\Models\DecesCertificat;
use App\Models\DecesSimple;
use App\Models\DeclarationDeces;
use App\Models\DeclarationNaissance;
use App\Models\Mariage;
use App\Models\NaissanceCertificat;
use App\Models\NaissanceSimple;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MairieController extends Controller
{
    public function dashboard(Request $request){
        Carbon::setLocale('fr');
        // Récupérer l'admin connecté
        $admin = Auth::guard('mairie')->user();

        // Récupérer le mois et l'année sélectionnés pour les naissances, décès et mariages
        $selectedMonth = $request->input('month', date('m'));
        $selectedYear = $request->input('year', date('Y'));

        // Récupérer le mois et l'année sélectionnés pour les naisshops et deceshops
        $selectedMonthHops = $request->input('month_hops', date('m'));
        $selectedYearHops = $request->input('year_hops', date('Y'));

        // Récupérer les données associées à la commune de cet admin pour le mois sélectionné
        // Données pour naissances, décès, et mariages
        $naissances = NaissanceCertificat::where('commune', $admin->name)
            ->whereMonth('created_at', $selectedMonth)
            ->whereYear('created_at', $selectedYear)
            ->orderBy('created_at', 'desc')
            ->get();

        $naissancesD = NaissanceSimple::where('commune', $admin->name)
            ->whereMonth('created_at', $selectedMonth)
            ->whereYear('created_at', $selectedYear)
            ->orderBy('created_at', 'desc')
            ->get();

        $deces = DecesCertificat::where('commune', $admin->name)
            ->whereMonth('created_at', $selectedMonth)
            ->whereYear('created_at', $selectedYear)
            ->orderBy('created_at', 'desc')
            ->get();
            
        $decesdeja = DecesSimple::where('commune', $admin->name)
            ->whereMonth('created_at', $selectedMonth)
            ->whereYear('created_at', $selectedYear)
            ->orderBy('created_at', 'desc')
            ->get();
        $mariages = Mariage::where('commune', $admin->name)
            ->whereMonth('created_at', $selectedMonth)
            ->whereYear('created_at', $selectedYear)
            ->orderBy('created_at', 'desc')
            ->get();

        // Données pour naisshops et deceshops
        $naisshops = DeclarationNaissance::where('commune', $admin->name)
            ->whereMonth('created_at', $selectedMonthHops)
            ->whereYear('created_at', $selectedYearHops)
            ->orderBy('created_at', 'desc')
            ->get();

        $deceshops = DeclarationDeces::where('commune', $admin->name)
            ->whereMonth('created_at', $selectedMonthHops)
            ->whereYear('created_at', $selectedYearHops)
            ->orderBy('created_at', 'desc')
            ->get();

        // Calcul des données globales
        $totalData = $naissances->count() + $naissancesD->count() + $decesdeja->count() + $deces->count() + $mariages->count();
        $totalDataHops = $naisshops->count() + $deceshops->count();

        // Pourcentages
        $naissancePercentage = $totalData > 0 ? ($naissances->count() / $totalData) * 100 : 0;
        $naissanceDPercentage = $totalData > 0 ? ($naissancesD->count() / $totalData) * 100 : 0;
        $decesPercentage = $totalData > 0 ? ($deces->count() / $totalData) * 100 : 0;
        $decesdejaPercentage = $totalData > 0 ? ($decesdeja->count() / $totalData) * 100 : 0;
        $mariagePercentage = $totalData > 0 ? ($mariages->count() / $totalData) * 100 : 0;
        $naisshopPercentage = $totalDataHops > 0 ? ($naisshops->count() / $totalDataHops) * 100 : 0;
        $deceshopPercentage = $totalDataHops > 0 ? ($deceshops->count() / $totalDataHops) * 100 : 0;

        $NaissP = $naissancePercentage + $naissanceDPercentage;    
        $DecesP = $decesPercentage + $decesdejaPercentage;    
        $NaissHop = $naisshopPercentage + $deceshopPercentage; 

        // Données pour le tableau de bord
        $naissancedash = $naissances->count();
        $decesdash = $deces->count();
        $decesdejadash = $decesdeja->count();
        $mariagedash = $mariages->count();
        $naissanceDdash = $naissancesD->count();
        $naisshopsdash = $naisshops->count();
        $deceshopsdash = $deceshops->count();
        $Naiss = $naissancedash + $naissanceDdash;
        $Dece = $decesdash + $decesdejadash;
        $NaissHopTotal = $naisshopsdash + $deceshopsdash;

        // Récupération des données récentes (3 derniers éléments)
        $recentNaissances = $naissances->take(2);
        $recentNaissancesd = $naissancesD->take(2);
        $recentDeces = $deces->take(2);
        $recentDecesdeja = $decesdeja->take(2);
        $recentMariages = $mariages->take(2);
        $recentNaisshops = $naisshops->take(2);
        $recentDeceshops = $deceshops->take(2);

        // Retourne la vue avec les données
        return view('mairie.dashboard', compact(
            'naissancedash', 'naisshopsdash', 'deceshopsdash','decesdejadash', 
            'NaissHopTotal', 'decesdash', 'NaissP','DecesP', 'mariagedash', 
            'naissances', 'naissancesD', 'deces','decesdeja', 'mariages', 
            'totalDataHops', 'totalData', 'naissancePercentage', 
            'naissanceDPercentage', 'decesPercentage', 'mariagePercentage', 
            'naisshopPercentage', 'deceshopPercentage', 
            'recentNaissances', 'recentDeces', 'recentMariages', 
            'Naiss','Dece','recentDecesdeja', 'NaissHop', 
            'selectedMonth', 'selectedYear', 
            'selectedMonthHops', 'selectedYearHops','recentNaisshops', 'recentDeceshops','recentNaissancesd','naissanceDdash'
        ));
    }

    public function logout(){
        Auth::guard('mairie')->logout();
        return redirect()->route('mairie.login');
    }
}
