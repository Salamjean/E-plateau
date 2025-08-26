<?php

namespace App\Http\Controllers\Caisse\Timbre;

use App\Http\Controllers\Controller;
use App\Models\Finance;
use App\Models\Timbre;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PDF;

class CaisseTimbreController extends Controller
{
    public function recharge(){
        Carbon::setLocale('fr');
        $solde_timbres = Timbre::sum('nombre_timbre');
        $dernieres_recharges = Timbre::where('finance_id', null)
                                    ->orderBy('created_at', 'desc')
                                    ->take(3)
                                    ->get();
        
        return view('caisse.timbre.recharge', compact('solde_timbres', 'dernieres_recharges'));
    } 

    public function store(Request $request)
    {
        $request->validate([
            'nombre_timbre' => 'required|numeric|min:0.01|max:999999.99'
        ]);

        try {
            DB::beginTransaction();

            // Créer un NOUVEL enregistrement pour chaque recharge (historique)
            $timbre = Timbre::create([
                'nombre_timbre' => $request->nombre_timbre,
                'finance_id' => null // ou l'ID de finance approprié
            ]);

            DB::commit();

            return redirect()->route('caisse.timbre.recharge')
                ->with('success', number_format($request->nombre_timbre, 2) . ' timbres ajoutés avec succès!');

        } catch (\Exception $e) {
            DB::rollBack();
            
            return redirect()->route('caisse.timbre.recharge')
                ->withInput()
                ->with('error', 'Erreur lors de l\'ajout: ' . $e->getMessage());
        }
    }

    public function history(){
        // Récupérer tout l'historique avec les relations et trié par date
        $historique = Timbre::with([
                'finance:id,name,prenom'
            ])
            ->orderBy('created_at', 'desc')
            ->paginate(20);
        
        // Calculer les totaux
        $total_recharges = Timbre::where('nombre_timbre', '>', 0)->sum('nombre_timbre');
        $total_ventes = abs(Timbre::where('nombre_timbre', '<', 0)->sum('nombre_timbre'));
        $solde_actuel = Timbre::sum('nombre_timbre');
        
        return view('caisse.timbre.history', compact(
            'historique', 
            'total_recharges', 
            'total_ventes', 
            'solde_actuel'
        ));
    }
    public function vente(Request $request)
    {
        $query = Timbre::with(['finance:id,name,prenom'])
                    ->where('nombre_timbre', '<', 0);
        
        // Filtre par date
        if ($request->has('date_debut') && $request->date_debut) {
            $query->whereDate('created_at', '>=', $request->date_debut);
        }
        
        if ($request->has('date_fin') && $request->date_fin) {
            $query->whereDate('created_at', '<=', $request->date_fin);
        }
        
        // Filtre par financier
        if ($request->has('financier_id') && $request->financier_id) {
            $query->where('finance_id', $request->financier_id);
        }
        
        $ventes = $query->orderBy('created_at', 'desc')->paginate(10);
        
        // Récupérer la liste des financiers pour le select
        $financiers = Finance::whereHas('timbres', function($q) {
            $q->where('nombre_timbre', '<', 0);
        })->orderBy('name')->get(['id', 'name', 'prenom']);

        $total_ventes = abs($query->sum('nombre_timbre'));

        // Calcul des statistiques
        $stats = [
            'today' => abs(Timbre::where('nombre_timbre', '<', 0)
                        ->whereDate('created_at', today())
                        ->sum('nombre_timbre')),
            
            'this_week' => abs(Timbre::where('nombre_timbre', '<', 0)
                        ->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()])
                        ->sum('nombre_timbre')),
            
            'this_month' => abs(Timbre::where('nombre_timbre', '<', 0)
                        ->whereBetween('created_at', [now()->startOfMonth(), now()->endOfMonth()])
                        ->sum('nombre_timbre'))
        ];
        
        return view('caisse.timbre.vente', compact('ventes', 'total_ventes', 'stats', 'financiers'));
    }

    public function statistiques()
    {
        // Prix fixe du timbre (500 FCFA)
        $timbrePrice = 500;

        // Statistiques du mois en cours
        $currentMonth = now()->format('Y-m');
        $currentMonthStats = Timbre::select(DB::raw('SUM(nombre_timbre) as count'))
            ->where('nombre_timbre', '<', 0)
            ->whereYear('created_at', now()->year)
            ->whereMonth('created_at', now()->month)
            ->first();

        // Rendre la valeur positive
        $currentMonthStats->count = abs($currentMonthStats->count);

        // Statistiques mensuelles pour l'année en cours
        $monthlyStats = Timbre::select(
                DB::raw('YEAR(created_at) as year'),
                DB::raw('MONTH(created_at) as month'),
                DB::raw('SUM(nombre_timbre) as total')
            )
            ->where('nombre_timbre', '<', 0)
            ->whereYear('created_at', now()->year)
            ->groupBy('year', 'month')
            ->orderBy('year', 'desc')
            ->orderBy('month', 'desc')
            ->get();

        // Transformer chaque total en positif
        $monthlyStats->transform(function ($item) {
            $item->total = abs($item->total);
            return $item;
        });
        
        return view('caisse.timbre.statistiques', compact(
            'timbrePrice',
            'currentMonthStats',
            'monthlyStats'
        ));
    }

   public function generatePDF(Request $request)
    {
        $month = $request->get('month', date('Y-m'));
        list($year, $monthNum) = explode('-', $month);
        
        // Récupérer les statistiques pour le mois sélectionné (identique à votre méthode statistiques)
        $stats = Timbre::select(DB::raw('SUM(nombre_timbre) as count'))
            ->where('nombre_timbre', '<', 0)
            ->whereYear('created_at', $year)
            ->whereMonth('created_at', $monthNum)
            ->first();
        
        // Rendre la valeur positive et gérer le cas où il n'y a pas de données
        $stampCount = $stats && $stats->count ? abs($stats->count) : 0;
        
        $timbrePrice = 500; 
        $totalAmount = $stampCount * $timbrePrice;
        
        $months = [
            '01' => 'Janvier', '02' => 'Février', '03' => 'Mars', 
            '04' => 'Avril', '05' => 'Mai', '06' => 'Juin',
            '07' => 'Juillet', '08' => 'Août', '09' => 'Septembre',
            '10' => 'Octobre', '11' => 'Novembre', '12' => 'Décembre'
        ];
        
        $monthName = $months[$monthNum];
        
        $data = [
            'month' => $monthName . ' ' . $year,
            'stampCount' => $stampCount,
            'totalAmount' => $totalAmount,
            'timbrePrice' => $timbrePrice
        ];
        
        $pdf = PDF::loadView('caisse.timbre.pdf', $data);
        
        return $pdf->download('statistiques-timbres-' . $month . '.pdf');
    }
}
