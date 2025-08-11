@extends('user.layouts.template')
@section('content')
<div class="midde_cont">
    <div class="container-fluid">
        <div class="row column_title">
            <div class="col-md-12">
                <div class="page_title">
                    <h2>Tableau de bord</h2>
                    <p>Bienvenue, {{ Auth::user()->name }} {{ Auth::user()->prenom }}!</p>
                </div>
            </div>
        </div>
        
        <!-- Cartes de statistiques -->
        <div class="row column1 social_media_section">
            <div class="col-md-6 col-lg-3">
                <div class="full socile_icons fb margin_bottom_30">
                    <div class="social_icon">
                        <i class="fa fa-child"></i>
                    </div>
                    <div class="social_cont">
                        <ul style="text-align: center">
                            <li>
                                <span><strong>Total d'extrait de naissance </strong></span>
                            </li>
                            <li>
                                <span><strong>{{ $naissancesCount + $naissanceDCount}}</strong></span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-3">
                <div class="full socile_icons tw margin_bottom_30">
                    <div class="social_icon">
                        <i class="fa fa-book"></i>
                    </div>
                    <div class="social_cont">
                        <ul>
                            <li>
                                <span><strong>Total d'extrait de mariage</strong></span>
                                <span></span>
                            </li>
                            <li>
                                <span><strong>{{ $mariageCount }}</strong></span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-3">
                <div class="full socile_icons linked margin_bottom_30">
                    <div class="social_icon">
                        <i class="fa fa-home"></i>
                    </div>
                    <div class="social_cont">
                        <ul>
                            <li>
                                <span><strong>Total d'extrait de décès</strong></span>
                            </li>
                            <li class="mt-2">
                                <span><strong>{{ $decesdejaCount + $decesCount }}</strong></span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-3">
                <div class="full socile_icons google_p margin_bottom_30">
                    <div class="social_icon">
                        <i class="fa fa-history"></i>
                    </div>
                    <div class="social_cont">
                        <ul>
                            <li>
                                <span><strong>{{ $nombreDemandes }}</strong></span>
                                <span>Total des demandes</span>
                            </li>
                            <li>
                              <span>Date actuelle</span>
                              <span><strong>{{ now()->format('d/m/Y') }}</strong></span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Graphique en courbe -->
        <div class="row column2 graph margin_top_50">
            <div class="col-md-6 col-lg-6">
                <div class="white_shd full">
                    <div class="full graph_head">
                        <div class="heading1 margin_0">
                            <h2>Évolution de vos demandes</h2>
                        </div>
                    </div>
                    <div class="full graph_revenue">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="content">
                                    <div class="area_chart">
                                        <canvas height="120" id="evolutionChart"></canvas>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="white_shd full margin_top_50">
                    <div class="full graph_head">
                        <div class="heading1 margin_0">
                            <h2>Répartition par type</h2>
                        </div>
                    </div>
                    <div class="full progress_bar_inner">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="progress_bar">
                                    <!-- Naissances -->
                                    <span class="skill">Naissances ({{ $totalNaissances }}) <span class="info_valume">{{ $nombreDemandes > 0 ? round(($totalNaissances/$nombreDemandes)*100) : 0 }}%</span></span>                  
                                    <div class="progress skill-bar">
                                        <div class="progress-bar progress-bar-animated progress-bar-striped bg-primary" role="progressbar" 
                                             aria-valuenow="{{ $nombreDemandes > 0 ? round(($totalNaissances/$nombreDemandes)*100) : 0 }}" 
                                             aria-valuemin="0" aria-valuemax="100" 
                                             style="width: {{ $nombreDemandes > 0 ? round(($totalNaissances/$nombreDemandes)*100) : 0 }}%;">
                                        </div>
                                    </div>
                                    
                                    <!-- Décès -->
                                    <span class="skill">Décès ({{ $totalDeces }}) <span class="info_valume">{{ $nombreDemandes > 0 ? round(($totalDeces/$nombreDemandes)*100) : 0 }}%</span></span>   
                                    <div class="progress skill-bar">
                                        <div class="progress-bar progress-bar-animated progress-bar-striped bg-danger" role="progressbar" 
                                             aria-valuenow="{{ $nombreDemandes > 0 ? round(($totalDeces/$nombreDemandes)*100) : 0 }}" 
                                             aria-valuemin="0" aria-valuemax="100" 
                                             style="width: {{ $nombreDemandes > 0 ? round(($totalDeces/$nombreDemandes)*100) : 0 }}%;">
                                        </div>
                                    </div>
                                    
                                    <!-- Mariages -->
                                    <span class="skill">Mariages ({{ $mariageCount }}) <span class="info_valume">{{ $nombreDemandes > 0 ? round(($mariageCount/$nombreDemandes)*100) : 0 }}%</span></span>
                                    <div class="progress skill-bar">
                                        <div class="progress-bar progress-bar-animated progress-bar-striped bg-success" role="progressbar" 
                                             aria-valuenow="{{ $nombreDemandes > 0 ? round(($mariageCount/$nombreDemandes)*100) : 0 }}" 
                                             aria-valuemin="0" aria-valuemax="100" 
                                             style="width: {{ $nombreDemandes > 0 ? round(($mariageCount/$nombreDemandes)*100) : 0 }}%;">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const labels = ['Jan', 'Fév', 'Mar', 'Avr', 'Mai', 'Juin', 'Juil', 'Août', 'Sep', 'Oct', 'Nov', 'Déc'];
        
        // Utilisez les données dynamiques du contrôleur
        const naissancesData = @json($totalNaissancesMonthly);
        const decesData = @json($totalDecesMonthly);
        const mariagesData = @json($mariageMonthly);
        
        const ctx = document.getElementById('evolutionChart').getContext('2d');
        const evolutionChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: labels,
                datasets: [
                    {
                        label: 'Naissances',
                        data: naissancesData,
                        borderColor: 'rgba(54, 162, 235, 1)',
                        backgroundColor: 'rgba(54, 162, 235, 0.1)',
                        borderWidth: 2,
                        tension: 0.3,
                        fill: true
                    },
                    {
                        label: 'Décès',
                        data: decesData,
                        borderColor: 'rgba(108, 117, 125, 1)',
                        backgroundColor: 'rgba(255, 0, 0, 0.2)',
                        borderWidth: 2,
                        tension: 0.3,
                        fill: true
                    },
                    {
                        label: 'Mariages',
                        data: mariagesData,
                        borderColor: 'rgba(40, 167, 69, 1)',
                        backgroundColor: 'rgba(40, 167, 69, 0.1)',
                        borderWidth: 2,
                        tension: 0.3,
                        fill: true
                    }
                ]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top',
                    },
                    tooltip: {
                        mode: 'index',
                        intersect: false,
                        callbacks: {
                            label: function(context) {
                                return context.dataset.label + ': ' + context.raw;
                            }
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            stepSize: 1,
                            precision: 0,
                            callback: function(value) {
                                if (value % 1 === 0) {
                                    return value;
                                }
                            }
                        }
                    }
                },
                interaction: {
                    mode: 'nearest',
                    axis: 'x',
                    intersect: false
                }
            }
        });
    });
</script>
@endsection