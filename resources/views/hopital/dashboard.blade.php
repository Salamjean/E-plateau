@extends('hopital.layouts.template')

@section('content')
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Hôpital</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels"></script>
    <style>
        :root {
            --primary-color: #009efb;
            --primary-light: #e6f5ff;
            --card-shadow: 0 4px 20px rgba(0, 158, 251, 0.15);
            --hover-effect: 0 8px 25px rgba(0, 158, 251, 0.2);
            --border-radius: 12px;
        }
        
        body {
            background-color: #f8f9fa;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            color: #333;
        }
        
        .dashboard-card {
            background: white;
            border-radius: var(--border-radius);
            box-shadow: var(--card-shadow);
            transition: all 0.3s ease;
            border: none;
            overflow: hidden;
            height: 100%;
        }
        
        .dashboard-card:hover {
            transform: translateY(-5px);
            box-shadow: var(--hover-effect);
        }
        
        .stat-card {
            padding: 20px;
            position: relative;
        }
        
        .stat-card i {
            position: absolute;
            right: 20px;
            top: 20px;
            font-size: 2.5rem;
            color: var(--primary-light);
            z-index: 1;
        }
        
        .stat-card .media-body {
            position: relative;
            z-index: 2;
        }
        
        .stat-card h6 {
            color: #6c757d;
            font-size: 0.9rem;
            font-weight: 600;
            margin-bottom: 5px;
        }
        
        .stat-card .ms-card-change {
            color: var(--primary-color);
            font-size: 1.8rem;
            font-weight: 700;
            margin-bottom: 0;
        }
        
        .progress-container {
            background: white;
            border-radius: var(--border-radius);
            box-shadow: var(--card-shadow);
            padding: 20px;
            margin: 25px 0;
        }
        
        .progress {
            height: 12px;
            border-radius: 10px;
            background-color: #e9ecef;
            overflow: visible;
        }
        
        .progress-bar {
            border-radius: 10px;
            position: relative;
            overflow: visible;
        }
        
        .progress-bar::after {
            content: attr(aria-valuenow) "%";
            position: absolute;
            right: 10px;
            top: -25px;
            color: white;
            font-size: 12px;
            font-weight: bold;
            background: rgba(0, 0, 0, 0.7);
            padding: 3px 8px;
            border-radius: 4px;
        }
        
        .progress-bar.bg-primary::after {
            background: var(--primary-color);
        }
        
        .chart-container {
            background: white;
            border-radius: var(--border-radius);
            box-shadow: var(--card-shadow);
            padding: 20px;
            margin-bottom: 25px;
        }
        
        .chart-title {
            color: var(--primary-color);
            font-weight: 600;
            margin-bottom: 15px;
            font-size: 1.2rem;
        }
        
        .section-title {
            color: #495057;
            font-weight: 600;
            margin: 30px 0 20px;
            padding-bottom: 10px;
            border-bottom: 2px solid var(--primary-light);
        }
        
        .bg-primary {
            background-color: var(--primary-color) !important;
        }
        
        .ms-content-wrapper {
            padding: 20px;
        }
        
        @media (max-width: 768px) {
            .stat-card .ms-card-change {
                font-size: 1.5rem;
            }
            
            .stat-card i {
                font-size: 2rem;
            }
        }
    </style>
</head>
<body>
    <div class="ms-content-wrapper">
        <h2 class="section-title">Tableau de Bord</h2>
        
        <div class="row">
            <!-- Carte Docteur -->
            <div class="col-xl-3 col-md-6 col-sm-6 mb-4">
                <a href="#" class="text-decoration-none">
                    <div class="dashboard-card stat-card">
                        <div class="ms-card-body media">
                            <div class="media-body">
                                <h6>Total Docteur</h6>
                                <p class="ms-card-change">{{ $docteur }}</p>
                            </div>
                        </div>
                        <i class="fas fa-stethoscope"></i>
                    </div>
                </a>
            </div>

            <!-- Carte Naissance -->
            <div class="col-xl-3 col-md-6 col-sm-6 mb-4">
                <a href="#" class="text-decoration-none">
                    <div class="dashboard-card stat-card">
                        <div class="ms-card-body media">
                            <div class="media-body">
                                <h6>Total Naissance</h6>
                                <p class="ms-card-change">{{ $naisshop }}</p>
                            </div>
                        </div>
                        <i class="fas fa-user"></i>
                    </div>
                </a>
            </div>

            <!-- Carte Décès -->
            <div class="col-xl-3 col-md-6 col-sm-6 mb-4">
                <a href="#" class="text-decoration-none">
                    <div class="dashboard-card stat-card">
                        <div class="ms-card-body media">
                            <div class="media-body">
                                <h6 class="bold">Total Décès</h6>
                                <p class="ms-card-change">{{ $deceshop }}</p>
                            </div>
                        </div>
                        <i class="fa fa-church"></i>
                    </div>
                </a>
            </div>

            <!-- Carte Déclaration -->
            <div class="col-xl-3 col-md-6 col-sm-6 mb-4">
                <a href="#" class="text-decoration-none">
                    <div class="dashboard-card stat-card">
                        <div class="ms-card-body media">
                            <div class="media-body">
                                <h6 class="bold">Total Déclaration</h6>
                                <p class="ms-card-change">{{ $total }}</p>
                            </div>
                        </div>
                        <i class="fas fa-briefcase-medical"></i>
                    </div>
                </a>
            </div>
        </div>

        <!-- Barres de progression -->
        <div class="progress-container">
            <h4 class="chart-title">Répartition des déclarations</h4>
            <div class="progress">
                <div class="progress-bar bg-primary" role="progressbar" style="width: 45.07%" aria-valuenow="45.07" aria-valuemin="0" aria-valuemax="100"></div>
                <div class="progress-bar bg-danger" role="progressbar" style="width: 29.05%" aria-valuenow="29.05" aria-valuemin="0" aria-valuemax="100"></div>
                <div class="progress-bar bg-warning" role="progressbar" style="width: 25.48%" aria-valuenow="25.48" aria-valuemin="0" aria-valuemax="100"></div>
            </div>
        </div>

        <!-- Graphiques -->
        <div class="row">
            <div class="col-lg-6 mb-4">
                <div class="chart-container">
                    <h4 class="chart-title">Naissances par mois</h4>
                    <canvas id="naissChart"></canvas>
                </div>
            </div>
            <div class="col-lg-6 mb-4">
                <div class="chart-container">
                    <h4 class="chart-title">Décès par mois</h4>
                    <canvas id="decesChart"></canvas>
                </div>
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
                    backgroundColor: '#009efb',
                    borderColor: '#0085d4',
                    borderWidth: 1,
                    borderRadius: 5,
                    hoverBackgroundColor: '#0079c5'
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        backgroundColor: 'rgba(0, 0, 0, 0.7)',
                        titleFont: {
                            size: 14
                        },
                        bodyFont: {
                            size: 13
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: {
                            drawBorder: false
                        },
                        ticks: {
                            stepSize: 1
                        },
                        title: {
                            display: true,
                            text: 'Nombre de Naissances',
                            color: '#6c757d',
                            font: {
                                weight: 'normal'
                            }
                        }
                    },
                    x: {
                        grid: {
                            display: false
                        },
                        title: {
                            display: true,
                            text: 'Mois',
                            color: '#6c757d',
                            font: {
                                weight: 'normal'
                            }
                        }
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
                    backgroundColor: '#fd397a',
                    borderColor: '#ec1968',
                    borderWidth: 1,
                    borderRadius: 5,
                    hoverBackgroundColor: '#e3165c'
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        backgroundColor: 'rgba(0, 0, 0, 0.7)',
                        titleFont: {
                            size: 14
                        },
                        bodyFont: {
                            size: 13
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: {
                            drawBorder: false
                        },
                        ticks: {
                            stepSize: 1
                        },
                        title: {
                            display: true,
                            text: 'Nombre de Décès',
                            color: '#6c757d',
                            font: {
                                weight: 'normal'
                            }
                        }
                    },
                    x: {
                        grid: {
                            display: false
                        },
                        title: {
                            display: true,
                            text: 'Mois',
                            color: '#6c757d',
                            font: {
                                weight: 'normal'
                            }
                        }
                    }
                }
            }
        });
    </script>
</body>
</html>
@endsection