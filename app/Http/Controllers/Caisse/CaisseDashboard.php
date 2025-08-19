<?php

namespace App\Http\Controllers\Caisse;

use App\Http\Controllers\Controller;
use App\Models\Caisse;
use App\Models\DecesCertificat;
use App\Models\DecesSimple;
use App\Models\Mairie;
use App\Models\Mariage;
use App\Models\NaissanceCertificat;
use App\Models\NaissanceSimple;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CaisseDashboard extends Controller
{
    public function dashboard()
    {
        // Récupérer l'utilisateur connecté
        $admin = Auth::guard('caisse')->user();

        // Récupérer les caisses de la commune de l'utilisateur
        $caisses = Caisse::where('communeM', $admin->communeM)->paginate(10);

        // Date du mois en cours
        $currentMonthStart = Carbon::now()->startOfMonth();
        $currentMonthEnd = Carbon::now()->endOfMonth();

        // Compter les demandes par type pour la commune de l'utilisateur (total)
        $decesnombre = DecesCertificat::where('commune', $admin->communeM)->count();
        $decesdejanombre = DecesSimple::where('commune', $admin->communeM)->count();
        $mariagenombre = Mariage::where('commune', $admin->communeM)->count();
        $naissancenombre = NaissanceCertificat::where('commune', $admin->communeM)->count();
        $naissanceDnombre = NaissanceSimple::where('commune', $admin->communeM)->count();
        $total = $decesnombre + $decesdejanombre + $naissancenombre + $naissanceDnombre + $mariagenombre;

        // Statistiques du mois en cours
        $decesMois = DecesCertificat::where('commune', $admin->communeM)
            ->whereBetween('created_at', [$currentMonthStart, $currentMonthEnd])
            ->count();
        $decesdejaMois = DecesSimple::where('commune', $admin->communeM)
            ->whereBetween('created_at', [$currentMonthStart, $currentMonthEnd])
            ->count();
        $mariageMois = Mariage::where('commune', $admin->communeM)
            ->whereBetween('created_at', [$currentMonthStart, $currentMonthEnd])
            ->count();
        $naissanceMois = NaissanceCertificat::where('commune', $admin->communeM)
            ->whereBetween('created_at', [$currentMonthStart, $currentMonthEnd])
            ->count();
        $naissanceDMois = NaissanceSimple::where('commune', $admin->communeM)
            ->whereBetween('created_at', [$currentMonthStart, $currentMonthEnd])
            ->count();
        $totalMois = $decesMois + $decesdejaMois + $naissanceMois + $naissanceDMois + $mariageMois;

        // Récupérer le solde total des mairies de la commune de l'utilisateur
        $soldeCommune = Mairie::where('name', $admin->communeM)
            ->whereNull('archived_at')
            ->sum('solde');

        // Solde initial (solde total de la commune)
        $soldeActuel = $soldeCommune;

        // Déduction pour chaque nouvelle demande
        $debit = 500; // Montant à déduire pour chaque demande
        $soldeDebite = $total * $debit; // Total débité basé sur le nombre de demandes
        $soldeRestant = $soldeActuel - $soldeDebite; // Calcul du solde restant

        // Récupérer les demandes récentes
        $demandesNaissance1 = NaissanceCertificat::where('commune', $admin->communeM)->latest()->take(3)->get();
        $demandesNaissanceD = NaissanceSimple::where('commune', $admin->communeM)->latest()->take(2)->get();
        $demandesNaissance = $demandesNaissance1->concat($demandesNaissanceD);
        $demandesDeces1 = DecesCertificat::where('commune', $admin->communeM)->latest()->take(5)->get();
        $demandesDecesdeja = DecesSimple::where('commune', $admin->communeM)->latest()->take(5)->get();
        $demandesDeces = $demandesDeces1->concat($demandesDecesdeja);
        $demandesMariage = Mariage::where('commune', $admin->communeM)->latest()->take(5)->get();

        // Récupérer les statistiques par période pour le graphique
        $now = Carbon::now();
        
        // Données pour les 7 derniers jours (combinez Naissance + NaissanceD et Deces + Decesdeja)
        $weeklyData = [
            'naissances' => $this->combineStats(
                $this->getWeeklyStats(NaissanceCertificat::class, $admin->communeM),
                $this->getWeeklyStats(NaissanceSimple::class, $admin->communeM)
            ),
            'deces' => $this->combineStats(
                $this->getWeeklyStats(DecesCertificat::class, $admin->communeM),
                $this->getWeeklyStats(DecesSimple::class, $admin->communeM)
            ),
            'mariages' => $this->getWeeklyStats(Mariage::class, $admin->communeM)
        ];

        // Données pour les 30 derniers jours
        $monthlyData = [
            'naissances' => $this->combineStats(
                $this->getMonthlyStats(NaissanceCertificat::class, $admin->communeM),
                $this->getMonthlyStats(NaissanceSimple::class, $admin->communeM)
            ),
            'deces' => $this->combineStats(
                $this->getMonthlyStats(DecesCertificat::class, $admin->communeM),
                $this->getMonthlyStats(DecesSimple::class, $admin->communeM)
            ),
            'mariages' => $this->getMonthlyStats(Mariage::class, $admin->communeM)
        ];

        // Données pour les 12 derniers mois
        $yearlyData = [
            'naissances' => $this->combineStats(
                $this->getYearlyStats(NaissanceCertificat::class, $admin->communeM),
                $this->getYearlyStats(NaissanceSimple::class, $admin->communeM)
            ),
            'deces' => $this->combineStats(
                $this->getYearlyStats(DecesCertificat::class, $admin->communeM),
                $this->getYearlyStats(DecesSimple::class, $admin->communeM)
            ),
            'mariages' => $this->getYearlyStats(Mariage::class, $admin->communeM)
        ];

        $debit = 500; // Montant à déduire pour chaque demande
        $montantMois = $totalMois * $debit;

        return view('caisse.dashboard', 
            compact(
                'total', 'soldeActuel', 'soldeDebite', 'soldeRestant',
                'decesnombre', 'decesdejanombre', 'naissancenombre', 'naissanceDnombre', 'mariagenombre',
                'demandesNaissance', 'demandesDeces', 'demandesMariage', 'soldeCommune',
                'weeklyData', 'monthlyData', 'yearlyData',
                'decesMois', 'decesdejaMois', 'mariageMois', 'naissanceMois', 'naissanceDMois', 'totalMois','montantMois'
            ));
    }
    private function combineStats(array $stats1, array $stats2)
    {
        $combined = [];
        foreach ($stats1 as $key => $value) {
            $combined[$key] = $value + ($stats2[$key] ?? 0);
        }
        return $combined;
    }

    // Méthodes helper pour récupérer les statistiques
    private function getWeeklyStats($model, $commune)
    {
        $data = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::now()->subDays($i);
            $count = $model::where('commune', $commune)
                ->whereDate('created_at', $date->toDateString())
                ->count();
            $data[] = $count;
        }
        return $data;
    }

    private function getMonthlyStats($model, $commune)
    {
        $data = [];
        for ($i = 29; $i >= 0; $i--) {
            $date = Carbon::now()->subDays($i);
            $count = $model::where('commune', $commune)
                ->whereDate('created_at', $date->toDateString())
                ->count();
            $data[] = $count;
        }
        return $data;
    }

    private function getYearlyStats($model, $commune)
    {
        $data = [];
        for ($i = 11; $i >= 0; $i--) {
            $start = Carbon::now()->subMonths($i)->startOfMonth();
            $end = Carbon::now()->subMonths($i)->endOfMonth();
            
            $count = $model::where('commune', $commune)
                ->whereBetween('created_at', [$start, $end])
                ->count();
            $data[] = $count;
        }
        return $data;
    }

    public function logout(){
        Auth::guard('caisse')->logout();
        return redirect()->route('caisse.login');
    }

}
