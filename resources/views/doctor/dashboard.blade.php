@extends('doctor.layouts.template')

@section('content')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels"></script>
<style>
    .card-gradient-custom {
        background: linear-gradient(to right, #4facfe, #00f2fe);
        border-radius: 10px;
        color: white;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        padding: 10px;
        margin: 15px 0;
    }

    .ms-icon-mr {
        font-size: 2rem;
    }

    .ms-content-wrapper {
        padding: 20px;
        font-family: Arial, sans-serif;
    }

    .ms-panel {
        border: 1px solid #ddd;
        border-radius: 10px;
        background: #fff;
        margin: 15px 0;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }

    .ms-panel-header {
        padding: 10px;
        background: #f7f7f7;
        font-weight: bold;
        border-bottom: 1px solid #ddd;
        text-align: center;
    }

    .ms-panel-body {
        padding: 10px;
        overflow-x: auto;
        display: flex;
        flex-wrap: wrap;
    }

    .declaration-item {
        display: flex;
        justify-content: center;
        min-width: 150px;
        margin-left: 40px;
    }

    .border {
        border: 1px solid #ddd;
        border-radius: 5px;
        padding: 10px;
    }

    .graph-container {
        width: 80%;
        margin: 0 auto; 
        gap: 20px;
    }
</style>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<div class="ms-content-wrapper">
    {{-- Les cartes de statistiques --}}
<div class="ms-content-wrapper">
    <div class="row" style="justify-content: center">
        <div class="col-xl-3 col-md-6 col-sm-6">
            <a href="#">
                <div class="ms-card card-gradient-custom ms-widget ms-infographics-widget ms-p-relative">
                    <div class="ms-card-body media">
                        <div class="media-body">
                            <h6>Naissance/Jour</h6>
                            <p class="ms-card-change text-center">{{ $naisshop }}</p>
                        </div>
                    </div>
                    <i class="fas fa-user ms-icon-mr"></i>
                </div>
            </a>
        </div>
        <div class="col-xl-3 col-md-6 col-sm-6">
            <a href="#">
                <div class="ms-card card-gradient-custom ms-widget ms-infographics-widget ms-p-relative">
                    <div class="ms-card-body media">
                        <div class="media-body">
                            <h6>Décès/Jour</h6>
                            <p class="ms-card-change text-center">{{ $deceshop }}</p>
                        </div>
                    </div>
                    <i class="fa fa-school ms-icon-mr"></i>
                </div>
            </a>
        </div>
        <div class="col-xl-3 col-md-6 col-sm-6">
            <a href="#">
                <div class="ms-card card-gradient-custom ms-widget ms-infographics-widget ms-p-relative">
                    <div class="ms-card-body media">
                        <div class="media-body">
                            <h6>Déclaration/jour</h6>
                            <p class="ms-card-change text-center">{{ $total }}</p>
                        </div>
                    </div>
                    <i class="fas fa-briefcase-medical ms-icon-mr"></i>
                </div>
            </a>
        </div>
    </div>
</div>
    <!-- Les déclarations récentes -->
    <div class="row">
        <div class="col-xl-6 col-md-12 mb-4">
            <div class="ms-panel">
                <div class="ms-panel-header">
                    Déclaration de naissance récentes
                </div>
                <div class="ms-panel-body" id="declarations-container">
                    @if($declarationsRecents->isEmpty())
                        <p>Aucune déclaration récente.</p>
                    @else
                        @foreach($declarationsRecents as $declaration)
                            <div class="declaration-item">
                                <div class="border">
                                    <p><strong>Date:</strong> {{ $declaration->created_at->format('d/m/Y') }}</p>
                                    <p><strong>Heure:</strong> {{ $declaration->created_at->format('H:i:s') }}</p>
                                    <p><strong>Nom-mère:</strong> {{ $declaration->NomM }}</p>
                                    <p><strong>Commune:</strong> {{ $declaration->commune }}</p>
                                </div>
                            </div>
                        @endforeach
                    @endif
                </div>
            </div>
        </div>

        <div class="col-xl-6 col-md-12 mb-4">
            <div class="ms-panel">
                <div class="ms-panel-header">
                    Déclaration de décès récentes
                </div>
                <div class="ms-panel-body" id="deces-container">
                    @if($decesRecents->isEmpty())
                        <p>Aucune déclaration récente.</p>
                    @else
                        @foreach($decesRecents as $deces)
                            <div class="declaration-item">
                                <div class="border">
                                    <p><strong>Date:</strong> {{ $deces->created_at->format('d/m/Y') }}</p>
                                    <p><strong>Heure:</strong> {{ $deces->created_at->format('H:i:s') }}</p>
                                    <p><strong>Nom-défunt:</strong> {{ $deces->NomM }}</p>
                                    <p><strong>Commune:</strong> {{ $deces->commune }}</p>
                                </div>
                            </div>
                        @endforeach
                    @endif
                </div>
            </div>
        </div>
    </div>

      <!-- Graphiques -->
  <div class="row mt-4">
    <div class="col-lg-6">
        <div class="card shadow">
            <canvas id="naissChart"></canvas>
        </div>
    </div>
    <div class="col-lg-6">
        <div class="card shadow">
            <canvas id="decesChart"></canvas>
        </div>
    </div>
</div>
<script>
    const naissData = @json(array_values($naissData)); 
    const decesData = @json(array_values($decesData)); 
    const months = ['Jan', 'Fév', 'Mar', 'Avr', 'Mai', 'Juin', 'Juil', 'Août', 'Sep', 'Oct', 'Nov', 'Déc'];
    const naissCtx = document.getElementById('naissChart').getContext('2d');
    const decesCtx = document.getElementById('decesChart').getContext('2d');

    // Créer le graphique des naissances
    const naissChart = new Chart(naissCtx, {
        type: 'bar',
        data: {
            labels: months,
            datasets: [{
                label: 'Naissances',
                data: naissData,
                backgroundColor: 'rgba(75, 192, 192, 1)',
                borderColor: 'rgba(75, 192, 192, 1)',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true,
                    max: Math.max(...naissData), // Max égal au maximum de naissData
                    ticks: {
                        stepSize: 1 // Ajustez le stepSize pour que chaque carré représente une unité
                    },
                    title: {
                        display: true,
                        text: 'Nombre de Naissances'
                    }
                },
                x: {
                    title: {
                        display: true,
                        text: 'Mois'
                    }
                }
            },
            plugins: {
                datalabels: {
                    anchor: 'end',
                    align: 'end',
                    formatter: function(value) {
                        return Math.floor(value); // Affiche les valeurs en entiers
                    },
                    color: '#fff',
                }
            }
        }
    });

    // Créer le graphique des décès
    const decesChart = new Chart(decesCtx, {
        type: 'bar',
        data: {
            labels: months,
            datasets: [{
                label: 'Décès',
                data: decesData,
                backgroundColor: 'rgba(255, 99, 132, 1)',
                borderColor: 'rgba(255, 99, 132, 1)',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true,
                    max: Math.max(...decesData), // Max égal au maximum de decesData
                    ticks: {
                        stepSize: 1 // Ajustez le stepSize pour que chaque carré représente une unité
                    },
                    title: {
                        display: true,
                        text: 'Nombre de Décès'
                    }
                },
                x: {
                    title: {
                        display: true,
                        text: 'Mois'
                    }
                }
            },
            plugins: {
                datalabels: {
                    anchor: 'end',
                    align: 'end',
                    formatter: function(value) {
                        return Math.floor(value); // Affiche les valeurs en entiers
                    },
                    color: '#fff',
                }
            }
        }
    });
</script>
</div>
@endsection