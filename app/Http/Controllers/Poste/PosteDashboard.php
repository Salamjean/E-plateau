<?php

namespace App\Http\Controllers\Poste;

use App\Http\Controllers\Controller;
use App\Models\DecesCertificat;
use App\Models\DecesSimple;
use App\Models\Livreur;
use App\Models\Mariage;
use App\Models\NaissanceCertificat;
use App\Models\NaissanceSimple;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PosteDashboard extends Controller
{
    public function dashboard()
{
    Carbon::setLocale('fr');
    $poste = Auth::user();
    $startDate = Carbon::now()->subDays(7);
    
    $modelMap = [
        'NaissanceSimple'     => 'naissance_simple',
        'NaissanceCertificat' => 'naissance_certificat',
        'DecesSimple'         => 'deces_simple',
        'DecesCertificat'     => 'deces_certificat',
        'Mariage'             => 'mariage'
    ];
    
    $stats = [
        'total' => 0,
        'en_attente' => 0,
        'en_cours' => 0,
        'livre' => 0
    ];
    
    $counts = array_fill_keys(array_values($modelMap), 0);
    $soldeDisponible = 0; // Nouvelle variable pour le solde

    $activites = collect();
    $chartData = ['labels' => [], 'livre' => [], 'en_cours' => []];

    // Préparer les labels du graphique sur 7 jours
    for ($i = 6; $i >= 0; $i--) {
        $date = Carbon::now()->subDays($i);
        $chartData['labels'][] = $date->translatedFormat('l');
        $chartData['livre'][] = 0;
        $chartData['en_cours'][] = 0;
    }

    // Parcours des modèles
    foreach ($modelMap as $model => $key) {
        $class = "App\\Models\\$model";
        
        // Comptage sur les 7 derniers jours
        $counts[$key] = $class::where('livraison_id', $poste->id)
            ->where('created_at', '>=', $startDate)
            ->count();
        
        // Mise à jour des stats globales
        $stats['total'] += $counts[$key];
        $stats['en_attente'] += $class::where('livraison_id', $poste->id)
            ->where('statut_livraison', 'en attente')
            ->count();
        $stats['en_cours'] += $class::where('livraison_id', $poste->id)
            ->where('statut_livraison', 'en cours')
            ->count();
        $stats['livre'] += $class::where('livraison_id', $poste->id)
            ->where('statut_livraison', 'livré')
            ->count();
        
        // Calcul du solde disponible (somme des montants pour les livraisons livrées)
         $soldeDisponible += $class::where('livraison_id', $poste->id)
            ->where('statut_livraison', 'livré')
            ->get()
            ->sum(function($item) {
                return max(0, $item->montant_livraison - 500); // Retire 500 et assure que le résultat n'est pas négatif
            });
            
        // Activités récentes
        $activites = $activites->merge(
            $class::where('livraison_id', $poste->id)
                ->with('user')
                ->latest()
                ->take(5)
                ->get()
                ->map(function($item) use ($model) {
                    $item->type = $model;
                    return $item;
                })
        );
        
        // Données graphiques par jour
        foreach ($chartData['labels'] as $index => $label) {
            $date = Carbon::now()->subDays(6 - $index);
            
            $chartData['livre'][$index] += $class::where('livraison_id', $poste->id)
                ->where('statut_livraison', 'livré')
                ->whereDate('updated_at', $date)
                ->count();
                
            $chartData['en_cours'][$index] += $class::where('livraison_id', $poste->id)
                ->where('statut_livraison', 'en cours')
                ->whereDate('updated_at', $date)
                ->count();
        }
    }
    
    // Trier les activités
    $activites = $activites->sortByDesc('created_at')->take(5);
    $livreurDispo = Livreur::where('disponible','1')->count();
    $livreurIndispo = Livreur::where('disponible','0')->count();
    $totalLivreur = $livreurDispo + $livreurIndispo;
    
    return view('poste.dashboard', [
        'stats' => $stats,
        'counts' => $counts,
        'livreurDispo' => $livreurDispo,
        'livreurIndispo' => $livreurIndispo,
        'totalLivreur' => $totalLivreur,
        'activites' => $activites,
        'chartData' => $chartData,
        'livreurs' => Livreur::active()->get(),
        'soldeDisponible' => $soldeDisponible // Ajout du solde à la vue
    ]);
}


    public function logout(){
        Auth::guard('poste')->logout();
        return redirect()->route('post.login');
    }



}
