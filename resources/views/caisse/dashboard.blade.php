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
  }
</style>

<div class="container-fluid py-4">
  <!-- Welcome Card -->
  <div class="welcome-card">
    <div class="row align-items-center">
      <div class="col-md-8">
        <h2>Bonjour, {{ Auth::guard('caisse')->user()->name }}!</h2>
        <p>Bienvenue sur votre tableau de bord de gestion des demandes</p>
        <div class="d-flex align-items-center mt-2">
          <span class="badge badge-primary me-2">
            <i class="mdi mdi-city me-1"></i> {{ Auth::guard('caisse')->user()->communeM }}
          </span>
          <span class="badge badge-primary">
            <i class="mdi mdi-identifier me-1"></i> Caisse N°{{ Auth::guard('caisse')->user()->id }}
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
<div class="row mb-4">
    <div class="col-12">
        <h5 class="mb-3 fw-bold text-muted">
            <i class="mdi mdi-calendar-month-outline me-1"></i> Statistiques du mois en cours
        </h5>
    </div>
    
    <!-- Total Requests This Month -->
    <div class="col-xl-2 col-md-4 col-6 mb-4">
        <div class="stat-card">
            <div class="card-body">
                <div class="icon-container icon-primary">
                    <i class="mdi mdi-calendar-check"></i>
                </div>
                <div class="stat-value">{{ $totalMois }}</div>
                <div class="stat-label">Total Mois</div>
                <div class="stat-description">{{ Carbon\Carbon::now()->format('F Y') }}</div>
            </div>
        </div>
    </div>

    <!-- Naissances This Month -->
    <div class="col-xl-2 col-md-4 col-6 mb-4">
        <div class="stat-card">
            <div class="card-body">
                <div class="icon-container icon-success">
                    <i class="mdi mdi-baby-face-outline"></i>
                </div>
                <div class="stat-value">{{ $naissanceMois + $naissanceDMois }}</div>
                <div class="stat-label">Naissances</div>
                <div class="stat-description">Ce mois</div>
            </div>
        </div>
    </div>

    <!-- Décès This Month -->
    <div class="col-xl-2 col-md-4 col-6 mb-4">
        <div class="stat-card">
            <div class="card-body">
                <div class="icon-container icon-danger">
                    <i class="mdi mdi-cross"></i>
                </div>
                <div class="stat-value">{{ $decesMois + $decesdejaMois }}</div>
                <div class="stat-label">Décès</div>
                <div class="stat-description">Ce mois</div>
            </div>
        </div>
    </div>

    <!-- Mariages This Month -->
    <div class="col-xl-2 col-md-4 col-6 mb-4">
        <div class="stat-card">
            <div class="card-body">
                <div class="icon-container icon-warning">
                    <i class="mdi mdi-heart"></i>
                </div>
                <div class="stat-value">{{ $mariageMois }}</div>
                <div class="stat-label">Mariages</div>
                <div class="stat-description">Ce mois</div>
            </div>
        </div>
    </div>

    <!-- Daily Average -->
    <div class="col-xl-2 col-md-4 col-6 mb-4">
        <div class="stat-card">
            <div class="card-body">
                <div class="icon-container icon-info">
                    <i class="mdi mdi-chart-bar"></i>
                </div>
                <div class="stat-value">{{ round($totalMois / Carbon\Carbon::now()->day, 1) }}</div>
                <div class="stat-label">Moyenne/jour</div>
                <div class="stat-description">Ce mois</div>
            </div>
        </div>
    </div>

    <!-- Projection Month End -->
    <div class="col-xl-2 col-md-4 col-6 mb-4">
      <div class="stat-card">
          <div class="card-body">
              <div class="icon-container icon-secondary">
                  <i class="mdi mdi-cash"></i>
              </div>
              <div class="stat-value">{{ number_format($montantMois, 0, ',', ' ') }} <small>FCFA</small></div>
              <div class="stat-label">Montant</div>
              <div class="stat-description">Ce mois</div>
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

  <!-- Recent Activity -->
  {{-- <div class="row">
    <!-- Recent Requests -->
    <div class="col-lg-8 mb-4">
      <div class="chart-card">
        <div class="card-header">
          <i class="mdi mdi-clock-outline"></i>
          <span>Demandes Récentes</span>
        </div>
        <div class="card-body">
          <ul class="nav nav-tabs" id="requestsTab" role="tablist">
            <li class="nav-item" role="presentation">
              <button class="nav-link active" id="naissance-tab" data-bs-toggle="tab" data-bs-target="#naissance" type="button">
                <i class="mdi mdi-baby-face-outline me-1"></i> Naissances ({{ $demandesNaissance->count() }})
              </button>
            </li>
            <li class="nav-item" role="presentation">
              <button class="nav-link" id="deces-tab" data-bs-toggle="tab" data-bs-target="#deces" type="button">
                <i class="mdi mdi-cross me-1"></i> Décès ({{ $demandesDeces->count() }})
              </button>
            </li>
            <li class="nav-item" role="presentation">
              <button class="nav-link" id="mariage-tab" data-bs-toggle="tab" data-bs-target="#mariage" type="button">
                <i class="mdi mdi-heart me-1"></i> Mariages ({{ $demandesMariage->count() }})
              </button>
            </li>
          </ul>
          <div class="tab-content mt-3" id="requestsTabContent">
            <!-- Naissances Tab -->
            <div class="tab-pane fade show active" id="naissance" role="tabpanel">
              <div class="table-responsive">
                <table class="request-table">
                  <thead>
                    <tr>
                      <th>N°</th>
                      <th>Nom</th>
                      <th>Date</th>
                      <th>Statut</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach($demandesNaissance as $demande)
                    <tr>
                      <td>{{ $demande->id }}</td>
                      <td>{{ $demande->nom_enfant ?? 'N/A' }}</td>
                      <td>{{ $demande->created_at->format('d/m/Y') }}</td>
                      <td>
                        <span class="request-status status-{{ strtolower($demande->statut) }}">
                          {{ $demande->statut }}
                        </span>
                      </td>
                      <td>
                        <button class="btn btn-sm btn-outline-primary">
                          <i class="mdi mdi-eye"></i> Voir
                        </button>
                      </td>
                    </tr>
                    @endforeach
                  </tbody>
                </table>
              </div>
            </div>
            
            <!-- Décès Tab -->
            <div class="tab-pane fade" id="deces" role="tabpanel">
              <div class="table-responsive">
                <table class="request-table">
                  <thead>
                    <tr>
                      <th>N°</th>
                      <th>Nom</th>
                      <th>Date</th>
                      <th>Statut</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach($demandesDeces as $demande)
                    <tr>
                      <td>{{ $demande->id }}</td>
                      <td>{{ $demande->nom_defunt ?? 'N/A' }}</td>
                      <td>{{ $demande->created_at->format('d/m/Y') }}</td>
                      <td>
                        <span class="request-status status-{{ strtolower($demande->statut) }}">
                          {{ $demande->statut }}
                        </span>
                      </td>
                      <td>
                        <button class="btn btn-sm btn-outline-primary">
                          <i class="mdi mdi-eye"></i> Voir
                        </button>
                      </td>
                    </tr>
                    @endforeach
                  </tbody>
                </table>
              </div>
            </div>
            
            <!-- Mariages Tab -->
            <div class="tab-pane fade" id="mariage" role="tabpanel">
              <div class="table-responsive">
                <table class="request-table">
                  <thead>
                    <tr>
                      <th>N°</th>
                      <th>Noms</th>
                      <th>Date</th>
                      <th>Statut</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach($demandesMariage as $demande)
                    <tr>
                      <td>{{ $demande->id }}</td>
                      <td>{{ $demande->nom_epoux ?? 'N/A' }} & {{ $demande->nom_epouse ?? 'N/A' }}</td>
                      <td>{{ $demande->created_at->format('d/m/Y') }}</td>
                      <td>
                        <span class="request-status status-{{ strtolower($demande->statut) }}">
                          {{ $demande->statut }}
                        </span>
                      </td>
                      <td>
                        <button class="btn btn-sm btn-outline-primary">
                          <i class="mdi mdi-eye"></i> Voir
                        </button>
                      </td>
                    </tr>
                    @endforeach
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div> --}}

    {{-- <!-- Alerts -->
    <div class="col-lg-4 mb-4">
      <div class="alert-card">
        <div class="card-header">
          <i class="mdi mdi-alert-circle-outline"></i>
          <span>Alertes Récentes</span>
          <span class="badge bg-white text-danger ms-2">{{ $alerts->count() }}</span>
        </div>
        <div class="card-body p-0">
          @if($alerts->count() > 0)
            <div class="alert-list">
              @foreach($alerts as $alert)
                <div class="alert-item">
                  <div class="alert-icon {{ $alert->type }}">
                    @if($alert->type === 'naissance' || $alert->type === 'naissHop')
                      <i class="mdi mdi-baby-face-outline"></i>
                    @elseif($alert->type === 'mariage')
                      <i class="mdi mdi-heart"></i>
                    @else
                      <i class="mdi mdi-cross"></i>
                    @endif
                  </div>
                  <div class="alert-content">
                    <div class="fw-semibold text-capitalize">{{ str_replace('Hop', ' Hôpital', $alert->type) }}</div>
                    <p class="mb-0 small">{{ $alert->message }}</p>
                    <div class="alert-time">
                      <i class="mdi mdi-clock-outline me-1"></i> {{ $alert->created_at->diffForHumans() }}
                    </div>
                  </div>
                  <button class="btn btn-sm btn-outline-primary">
                    <i class="mdi mdi-eye"></i>
                  </button>
                </div>
              @endforeach
            </div>
          @else
            <div class="text-center py-5">
              <i class="mdi mdi-check-circle-outline display-4 text-success mb-3"></i>
              <h5>Aucune alerte récente</h5>
              <p class="text-muted">Tout est à jour</p>
            </div>
          @endif
        </div>
      </div>
    </div>
  </div>
</div> --}}

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