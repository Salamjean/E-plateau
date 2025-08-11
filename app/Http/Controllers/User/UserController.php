<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\DecesCertificat;
use App\Models\DecesSimple;
use App\Models\Mariage;
use App\Models\NaissanceCertificat;
use App\Models\NaissanceSimple;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function dashboard(){
        if (Auth::check()) {
            $user = Auth::user();

            // Récupérer les demandes avec leurs types respectifs
            $naissances = NaissanceCertificat::where('user_id', $user->id)->get()->map(function ($naissance) {
                $naissance->type = 'naissance';
                return $naissance;
            });

            $naissancesD = NaissanceSimple::where('user_id', $user->id)->get()->map(function ($naissanceD) {
                $naissanceD->display_type = 'naissanceD';
                return $naissanceD;
            });

            $deces = DecesCertificat::where('user_id', $user->id)->get()->map(function ($deces) {
                $deces->type = 'deces';
                return $deces;
            });

            $decesdeja = DecesSimple::where('user_id', $user->id)->get()->map(function ($decesdeja) {
                $decesdeja->type = 'deces';
                return $decesdeja;
            });

            $mariages = Mariage::where('user_id', $user->id)->get()->map(function ($mariage) {
                $mariage->type = 'mariage';
                return $mariage;
            });

            // Combiner toutes les demandes
            $demandes = $naissances->concat($naissancesD)->concat($deces)->concat($mariages)->concat($decesdeja);

            // Trier les demandes par date de création (les plus récentes en premier)
            $demandesRecente = $demandes->sortByDesc('created_at')->take(5);;

            // Calcul des totaux pour les groupes fusionnés
            $naissancesCount = NaissanceCertificat::where('user_id', $user->id)->count();
            $naissanceDCount = NaissanceSimple::where('user_id', $user->id)->count();
            $decesCount = DecesCertificat::where('user_id', $user->id)->count();
            $decesdejaCount = DecesSimple::where('user_id', $user->id)->count();
            $mariageCount = Mariage::where('user_id', $user->id)->count();
    
            // Calcul des totaux fusionnés
            $totalNaissances = $naissancesCount + $naissanceDCount;
            $totalDeces = $decesCount + $decesdejaCount;

            // Compter le nombre total de demandes
            $nombreDemandes = $demandes->count();

             // Ajoutez ces nouvelles méthodes pour obtenir les données mensuelles
            $naissancesMonthly = $this->getMonthlyCount(NaissanceCertificat::class, $user->id);
            $naissanceDMonthly = $this->getMonthlyCount(NaissanceSimple::class, $user->id);
            $decesMonthly = $this->getMonthlyCount(DecesCertificat::class, $user->id);
            $decesdejaMonthly = $this->getMonthlyCount(DecesSimple::class, $user->id);
            $mariageMonthly = $this->getMonthlyCount(Mariage::class, $user->id);

            // Combinez les données similaires
            $totalNaissancesMonthly = array_map(function ($n, $nd) {
                return $n + $nd;
            }, $naissancesMonthly, $naissanceDMonthly);

            $totalDecesMonthly = array_map(function ($d, $dd) {
                return $d + $dd;
            }, $decesMonthly, $decesdejaMonthly);


            // Passer les demandes récentes à la vue
            return view('user.dashboard', compact(
                'user',
                'demandesRecente',
                'nombreDemandes', 
                'naissancesD',
                'naissancesCount',
                'naissanceDCount',
                'decesCount',
                'decesdejaCount',
                'mariageCount',
                'totalNaissances',
                'totalDeces',
                'totalNaissancesMonthly',
                'totalDecesMonthly',
                'mariageMonthly'
            ));
        }
    }

    private function getMonthlyCount($model, $userId)
    {
        $currentYear = now()->year;
        $monthlyData = array_fill(0, 12, 0); // Initialise un tableau pour 12 mois (0-11)

        $records = $model::where('user_id', $userId)
            ->whereYear('created_at', $currentYear)
            ->selectRaw('MONTH(created_at) as month, COUNT(*) as count')
            ->groupBy('month')
            ->get();

        foreach ($records as $record) {
            $monthlyData[$record->month - 1] = $record->count; // -1 car les mois vont de 1-12
        }

        return $monthlyData;
    }

    public function logout(){
        Auth::guard('web')->logout();
        return redirect()->route('login');
    }
}
