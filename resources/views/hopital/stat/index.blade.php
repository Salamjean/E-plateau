@extends('hopital.layouts.template')

@section('content')
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Statistiques des Shops</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        :root {
            --primary: #009efb;
            --secondary: #009efb;
            --success: #4cc9f0;
            --warning: #f72585;
            --light: #f8f9fa;
            --dark: #212529;
            --card-shadow: 0 10px 20px rgba(0, 0, 0, 0.05);
            --hover-shadow: 0 15px 30px rgba(0, 0, 0, 0.1);
            --border-radius: 16px;
            --transition: all 0.3s ease;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f5f7fb;
            color: #009efb;
            padding-bottom: 2rem;
            width: 100%;
        }

        .stat-card {
            background: linear-gradient(135deg, #fff 0%, #f9fafc 100%);
            border-radius: var(--border-radius);
            box-shadow: var(--card-shadow);
            transition: var(--transition);
            border: none;
            overflow: hidden;
            height: 100%;
            text-decoration: none;
            color: inherit;
        }

        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: var(--hover-shadow);
            text-decoration: none;
            color: inherit;
        }

        .card-gradient-custom {
            background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%);
            color: white;
        }

        .stat-icon {
            font-size: 2.5rem;
            opacity: 0.8;
            transition: var(--transition);
        }

        .stat-card:hover .stat-icon {
            transform: scale(1.1);
            opacity: 1;
        }

        .progress {
            height: 14px;
            border-radius: 10px;
            background-color: #e9ecef;
            overflow: hidden;
        }

        .progress-bar {
            border-radius: 10px;
        }

        .chart-container {
            background: white;
            border-radius: var(--border-radius);
            box-shadow: var(--card-shadow);
            padding: 1.5rem;
            height: 100%;
        }

        .filter-container {
            background: white;
            border-radius: var(--border-radius);
            box-shadow: var(--card-shadow);
            padding: 1.5rem;
            margin-bottom: 2rem;
        }

        .btn-modern {
            background: linear-gradient(to right, var(--primary), var(--secondary));
            color: white;
            border: none;
            border-radius: 8px;
            padding: 0.5rem 1.5rem;
            transition: var(--transition);
        }

        .btn-modern:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 12px rgba(67, 97, 238, 0.3);
            color: white;
        }

        .btn-download {
            background: linear-gradient(to right, #f72585, #f72585);
            color: white;
            border: none;
            border-radius: 8px;
            padding: 0.5rem 1.5rem;
            transition: var(--transition);
        }

        .btn-download:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 12px rgba(247, 37, 133, 0.3);
            color: white;
        }

        .section-title {
            color: var(--primary);
            font-weight: 700;
            margin-bottom: 1.5rem;
            position: relative;
            padding-bottom: 0.5rem;
        }

        .section-title::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 50px;
            height: 3px;
            background: linear-gradient(to right, var(--primary), var(--success));
            border-radius: 3px;
        }

        .stat-value {
            font-size: 2rem;
            font-weight: 700;
            margin: 0.5rem 0;
        }

        .form-select {
            border-radius: 8px;
            border: 1px solid #e2e8f0;
            padding: 0.5rem 1rem;
            transition: var(--transition);
        }

        .form-select:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 0.25rem rgba(67, 97, 238, 0.15);
        }

        @media (max-width: 768px) {
            .stat-value {
                font-size: 1.5rem;
            }
            
            .stat-icon {
                font-size: 2rem;
            }
        }
    </style>
</head>
<body>
    <div class="container py-4">
        <div class="text-center mb-5">
            <h1 class="fw-bold mb-3" style="color: var(--primary);">Tableau de Bord Statistique</h1>
            <p class="lead">Visualisez et analysez les données des déclarations par shop</p>
        </div>

        <!-- Filtre de Mois -->
        <div class="filter-container">
            <form method="GET" action="{{ route('hopital.stat') }}">
                <div class="row g-3 align-items-center justify-content-center">
                    <div class="col-md-4">
                        <label for="month" class="form-label fw-semibold">Mois</label>
                        <select name="month" id="month" class="form-select">
                            @for ($m = 1; $m <= 12; $m++)
                                <option value="{{ $m }}" {{ $m == $selectedMonth ? 'selected' : '' }}>
                                    {{ \Carbon\Carbon::create()->month($m)->locale('fr')->translatedFormat('F') }}
                                </option>
                            @endfor
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label for="year" class="form-label fw-semibold">Année</label>
                        <select name="year" id="year" class="form-select">
                            @for ($y = date('Y'); $y >= date('Y') - 4; $y--)
                                <option value="{{ $y }}" {{ $y == $selectedYear ? 'selected' : '' }}>
                                    {{ $y }}
                                </option>
                            @endfor
                        </select>
                    </div>
                    <div class="col-md-4 d-flex align-items-end">
                        <button type="submit" class="btn btn-modern w-100">
                            <i class="fas fa-filter me-2"></i> Appliquer le filtre
                        </button>
                    </div>
                </div>
            </form>
        </div>

        {{-- Les cartes de statistiques --}}
        <div class="row g-4 mb-5">
            <div class="col-xl-3 col-md-6">
                <a href="#" class="stat-card">
                    <div class="card-body p-4">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="text-uppercase text-muted small fw-bold">Total Docteurs</h6>
                                <h2 class="stat-value text-primary">{{ $docteur }}</h2>
                                <p class="mb-0 text-muted">Pour la période sélectionnée</p>
                            </div>
                            <div class="bg-primary p-3 rounded-circle">
                                <i class="fas fa-stethoscope stat-icon text-white"></i>
                            </div>
                        </div>
                    </div>
                </a>
            </div>

            <div class="col-xl-3 col-md-6">
                <a href="#" class="stat-card">
                    <div class="card-body p-4">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="text-uppercase text-muted small fw-bold">Total Naissances</h6>
                                <h2 class="stat-value text-success">{{ $naisshop }}</h2>
                                <p class="mb-0 text-muted">Pour la période sélectionnée</p>
                            </div>
                            <div class="bg-success p-3 rounded-circle">
                                <i class="fas fa-baby stat-icon text-white"></i>
                            </div>
                        </div>
                    </div>
                </a>
            </div>

            <div class="col-xl-3 col-md-6">
                <a href="#" class="stat-card">
                    <div class="card-body p-4">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="text-uppercase text-muted small fw-bold">Total Décès</h6>
                                <h2 class="stat-value" style="color: #f72585">{{ $deceshop }}</h2>
                                <p class="mb-0 text-muted">Pour la période sélectionnée</p>
                            </div>
                            <div class="p-3 rounded-circle" style="background-color: #f72585">
                                <i class="fas fa-skull stat-icon text-white"></i>
                            </div>
                        </div>
                    </div>
                </a>
            </div>

            <div class="col-xl-3 col-md-6">
                <a href="#" class="stat-card">
                    <div class="card-body p-4">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="text-uppercase text-muted small fw-bold">Total Déclarations</h6>
                                <h2 class="stat-value text-info">{{ $total }}</h2>
                                <p class="mb-0 text-muted">Pour la période sélectionnée</p>
                            </div>
                            <div class="bg-info p-3 rounded-circle">
                                <i class="fas fa-briefcase-medical stat-icon text-white"></i>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
        </div>

        <!-- Boutons de téléchargement -->
        <div class="d-flex justify-content-center mb-5">
            <div class="text-center">
                <h4 class="section-title d-inline-block mx-auto">Exporter les statistiques</h4>
                <div class="d-flex flex-wrap justify-content-center gap-3">
                    <a href="{{ route('hopital.download.stat', ['month' => $selectedMonth, 'year' => $selectedYear]) }}" class="btn btn-download">
                        <i class="fas fa-file-pdf me-2"></i> Télécharger PDF
                    </a>
                </div>
            </div>
        </div>

        <!-- Statistiques de progression -->
        <div class="row mb-5">
            <div class="col-12">
                <div class="chart-container">
                    <h4 class="section-title">Répartition des déclarations</h4>
                    
                    <div class="mb-4">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <h5 class="mb-0 text-primary"><i class="fas fa-baby me-2"></i> Naissances</h5>
                            <span class="fw-bold">{{ $naisshop }} / {{ $total }} ({{ $total > 0 ? round(($naisshop / $total) * 100, 1) : 0 }}%)</span>
                        </div>
                        <div class="progress">
                            <div class="progress-bar bg-primary" role="progressbar" style="width: {{ $total > 0 ? ($naisshop / $total) * 100 : 0 }}%;" 
                                aria-valuenow="{{ $naisshop }}" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    </div>
                    
                    <div>
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <h5 class="mb-0" style="color:#f72585"><i class="fas fa-skull me-2"></i> Décès</h5>
                            <span class="fw-bold">{{ $deceshop }} / {{ $total }} ({{ $total > 0 ? round(($deceshop / $total) * 100, 1) : 0 }}%)</span>
                        </div>
                        <div class="progress">
                            <div class="progress-bar" role="progressbar" style="width: {{ $total > 0 ? ($deceshop / $total) * 100 : 0 }}%; background-color:#f72585" 
                                aria-valuenow="{{ $deceshop }}" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Les graphiques --}}
        <div class="row g-4">
            <div class="col-lg-6">
                <div class="chart-container">
                    <h4 class="section-title"><i class="fas fa-baby me-2"></i> Évolution des Naissances</h4>
                    <canvas id="lineChart1" height="150"></canvas>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="chart-container">
                    <h4 class="section-title"><i class="fas fa-skull me-2"></i> Évolution des Décès</h4>
                    <canvas id="lineChart2" height="150"></canvas>
                </div>
            </div>
        </div>
    </div>

    <script>
        const naissData = @json(array_values($naissData));
        const decesData = @json(array_values($decesData));

        // Labels pour les mois de l'année en français
        const allLabels = ['Jan', 'Fév', 'Mar', 'Avr', 'Mai', 'Jun', 'Jui', 'Aoû', 'Sep', 'Oct', 'Nov', 'Déc'];

        // Configurer le graphique des naissances
        const ctx1 = document.getElementById('lineChart1').getContext('2d');
        const lineChart1 = new Chart(ctx1, {
            type: 'line',
            data: {
                labels: allLabels,
                datasets: [{
                    label: 'Naissances',
                    data: naissData,
                    backgroundColor: 'rgba(67, 97, 238, 0.1)',
                    borderColor: 'rgba(67, 97, 238, 1)',
                    borderWidth: 3,
                    pointRadius: 5,
                    pointBackgroundColor: 'rgba(67, 97, 238, 1)',
                    pointBorderColor: '#fff',
                    pointHoverRadius: 7,
                    fill: true,
                    tension: 0.3
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
                            size: 14
                        },
                        padding: 10,
                        cornerRadius: 8
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            stepSize: 1
                        },
                        grid: {
                            drawBorder: false
                        }
                    },
                    x: {
                        grid: {
                            display: false
                        }
                    }
                }
            }
        });

        // Configurer le graphique des décès
        const ctx2 = document.getElementById('lineChart2').getContext('2d');
        const lineChart2 = new Chart(ctx2, {
            type: 'line',
            data: {
                labels: allLabels,
                datasets: [{
                    label: 'Décès',
                    data: decesData,
                    backgroundColor: 'rgba(247, 37, 133, 0.1)',
                    borderColor: 'rgba(247, 37, 133, 1)',
                    borderWidth: 3,
                    pointRadius: 5,
                    pointBackgroundColor: 'rgba(247, 37, 133, 1)',
                    pointBorderColor: '#fff',
                    pointHoverRadius: 7,
                    fill: true,
                    tension: 0.3
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
                            size: 14
                        },
                        padding: 10,
                        cornerRadius: 8
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            stepSize: 1
                        },
                        grid: {
                            drawBorder: false
                        }
                    },
                    x: {
                        grid: {
                            display: false
                        }
                    }
                }
            }
        });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
@endsection