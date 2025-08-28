@extends('caisse.layouts.template')
@section('content')
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/@mdi/font@7.2.96/css/materialdesignicons.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<style>
  :root {
    --primary: #4361ee;
    --primary-light: #eef2ff;
    --secondary: #3a0ca3;
    --success: #4cc9f0;
    --danger: #f72585;
    --warning: #f8961e;
    --info: #4895ef;
    --dark: #1a1a2e;
    --light: #f8f9fa;
    --gray: #6c757d;
    --border-radius: 12px;
    --box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
    --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
  }

  body {
    font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
    background-color: #f8fafc;
    color: #1e293b;
  }

  /* Header Card */
  .welcome-card {
    background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%);
    color: white;
    border-radius: var(--border-radius);
    padding: 2rem;
    margin-bottom: 2rem;
    box-shadow: var(--box-shadow);
    position: relative;
    overflow: hidden;
  }

  .welcome-card::before {
    content: "";
    position: absolute;
    top: -50px;
    right: -50px;
    width: 200px;
    height: 200px;
    background: rgba(255, 255, 255, 0.1);
    border-radius: 50%;
  }

  .welcome-card::after {
    content: "";
    position: absolute;
    bottom: -80px;
    right: -30px;
    width: 150px;
    height: 150px;
    background: rgba(255, 255, 255, 0.05);
    border-radius: 50%;
  }

  .welcome-card h2 {
    font-weight: 700;
    margin-bottom: 0.5rem;
  }

  .welcome-card p {
    opacity: 0.9;
    margin-bottom: 0;
  }

  .welcome-icon {
    font-size: 3rem;
    opacity: 0.2;
    position: absolute;
    right: 30px;
    top: 50%;
    transform: translateY(-50%);
  }

  /* Stat Cards */
  .stat-card {
    border: none;
    border-radius: var(--border-radius);
    box-shadow: var(--box-shadow);
    transition: var(--transition);
    height: 100%;
    overflow: hidden;
    position: relative;
    background: white;
  }

  .stat-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1);
  }

  .stat-card .card-body {
    padding: 1.5rem;
    position: relative;
    z-index: 2;
  }

  .stat-card .icon-container {
    width: 60px;
    height: 60px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-bottom: 1rem;
    font-size: 1.75rem;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
  }

  .stat-card .icon-primary {
    background-color: var(--primary-light);
    color: var(--primary);
  }

  .stat-card .icon-success {
    background-color: rgba(76, 201, 240, 0.1);
    color: var(--success);
  }

  .stat-card .icon-danger {
    background-color: rgba(247, 37, 133, 0.1);
    color: var(--danger);
  }

  .stat-card .icon-warning {
    background-color: rgba(248, 150, 30, 0.1);
    color: var(--warning);
  }

  .stat-card .stat-value {
    font-size: 1.75rem;
    font-weight: 700;
    margin-bottom: 0.25rem;
    color: var(--dark);
  }

  .stat-card .stat-label {
    font-size: 0.875rem;
    color: var(--gray);
    text-transform: uppercase;
    letter-spacing: 0.5px;
    font-weight: 600;
    margin-bottom: 0.5rem;
  }

  .stat-card .stat-description {
    font-size: 0.8rem;
    color: var(--gray);
    opacity: 0.8;
  }

  /* Chart Card */
  .chart-card {
    border: none;
    border-radius: var(--border-radius);
    box-shadow: var(--box-shadow);
    margin-bottom: 2rem;
    background: white;
  }

  .chart-card .card-header {
    background-color: white;
    color: var(--dark);
    border-bottom: 1px solid rgba(0, 0, 0, 0.05);
    padding: 1.25rem 1.5rem;
    font-weight: 600;
    display: flex;
    align-items: center;
    justify-content: space-between;
    border-radius: var(--border-radius) var(--border-radius) 0 0 !important;
  }

  .chart-card .card-header i {
    font-size: 1.25rem;
    margin-right: 0.5rem;
    color: var(--primary);
  }

  .chart-container {
    position: relative;
    height: 405px;
    padding: 1rem;
  }

  .chart-container1 {
    position: relative;
    height: 465px;
    padding: 1rem;
  }

  /* Filter buttons */
  .filter-buttons {
    display: flex;
    gap: 0.5rem;
    margin-bottom: 1rem;
  }

  .filter-btn {
    padding: 0.5rem 1rem;
    border: 1px solid #dee2e6;
    border-radius: 6px;
    background: white;
    color: #6c757d;
    font-size: 0.875rem;
    font-weight: 500;
    cursor: pointer;
    transition: var(--transition);
  }

  .filter-btn:hover {
    background-color: #f8f9fa;
  }

  .filter-btn.active {
    background-color: var(--primary);
    color: white;
    border-color: var(--primary);
  }

  /* Tabs */
  .nav-tabs {
    border-bottom: 1px solid rgba(0, 0, 0, 0.05);
  }

  .nav-tabs .nav-link {
    border: none;
    color: var(--gray);
    font-weight: 500;
    padding: 0.75rem 1.25rem;
    margin-right: 0.5rem;
    border-radius: 8px 8px 0 0;
    transition: var(--transition);
  }

  .nav-tabs .nav-link:hover {
    color: var(--primary);
    background: rgba(67, 97, 238, 0.05);
  }

  .nav-tabs .nav-link.active {
    color: var(--primary);
    background-color: transparent;
    border-bottom: 3px solid var(--primary);
    font-weight: 600;
  }

  /* Badges */
  .badge {
    font-weight: 600;
    padding: 0.5em 0.8em;
    border-radius: 8px;
    font-size: 0.75rem;
    letter-spacing: 0.5px;
  }

  .badge-primary {
    background-color: var(--primary-light);
    color: var(--primary);
  }

  .badge-success {
    background-color: rgba(76, 201, 240, 0.1);
    color: var(--success);
  }

  .badge-danger {
    background-color: rgba(247, 37, 133, 0.1);
    color: var(--danger);
  }

  .badge-warning {
    background-color: rgba(248, 150, 30, 0.1);
    color: var(--warning);
  }

  /* Alert Card */
  .alert-card {
    border: none;
    border-radius: var(--border-radius);
    box-shadow: var(--box-shadow);
    margin-bottom: 2rem;
    background: white;
  }

  .alert-card .card-header {
    background: linear-gradient(135deg, var(--danger) 0%, #b5179e 100%);
    color: white;
    border-radius: var(--border-radius) var(--border-radius) 0 0 !important;
    padding: 1.25rem 1.5rem;
    font-weight: 600;
  }

  .alert-card .card-header i {
    margin-right: 0.5rem;
  }

  .alert-list {
    max-height: 400px;
    overflow-y: auto;
  }

  .alert-item {
    padding: 1rem 1.5rem;
    border-bottom: 1px solid rgba(0, 0, 0, 0.05);
    transition: var(--transition);
    display: flex;
    align-items: center;
  }

  .alert-item:last-child {
    border-bottom: none;
  }

  .alert-item:hover {
    background-color: rgba(0, 0, 0, 0.02);
  }

  .alert-icon {
    width: 40px;
    height: 40px;
    border-radius: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-right: 1rem;
    font-size: 1.25rem;
    flex-shrink: 0;
  }

  .alert-icon.naissance {
    background-color: rgba(67, 97, 238, 0.1);
    color: var(--primary);
  }

  .alert-icon.mariage {
    background-color: rgba(248, 150, 30, 0.1);
    color: var(--warning);
  }

  .alert-icon.deces, .alert-icon.decesHop {
    background-color: rgba(247, 37, 133, 0.1);
    color: var(--danger);
  }

  .alert-content {
    flex-grow: 1;
  }

  .alert-time {
    font-size: 0.75rem;
    color: var(--gray);
    margin-top: 0.25rem;
  }

  /* Request Table */
  .request-table {
    width: 100%;
    border-collapse: separate;
    border-spacing: 0;
  }

  .request-table thead th {
    background-color: var(--primary-light);
    color: var(--primary);
    font-weight: 600;
    padding: 0.75rem 1rem;
    border: none;
    position: sticky;
    top: 0;
  }

  .request-table tbody tr {
    transition: var(--transition);
  }

  .request-table tbody tr:hover {
    background-color: rgba(0, 0, 0, 0.02);
  }

  .request-table td {
    padding: 1rem;
    border-bottom: 1px solid rgba(0, 0, 0, 0.05);
    vertical-align: middle;
  }

  .request-table tr:last-child td {
    border-bottom: none;
  }

  .request-status {
    padding: 0.35rem 0.75rem;
    border-radius: 20px;
    font-size: 0.75rem;
    font-weight: 600;
  }

  .status-validé {
    background-color: rgba(40, 167, 69, 0.1);
    color: #28a745;
  }

  .status-attente {
    background-color: rgba(255, 193, 7, 0.1);
    color: #ffc107;
  }

  .status-rejeté {
    background-color: rgba(220, 53, 69, 0.1);
    color: #dc3545;
  }

  /* Responsive adjustments */
  @media (max-width: 768px) {
    .welcome-card {
      text-align: center;
    }
    .welcome-icon {
      position: relative;
      right: auto;
      top: auto;
      transform: none;
      margin-top: 1rem;
    }
    .chart-container {
      height: 300px;
    }
    .filter-buttons {
      flex-wrap: wrap;
    }
  }
</style>

<div class="container-fluid py-4">
  <!-- Welcome Card -->
  <div class="welcome-card">
    <div class="row align-items-center">
      <div class="col-md-8">
        <h2>Bonjour, {{ Auth::user()->name }} {{ Auth::user()->prenom }}!</h2>
        <p>Bienvenue sur votre tableau de bord de gestion des demandes</p>
        <div class="d-flex align-items-center mt-2">
          <span class="badge badge-primary me-2">
            <i class="mdi mdi-city me-1"></i> {{ Auth::user()->communeM }}
          </span>
          <span class="badge badge-primary">
            <i class="mdi mdi-identifier me-1"></i> Responsable financier
          </span>
        </div>
      </div>
      <div class="col-md-4 text-md-end position-relative">
        <i class="mdi mdi-finance welcome-icon"></i>
      </div>
    </div>
  </div>

  <!-- Statistics Cards -->
  <div class="row mb-4">
    <!-- Total Requests -->
    <div class="col-xl-3 col-md-6 mb-4">
      <div class="stat-card">
        <div class="card-body">
          <div class="icon-container icon-primary">
            <i class="mdi mdi-file-document-multiple"></i>
          </div>
          <div class="stat-value">{{ $total }}</div>
          <div class="stat-label">Demandes Totales</div>
          <div class="stat-description">Tous types confondus</div>
        </div>
      </div>
    </div>

    <!-- Provided Balance -->
    <div class="col-xl-3 col-md-6 mb-4">
      <div class="stat-card">
        <div class="card-body">
          <div class="icon-container icon-success">
            <i class="mdi mdi-cash-multiple"></i>
          </div>
          <div class="stat-value">{{ number_format($soldeActuel, 0, ',', ' ') }} <small>FCFA</small></div>
          <div class="stat-label">Solde Initial</div>
          <div class="stat-description">Montant alloué</div>
        </div>
      </div>
    </div>

    <!-- Debited Balance -->
    <div class="col-xl-3 col-md-6 mb-4">
      <div class="stat-card">
        <div class="card-body">
          <div class="icon-container icon-danger">
            <i class="mdi mdi-cash-minus"></i>
          </div>
          <div class="stat-value">{{ number_format($soldeDebite, 0, ',', ' ') }} <small>FCFA</small></div>
          <div class="stat-label">Total Débité</div>
          <div class="stat-description">Pour {{ $total }} demandes</div>
        </div>
      </div>
    </div>

    <!-- Remaining Balance -->
    <div class="col-xl-3 col-md-6 mb-4">
      <div class="stat-card">
        <div class="card-body">
          <div class="icon-container icon-warning">
            <i class="mdi mdi-cash-plus"></i>
          </div>
          <div class="stat-value">{{ number_format($soldeRestant, 0, ',', ' ') }} <small>FCFA</small></div>
          <div class="stat-label">Solde Restant</div>
          <div class="stat-description">Disponible</div>
        </div>
      </div>
    </div>
  </div>

  <!-- Monthly Statistics Cards -->
  <div class="row">
    <!-- Filter buttons -->
    <div class="col-6 mb-2">
        <div class="filter-buttons">
            <button class="filter-btn active" data-filter="day">
                <i class="mdi mdi-calendar-today me-1"></i> Aujourd'hui
            </button>
            <button class="filter-btn" data-filter="week">
                <i class="mdi mdi-calendar-week me-1"></i> Cette semaine
            </button>
            <button class="filter-btn" data-filter="month">
                <i class="mdi mdi-calendar-month me-1"></i> Ce mois
            </button>
        </div>
    </div>
    <div class="col-6 mb-2">
        <h5 class="mb-1 fw-bold text-black text-right">
            <i class="mdi mdi-calendar-month-outline "></i> Statistiques du mois en cours
        </h5>
    </div>
    
    <!-- Total Requests This Period -->
    <div class="col-xl-4 col-md-6 mb-4">
        <div class="stat-card">
            <div class="card-body">
                <div class="icon-container icon-primary">
                    <i class="mdi mdi-calendar-check"></i>
                </div>
                <div class="stat-value" id="total-period">{{ $totalAujourdhui }}</div>
                <div class="stat-label">Total Demandes</div>
                <div class="stat-description" id="period-description">Aujourd'hui</div>
            </div>
        </div>
    </div>

    <!-- Timbres vendus This Period -->
    <div class="col-xl-4 col-md-6 mb-4">
        <div class="stat-card">
            <div class="card-body">
                <div class="icon-container icon-success">
                    <i class="mdi mdi-stamper"></i>
                </div>
                <div class="stat-value" id="timbres-period">{{$timbresAujourdhui }}</div>
                <div class="stat-label">Timbres vendus</div>
                <div class="stat-description" id="timbres-description">Aujourd'hui</div>
            </div>
        </div>
    </div>

    <!-- Montant total This Period -->
    <div class="col-xl-4 col-md-6 mb-4">
        <div class="stat-card">
            <div class="card-body">
                <div class="icon-container icon-warning">
                    <i class="mdi mdi-cash"></i>
                </div>
                <div class="stat-value" id="montant-period">{{ number_format($montantAujourdhui, 0, ',', ' ') }} <small>FCFA</small></div>
                <div class="stat-label">Montant total</div>
                <div class="stat-description" id="montant-description">Aujourd'hui</div>
            </div>
        </div>
    </div>
  </div>

  <!-- Detailed Stats and Charts -->
  <div class="row mb-4">
    <!-- Main Chart -->
    <div class="col-lg-8 mb-4">
      <div class="chart-card">
        <div class="card-header">
          <div>
            <i class="mdi mdi-chart-line"></i>
            <span>Évolution des demandes</span>
          </div>
          <div class="btn-group btn-group-sm">
            <button class="btn btn-sm btn-outline-primary active" id="btn-week">
              <i class="mdi mdi-calendar-week me-1"></i> 7 jours
            </button>
            <button class="btn btn-sm btn-outline-primary" id="btn-month">
              <i class="mdi mdi-calendar-month me-1"></i> 30 jours
            </button>
            <button class="btn btn-sm btn-outline-primary" id="btn-year">
              <i class="mdi mdi-calendar-blank me-1"></i> 1 an
            </button>
          </div>
        </div>
        <div class="card-body p-0">
          <div class="chart-container1 chart-container">
            <canvas id="evolutionChart"></canvas>
          </div>
        </div>
      </div>
    </div>

    <!-- Request Distribution -->
    <div class="col-lg-4 mb-4">
      <div class="chart-card">
        <div class="card-header">
          <i class="mdi mdi-chart-pie"></i>
          <span>Répartition des demandes</span>
        </div>
        <div class="card-body p-0">
          <div class="chart-container">
            <canvas id="distributionChart"></canvas>
          </div>
          <div class="px-3 pb-3 pt-2">
            <div class="row text-center">
              <div class="col-4">
                <div class="badge badge-primary mb-1">
                  <i class="mdi mdi-baby-face-outline me-1"></i> Naissances
                </div>
                <div class="h5">{{ $naissancenombre + $naissanceDnombre }}</div>
              </div>
              <div class="col-4">
                <div class="badge badge-danger mb-1">
                  <i class="mdi mdi-cross me-1"></i> Décès
                </div>
                <div class="h5">{{ $decesnombre + $decesdejanombre }}</div>
              </div>
              <div class="col-4">
                <div class="badge badge-warning mb-1">
                  <i class="mdi mdi-heart me-1"></i> Mariages
                </div>
                <div class="h5">{{ $mariagenombre }}</div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Récupérer les données passées depuis le contrôleur
    const weeklyData = {
        labels: {!! json_encode([
            Carbon\Carbon::now()->subDays(6)->format('D'),
            Carbon\Carbon::now()->subDays(5)->format('D'),
            Carbon\Carbon::now()->subDays(4)->format('D'),
            Carbon\Carbon::now()->subDays(3)->format('D'),
            Carbon\Carbon::now()->subDays(2)->format('D'),
            Carbon\Carbon::now()->subDays(1)->format('D'),
            Carbon\Carbon::now()->format('D')
        ]) !!},
        naissances: {!! json_encode($weeklyData['naissances']) !!},
        deces: {!! json_encode($weeklyData['deces']) !!},
        mariages: {!! json_encode($weeklyData['mariages']) !!}
    };

    const monthlyData = {
        labels: {!! json_encode(array_map(function($i) {
            return Carbon\Carbon::now()->subDays(29 - $i)->format('j M');
        }, range(0, 29))) !!},
        naissances: {!! json_encode($monthlyData['naissances']) !!},
        deces: {!! json_encode($monthlyData['deces']) !!},
        mariages: {!! json_encode($monthlyData['mariages']) !!}
    };

    const yearlyData = {
        labels: {!! json_encode(array_map(function($i) {
            return Carbon\Carbon::now()->subMonths(11 - $i)->format('M Y');
        }, range(0, 11))) !!},
        naissances: {!! json_encode($yearlyData['naissances']) !!},
        deces: {!! json_encode($yearlyData['deces']) !!},
        mariages: {!! json_encode($yearlyData['mariages']) !!}
    };

    // Données pour les statistiques du mois en cours
    const statsData = {
        day: {
            total: {{ $totalAujourdhui }},
            timbres: {{ $timbresAujourdhui }},
            montant: {{ $montantAujourdhui }},
            description: "Aujourd'hui"
        },
        week: {
            total: {{ $totalSemaine }},
            timbres: {{ $timbresSemaine }},
            montant: {{ $montantSemaine }},
            description: "Cette semaine"
        },
        month: {
            total: {{ $totalMois }},
            timbres: {{ $timbresMois }},
            montant: {{ $montantMois }},
            description: "Ce mois"
        }
    };

    // Fonction pour mettre à jour les statistiques selon le filtre
    function updateStats(filter) {
        const data = statsData[filter];
        document.getElementById('total-period').textContent = data.total;
        document.getElementById('timbres-period').textContent = data.timbres;
        document.getElementById('montant-period').innerHTML = data.montant.toLocaleString('fr-FR') + ' <small>FCFA</small>';
        
        // Mettre à jour les descriptions
        document.querySelectorAll('#period-description, #timbres-description, #montant-description').forEach(el => {
            el.textContent = data.description;
        });
    }

    // Gestion des boutons de filtre
    document.querySelectorAll('.filter-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            const filter = this.dataset.filter;
            
            // Mettre à jour l'état actif des boutons
            document.querySelectorAll('.filter-btn').forEach(b => b.classList.remove('active'));
            this.classList.add('active');
            
            // Mettre à jour les statistiques
            updateStats(filter);
        });
    });

    // Initialiser avec les données du jour
    updateStats('day');

    // Evolution Chart (Line)
    const evolutionCtx = document.getElementById('evolutionChart').getContext('2d');
    let evolutionChart = new Chart(evolutionCtx, {
        type: 'line',
        data: {
            labels: weeklyData.labels,
            datasets: [
                {
                    label: 'Naissances',
                    data: weeklyData.naissances,
                    borderColor: 'rgba(67, 97, 238, 1)',
                    backgroundColor: 'rgba(67, 97, 238, 0.05)',
                    borderWidth: 2,
                    tension: 0.4,
                    fill: true,
                    pointBackgroundColor: 'white',
                    pointBorderColor: 'rgba(67, 97, 238, 1)',
                    pointBorderWidth: 2,
                    pointRadius: 4,
                    pointHoverRadius: 6
                },
                {
                    label: 'Décès',
                    data: weeklyData.deces,
                    borderColor: 'rgba(247, 37, 133, 1)',
                    backgroundColor: 'rgba(247, 37, 133, 0.05)',
                    borderWidth: 2,
                    tension: 0.4,
                    fill: true,
                    pointBackgroundColor: 'white',
                    pointBorderColor: 'rgba(247, 37, 133, 1)',
                    pointBorderWidth: 2,
                    pointRadius: 4,
                    pointHoverRadius: 6
                },
                {
                    label: 'Mariages',
                    data: weeklyData.mariages,
                    borderColor: 'rgba(248, 150, 30, 1)',
                    backgroundColor: 'rgba(248, 150, 30, 0.05)',
                    borderWidth: 2,
                    tension: 0.4,
                    fill: true,
                    pointBackgroundColor: 'white',
                    pointBorderColor: 'rgba(248, 150, 30, 1)',
                    pointBorderWidth: 2,
                    pointRadius: 4,
                    pointHoverRadius: 6
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'top',
                    align: 'end',
                    labels: {
                        usePointStyle: true,
                        padding: 20,
                        font: {
                            family: 'Inter',
                            size: 12
                        }
                    }
                },
                tooltip: {
                    backgroundColor: 'white',
                    titleColor: '#1a1a2e',
                    bodyColor: '#6c757d',
                    borderColor: 'rgba(0, 0, 0, 0.1)',
                    borderWidth: 1,
                    padding: 12,
                    usePointStyle: true,
                    callbacks: {
                        label: function(context) {
                            return `${context.dataset.label}: ${context.parsed.y} demande(s)`;
                        }
                    }
                }
            },
            interaction: {
                intersect: false,
                mode: 'index'
            },
            scales: {
                y: {
                    beginAtZero: true,
                    grid: {
                        drawBorder: false,
                        color: 'rgba(0, 0, 0, 0.05)'
                    },
                    ticks: {
                        precision: 0
                    }
                },
                x: {
                    grid: {
                        display: false,
                        drawBorder: false
                    }
                }
            }
        }
    });

    // Distribution Chart (Doughnut)
    const distributionCtx = document.getElementById('distributionChart').getContext('2d');
    const distributionChart = new Chart(distributionCtx, {
        type: 'doughnut',
        data: {
            labels: ['Naissances', 'Décès', 'Mariages'],
            datasets: [{
                data: [
                    {{ $naissancenombre + $naissanceDnombre }}, 
                    {{ $decesnombre + $decesdejanombre }}, 
                    {{ $mariagenombre }}
                ],
                backgroundColor: [
                    'rgba(67, 97, 238, 1)',
                    'rgba(247, 37, 133, 1)',
                    'rgba(248, 150, 30, 1)'
                ],
                borderWidth: 0,
                hoverOffset: 10
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            cutout: '70%',
            plugins: {
                legend: {
                    display: false
                },
                tooltip: {
                    backgroundColor: 'white',
                    titleColor: '#1a1a2e',
                    bodyColor: '#6c757d',
                    borderColor: 'rgba(0, 0, 0, 0.1)',
                    borderWidth: 1,
                    padding: 12,
                    usePointStyle: true,
                    callbacks: {
                        label: function(context) {
                            const total = context.dataset.data.reduce((a, b) => a + b, 0);
                            const value = context.raw;
                            const percentage = Math.round((value / total) * 100);
                            return `${context.label}: ${value} (${percentage}%)`;
                        }
                    }
                }
            }
        }
    });

    // Gestion des boutons de période
    document.getElementById('btn-week').addEventListener('click', function() {
        updateChart(weeklyData);
        setActiveButton(this);
    });

    document.getElementById('btn-month').addEventListener('click', function() {
        updateChart(monthlyData);
        setActiveButton(this);
    });

    document.getElementById('btn-year').addEventListener('click', function() {
        updateChart(yearlyData);
        setActiveButton(this);
    });

    function updateChart(data) {
        evolutionChart.data.labels = data.labels;
        evolutionChart.data.datasets[0].data = data.naissances;
        evolutionChart.data.datasets[1].data = data.deces;
        evolutionChart.data.datasets[2].data = data.mariages;
        evolutionChart.update();
    }

    function setActiveButton(activeBtn) {
        document.querySelectorAll('#evolutionChart ~ .card-header .btn').forEach(btn => {
            btn.classList.remove('active');
        });
        activeBtn.classList.add('active');
    }
});
</script>
@endsection