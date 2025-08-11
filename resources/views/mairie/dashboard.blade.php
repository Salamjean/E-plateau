@extends('mairie.layouts.template')

@section('content')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<div class="container-fluid px-4">
  <!-- En-tête avec filtre -->
  <div class="d-flex justify-content-between align-items-center mb-4">
    <div>
      <h1 class="fw-bold mb-1">Tableau de Bord</h1>
      <p class="text-muted mb-0">Mairie de {{ Auth::guard('mairie')->user()->name }}</p>
    </div>
    <div class="d-flex gap-2">
      <div class="dropdown">
        <button class="btn btn-outline-primary dropdown-toggle" type="button" id="filterDropdown" data-bs-toggle="dropdown">
          <i class="fas fa-calendar-alt me-2"></i>
          {{ date('F Y', mktime(0, 0, 0, $selectedMonth, 1, $selectedYear)) }}
        </button>
        <div class="dropdown-menu p-3" style="width: 300px;">
          <form method="GET" action="{{ route('mairie.dashboard') }}">
            <div class="row g-2">
              <div class="col-6">
                <label class="form-label small">Mois</label>
                <select name="month" class="form-select form-select-sm">
                  @for ($m = 1; $m <= 12; $m++)
                    <option value="{{ $m }}" {{ $m == $selectedMonth ? 'selected' : '' }}>
                      {{ date('F', mktime(0, 0, 0, $m, 1)) }}
                    </option>
                  @endfor
                </select>
              </div>
              <div class="col-6">
                <label class="form-label small">Année</label>
                <select name="year" class="form-select form-select-sm">
                  @for ($y = date('Y'); $y >= date('Y') - 5; $y--)
                    <option value="{{ $y }}" {{ $y == $selectedYear ? 'selected' : '' }}>{{ $y }}</option>
                  @endfor
                </select>
              </div>
              <div class="col-12 mt-2">
                <button type="submit" class="btn btn-primary btn-sm w-100">Appliquer</button>
              </div>
            </div>
          </form>
        </div>
      </div>
      <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#statsModal">
        <i class="fas fa-chart-line me-2"></i>Vue d'ensemble
      </button>
    </div>
  </div>

  <!-- Cartes de statistiques -->
  <div class="row g-4 mb-4">
    <!-- Carte principale -->
    <div class="col-xl-3 col-md-6">
      <div class="card border-0 shadow-sm h-100">
        <div class="card-body" style="border: 3px solid #0033c4; border-radius:15px">
          <div class="d-flex justify-content-between align-items-start">
            <div>
              <span class="badge bg-primary bg-opacity-10 text-white mb-2">Total</span>
              <h3 class="mb-2">{{ $totalData + $NaissHopTotal }}</h3>
              <p class="text-muted mb-0">Actes enregistrés</p>
            </div>
            <div class="bg-primary bg-opacity-10 p-3 rounded">
              <i class="fas fa-file-alt text-white fs-4"></i>
            </div>
          </div>
          <div class="mt-3">
            <div class="d-flex justify-content-between mb-1">
              <span class="small">Demandes des actes civils</span>
              <span class="small fw-bold">{{ $totalData }}</span>
            </div>
            <div class="progress" style="height: 6px;">
              <div class="progress-bar bg-primary" style="width: {{ $totalData > 0 ? 100 : 0 }}%"></div>
            </div>
          </div>
          <div class="mt-3">
            <div class="d-flex justify-content-between mb-1">
              <span class="small">Déclarations des hôpitaux</span>
              <span class="small fw-bold">{{ $NaissHopTotal }}</span>
            </div>
            <div class="progress" style="height: 6px;">
              <div class="progress-bar bg-info" style="width: {{ $NaissHopTotal > 0 ? 100 : 0 }}%"></div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Naissances -->
    <div class="col-xl-3 col-md-6">
      <div class="card border-0 shadow-sm h-100">
        <div class="card-body" style="border: 3px solid #00d284; border-radius:15px">
          <div class="d-flex justify-content-between align-items-start">
            <div>
              <span class="badge bg-success bg-opacity-10 text-white mb-2">Naissances</span>
              <h3 class="mb-2">{{ $Naiss }}</h3>
              <p class="text-muted mb-0">Demande d'extrait de naissance enregistrés</p>
            </div>
            <div class="bg-success bg-opacity-10 p-3 rounded">
              <i class="fas fa-baby text-white fs-4"></i>
            </div>
          </div>
          <div class="mt-4">
            <div class="d-flex align-items-center">
              <span class="badge-dot bg-success me-2"></span>
              <div class="flex-grow-1">
                <div class="d-flex justify-content-between">
                  <span class="small">Demandes avec certificat</span>
                  <span class="small fw-bold">{{ $naissancedash }}</span>
                </div>
              </div>
            </div>
            <div class="d-flex align-items-center mt-2">
              <span class="badge-dot bg-warning me-2"></span>
              <div class="flex-grow-1">
                <div class="d-flex justify-content-between">
                  <span class="small">Demandes sans certificat</span>
                  <span class="small fw-bold">{{ $naissanceDdash }}</span>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Décès -->
    <div class="col-xl-3 col-md-6">
      <div class="card border-0 shadow-sm h-100">
        <div class="card-body" style="border: 3px solid #ff0854; border-radius:15px">
          <div class="d-flex justify-content-between align-items-start">
            <div>
              <span class="badge bg-danger bg-opacity-10 text-white mb-2">Décès</span>
              <h3 class="mb-2">{{ $Dece }}</h3>
              <p class="text-muted mb-0">Demande d'extrait de décès enregistrés</p>
            </div>
            <div class="bg-danger bg-opacity-10 p-3 rounded">
              <i class="fas fa-cross text-white fs-4"></i>
            </div>
          </div>
          <div class="mt-4">
            <div class="d-flex align-items-center">
              <span class="badge-dot bg-danger me-2"></span>
              <div class="flex-grow-1">
                <div class="d-flex justify-content-between">
                  <span class="small">Demandes avec certificat</span>
                  <span class="small fw-bold">{{ $decesdash }}</span>
                </div>
              </div>
            </div>
            <div class="d-flex align-items-center mt-2">
              <span class="badge-dot bg-secondary me-2"></span>
              <div class="flex-grow-1">
                <div class="d-flex justify-content-between">
                  <span class="small">Demandes sans certificat</span>
                  <span class="small fw-bold">{{ $decesdejadash }}</span>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Mariages -->
    <div class="col-xl-3 col-md-6">
      <div class="card border-0 shadow-sm h-100">
        <div class="card-body" style="border: 3px solid #6f42c1; border-radius:15px ">
          <div class="d-flex justify-content-between align-items-start">
            <div>
              <span class="badge bg-purple bg-opacity-10 text-white mb-2">Mariages</span>
              <h3 class="mb-2">{{ $mariagedash }}</h3>
              <p class="text-muted mb-0">Actes enregistrés</p>
            </div>
            <div class="bg-purple bg-opacity-10 p-3 rounded">
              <i class="fas fa-ring text-white fs-4"></i>
            </div>
          </div>
          <div class="mt-4">
            <div class="d-flex align-items-center">
              <span class="badge-dot bg-purple me-2">  </span>
              <div class="flex-grow-1">
                <div class="d-flex justify-content-between">
                  <span class="small">  Pourcentage</span>
                  <span class="small fw-bold">  {{ round($mariagePercentage) }}%</span>
                </div>
                <div class="progress mt-1" style="height: 4px;">
                  <div class="progress-bar bg-purple" style="width: {{ $mariagePercentage }}%"></div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Graphiques et données -->
  <div class="row g-4">
    <!-- Graphique des actes civils -->
    <div class="col-lg-6">
      <div class="card border-0 shadow-sm h-100">
        <div class="card-header bg-white border-0 d-flex justify-content-between align-items-center">
          <h5 class="mb-0">Répartition des actes civils</h5>
          <div class="dropdown">
            <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown">
              <i class="fas fa-ellipsis-v"></i>
            </button>
            <ul class="dropdown-menu dropdown-menu-end">
              <li><a class="dropdown-item" href="#">Exporter</a></li>
              <li><a class="dropdown-item" href="#">Imprimer</a></li>
            </ul>
          </div>
        </div>
        <div class="card-body">
          <canvas id="civilActsChart" height="120"></canvas>
        </div>
      </div>
    </div>

    <!-- Graphique des actes hôpitaux -->
    <div class="col-lg-6">
      <div class="card border-0 shadow-sm h-100">
        <div class="card-header bg-white border-0 d-flex justify-content-between align-items-center">
          <h5 class="mb-0">Actes hospitaliers</h5>
          <div class="dropdown">
            <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown">
              <i class="fas fa-ellipsis-v"></i>
            </button>
            <ul class="dropdown-menu dropdown-menu-end">
              <li><a class="dropdown-item" href="#">Exporter</a></li>
              <li><a class="dropdown-item" href="#">Imprimer</a></li>
            </ul>
          </div>
        </div>
        <div class="card-body">
          <div class="row">
            <div class="col-md-6">
              <div class="d-flex align-items-center mb-3">
                <div class="bg-primary bg-opacity-10 p-2 rounded me-3">
                  <i class="fas fa-baby-carriage text-primary"></i>
                </div>
                <div>
                  <h5 class="mb-0">{{ $naisshopsdash }}</h5>
                  <span class="text-muted small">Naissances</span>
                </div>
              </div>
            </div>
            <div class="col-md-6">
              <div class="d-flex align-items-center mb-3">
                <div class="bg-danger bg-opacity-10 p-2 rounded me-3">
                  <i class="fas fa-book-dead text-danger"></i>
                </div>
                <div>
                  <h5 class="mb-0">{{ $deceshopsdash }}</h5>
                  <span class="text-muted small">Décès</span>
                </div>
              </div>
            </div>
          </div>
          <canvas id="hospitalActsChart" height="120"></canvas>
        </div>
      </div>
    </div>

    <!-- Derniers enregistrements -->
    <!-- Derniers enregistrements -->
<div class="col-12">
  <div class="card border-0 shadow-sm">
    <div class="card-header bg-white border-0 d-flex justify-content-between align-items-center">
      <h5 class="mb-0">Derniers enregistrements</h5>
      <div class="dropdown">
        <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown">
          <i class="fas fa-ellipsis-v"></i>
        </button>
        <ul class="dropdown-menu dropdown-menu-end">
          <li><a class="dropdown-item" href="#"><i class="fas fa-download me-2"></i>Exporter</a></li>
          <li><a class="dropdown-item" href="#"><i class="fas fa-print me-2"></i>Imprimer</a></li>
        </ul>
      </div>
    </div>
    <div class="card-body p-0">
      <ul class="nav nav-tabs nav-tabs-card px-3" id="recordsTab" role="tablist">
        <li class="nav-item" role="presentation">
          <button class="nav-link active" id="naissances-tab" data-bs-toggle="tab" data-bs-target="#naissances-pane" type="button" role="tab" aria-controls="naissances-pane" aria-selected="true">
            <i class="fas fa-baby me-2" style="color: #00d284"></i>  Naissances
            <span class="badge bg-primary ms-2 text-white">{{ $recentNaissances->count() + $recentNaissancesd->count() }}</span>
          </button>
        </li>
        <li class="nav-item" role="presentation">
          <button class="nav-link" id="deces-tab" data-bs-toggle="tab" data-bs-target="#deces-pane" type="button" role="tab" aria-controls="deces-pane" aria-selected="false">
            <i class="fas fa-cross me-2" style="color: #ff0854"></i>  Décès
            <span class="badge bg-danger ms-2 text-white">{{ $recentDeces->count() + $recentDecesdeja->count() }}</span>
          </button>
        </li>
        <li class="nav-item" role="presentation">
          <button class="nav-link" id="mariages-tab" data-bs-toggle="tab" data-bs-target="#mariages-pane" type="button" role="tab" aria-controls="mariages-pane" aria-selected="false">
            <i class="fas fa-ring me-2" style="color: #6f42c1"></i>  Mariages
            <span class="badge bg-purple ms-2 text-white">{{ $recentMariages->count() }}</span>
          </button>
        </li>
        <li class="nav-item" role="presentation">
          <button class="nav-link" id="hopitaux-tab" data-bs-toggle="tab" data-bs-target="#hopitaux-pane" type="button" role="tab" aria-controls="hopitaux-pane" aria-selected="false">
            <i class="fas fa-hospital me-2" style="color: #00cff4"></i>  Hôpitaux
            <span class="badge bg-info ms-2 text-white">{{ $recentNaisshops->count() + $recentDeceshops->count() }}</span>
          </button>
        </li>
      </ul>
      
      <div class="tab-content p-3" id="recordsTabContent">
        <!-- Naissances -->
        <div class="tab-pane fade show active" id="naissances-pane" role="tabpanel" aria-labelledby="naissances-tab">
          <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
              <thead class="table-light">
                <tr>
                  <th width="120px" class="text-center">Type de demande</th>
                  <th class="text-center">Nom</th>
                  <th class="text-center">Prénom</th>
                  <th class="text-center">Commune</th>
                  <th class="text-center">Date d'emission</th>
                </tr>
              </thead>
              <tbody>
                @forelse($recentNaissances as $naissance)
                <tr>
                  <td class="text-center"><span class="badge bg-success text-white">Avec certificat</span></td>
                  <td class="text-center">{{ $naissance->nom }}</td>
                  <td class="text-center">{{ $naissance->prenom }}</td>
                  <td class="text-center">{{ $naissance->commune }}</td>
                  <td class="text-center">{{ $naissance->created_at->format('d:m:Y') }}</td>
                </tr>
                @empty
                <tr>
                  <td colspan="6" class="text-center py-4 text-muted">
                    <i class="fas fa-info-circle me-2"></i>Aucune naissance standard enregistrée
                  </td>
                </tr>
                @endforelse
                
                @forelse($recentNaissancesd as $naissanced)
                <tr>
                  <td class="text-center"><span class="badge bg-warning text-white">Sans certificat</span></td>
                  <td class="text-center">{{ $naissanced->name }}</td>
                  <td class="text-center">{{ $naissanced->prenom }}</td>
                  <td class="text-center">{{ $naissanced->commune }}</td>
                  <td class="text-center">{{ $naissanced->created_at->format('d:m:Y') }}</td>
                </tr>
                @empty
                <tr>
                  <td colspan="6" class="text-center py-4 text-muted">
                    <i class="fas fa-info-circle me-2"></i>Aucune naissance déjà enregistrée
                  </td>
                </tr>
                @endforelse
              </tbody>
            </table>
          </div>
        </div>
        
        <!-- Décès -->
        <div class="tab-pane fade" id="deces-pane" role="tabpanel" aria-labelledby="deces-tab">
          <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
              <thead class="table-light">
                <tr>
                  <th width="120px" class="text-center">Type de demande</th>
                  <th class="text-center">Nom</th>
                  <th class="text-center">Commune</th>
                  <th class="text-center">Date d'emission</th>
                  <th class="text-center">Heure d'emission</th>
                </tr>
              </thead>
              <tbody>
                @forelse($recentDeces as $deces)
                <tr>
                  <td><span class="badge bg-danger text-white">Avec certificat</span></td>
                  <td class="text-center">{{ $deces->nomDefunt }}</td>
                  <td class="text-center">{{ $deces->commune }}</td>
                  <td class="text-center">{{ $deces->created_at->format('d:m:Y') }}</td>
                  <td class="text-center">{{ $deces->created_at->format('H:i') }}</td>
                </tr>
                @empty
                <tr>
                  <td colspan="6" class="text-center py-4 text-muted">
                    <i class="fas fa-info-circle me-2"></i>Aucun décès standard enregistré
                  </td>
                </tr>
                @endforelse
                
                @forelse($recentDecesdeja as $decesdeja)
                <tr>
                  <td><span class="badge bg-secondary text-white">Sans certificat</span></td>
                  <td class="text-center">{{ $decesdeja->name }}</td>
                  <td class="text-center">{{ $decesdeja->commune }}</td>
                  <td class="text-center">{{ $decesdeja->created_at->format('d:m:Y') }}</td>
                  <td class="text-center">{{ $decesdeja->created_at->format('H:i') }}</td>
                </tr>
                @empty
                <tr>
                  <td colspan="6" class="text-center py-4 text-muted">
                    <i class="fas fa-info-circle me-2"></i>Aucun décès déjà enregistré
                  </td>
                </tr>
                @endforelse
              </tbody>
            </table>
          </div>
        </div>
        
        <!-- Mariages -->
        <div class="tab-pane fade" id="mariages-pane" role="tabpanel" aria-labelledby="mariages-tab">
          <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
              <thead class="table-light">
                <tr>
                  <th class="text-center ">Type de demande</th>
                  <th class="text-center">Commune</th>
                  <th class="text-center">Date d'emission</th>
                  <th class="text-center">Heure d'emission</th>
                </tr>
              </thead>
              <tbody>
                @forelse($recentMariages as $mariage)
                <tr>
                  <td class="text-center">{{ $mariage->nomEpoux ? 'Copie intégrale' : 'Copie simple' }}</td>
                  <td class="text-center">{{ $mariage->commune }}</td>
                  <td class="text-center">{{ $mariage->created_at->format('d:m:Y') }}</td>
                  <td class="text-center">{{ $mariage->created_at->format('H:i') }}</td>
                </tr>
                @empty
                <tr>
                  <td colspan="5" class="text-center py-4 text-muted">
                    <i class="fas fa-info-circle me-2"></i>Aucun mariage enregistré
                  </td>
                </tr>
                @endforelse
              </tbody>
            </table>
          </div>
        </div>
        
        <!-- Hôpitaux -->
        <div class="tab-pane fade" id="hopitaux-pane" role="tabpanel" aria-labelledby="hopitaux-tab">
          <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
              <thead class="table-light">
                <tr>
                  <th width="120px" class="text-center">Type de déclaration</th>
                  <th class="text-center">Nom </th>
                  <th class="text-center">Prénoms</th>
                  <th class="text-center">Hôpital</th>
                  <th class="text-center">Date déclaration</th>
                </tr>
              </thead>
              <tbody>
                @forelse($recentNaisshops as $naisshop)
                <tr>
                  <td class="text-center"><span class="badge bg-primary text-white">Naissance</span></td>
                  <td class="text-center">{{ $naisshop->NomM  }}</td>
                  <td class="text-center">{{ $naisshop->PrM }}</td>
                  <td class="text-center">{{ $naisshop->NomEnf }}</td>
                  <td class="text-center">{{ $naisshop->created_at }}</td>
                </tr>
                @empty
                <tr>
                  <td colspan="5" class="text-center py-4 text-muted">
                    <i class="fas fa-info-circle me-2"></i>Aucune naissance hospitalière enregistrée
                  </td>
                </tr>
                @endforelse
                
                @forelse($recentDeceshops as $deceshop)
                <tr>
                  <td class="text-center"><span class="badge bg-danger text-white">Décès</span></td>
                  <td class="text-center">{{ $deceshop->NomM }}</td>
                  <td class="text-center">{{ $deceshop->PrM }}</td>
                  <td class="text-center">{{ $deceshop->nomHop }}</td>
                  <td class="text-center">{{ $deceshop->created_at }}</td>
                </tr>
                @empty
                <tr>
                  <td colspan="5" class="text-center py-4 text-muted">
                    <i class="fas fa-info-circle me-2"></i>Aucun décès hospitalier enregistré
                  </td>
                </tr>
                @endforelse
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
  </div>
</div>

<!-- Modal Stats -->
<div class="modal fade" id="statsModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Statistiques détaillées</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-md-6">
            <div class="card border-0 shadow-sm mb-4">
              <div class="card-body">
                <h6 class="mb-3">Actes civils</h6>
                <div class="d-flex justify-content-between mb-2">
                  <span>Naissances</span>
                  <span class="fw-bold">{{ $naissances->count() + $naissancesD->count() }}</span>
                </div>
                <div class="d-flex justify-content-between mb-2">
                  <span>Décès</span>
                  <span class="fw-bold">{{ $deces->count() + $decesdeja->count() }}</span>
                </div>
                <div class="d-flex justify-content-between">
                  <span>Mariages</span>
                  <span class="fw-bold">{{ $mariages->count() }}</span>
                </div>
              </div>
            </div>
          </div>
          <div class="col-md-6">
            <div class="card border-0 shadow-sm mb-4">
              <div class="card-body">
                <h6 class="mb-3">Actes hospitaliers</h6>
                <div class="d-flex justify-content-between mb-2">
                  <span>Naissances</span>
                  <span class="fw-bold">{{ $naisshopsdash }}</span>
                </div>
                <div class="d-flex justify-content-between">
                  <span>Décès</span>
                  <span class="fw-bold">{{ $deceshopsdash }}</span>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="card border-0 shadow-sm">
          <div class="card-body">
            <canvas id="statsChart" height="250"></canvas>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
        <button type="button" class="btn btn-primary">Exporter</button>
      </div>
    </div>
  </div>
</div>

<!-- Styles -->
<style>
  .card {
    border-radius: 12px;
    transition: transform 0.2s ease, box-shadow 0.2s ease;
    
  }
  
  .card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 20px rgba(0,0,0,0.1) !important;
  }
  
  .badge-dot {
    display: inline-block;
    width: 10px;
    height: 10px;
    border-radius: 50%;
  }
  
  .nav-tabs-card {
    border-bottom: 1px solid #e9ecef;
  }
  
  .nav-tabs-card .nav-link {
    border: none;
    padding: 12px 20px;
    color: #6c757d;
    font-weight: 500;
    border-radius: 8px 8px 0 0;
  }
  
  .nav-tabs-card .nav-link.active {
    color: #0d6efd;
    background-color: rgba(13, 110, 253, 0.1);
  }
  
  .table th {
    font-weight: 600;
    text-transform: uppercase;
    font-size: 0.75rem;
    letter-spacing: 0.5px;
    color: #6c757d;
  }
  
  .progress {
    border-radius: 100px;
  }
  
  .bg-purple {
    background-color: #6f42c1 !important;
  }
  
  .text-purple {
    color: #6f42c1 !important;
  }
</style>

<!-- Scripts -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
  // Chart Civil Acts
  const civilCtx = document.getElementById('civilActsChart').getContext('2d');
  const civilChart = new Chart(civilCtx, {
    type: 'doughnut',
    data: {
      labels: ['Naissances', 'Décès', 'Mariages'],
      datasets: [{
        data: [
          {{ $naissances->count() +  $naissancesD->count() }},
          {{ $deces->count() + $decesdeja->count() }},
          {{ $mariages->count() }}
        ],
        backgroundColor: [
          '#28a745',
          '#dc3545',
          '#6f42c1'
        ],
        borderWidth: 0
      }]
    },
    options: {
      cutout: '70%',
      plugins: {
        legend: {
          position: 'right',
          labels: {
            boxWidth: 12,
            padding: 20,
            usePointStyle: true
          }
        }
      }
    }
  });
  
  // Chart Hospital Acts
  const hospitalCtx = document.getElementById('hospitalActsChart').getContext('2d');
  const hospitalChart = new Chart(hospitalCtx, {
    type: 'bar',
    data: {
      labels: ['Naissances', 'Décès'],
      datasets: [{
        data: [{{ $naisshopsdash }}, {{ $deceshopsdash }}],
        backgroundColor: [
          '#0d6efd',
          '#dc3545'
        ],
        borderRadius: 8
      }]
    },
    options: {
      scales: {
        y: {
          beginAtZero: true,
          grid: {
            display: false
          }
        },
        x: {
          grid: {
            display: false
          }
        }
      },
      plugins: {
        legend: {
          display: false
        }
      }
    }
  });
  
  // Stats Modal Chart
  const statsCtx = document.getElementById('statsChart').getContext('2d');
  const statsChart = new Chart(statsCtx, {
    type: 'line',
    data: {
      labels: ['Jan', 'Fév', 'Mar', 'Avr', 'Mai', 'Jun', 'Jul', 'Aoû', 'Sep', 'Oct', 'Nov', 'Déc'],
      datasets: [
        {
          label: 'Naissances',
          data: [65, 59, 80, 81, 56, 55, 40, 30, 45, 60, 55, 70],
          borderColor: '#28a745',
          backgroundColor: 'rgba(40, 167, 69, 0.1)',
          tension: 0.3,
          fill: true
        },
        {
          label: 'Décès',
          data: [30, 25, 40, 35, 28, 32, 38, 25, 20, 30, 35, 40],
          borderColor: '#dc3545',
          backgroundColor: 'rgba(220, 53, 69, 0.1)',
          tension: 0.3,
          fill: true
        },
        {
          label: 'Mariages',
          data: [15, 20, 25, 30, 35, 40, 45, 40, 35, 30, 25, 20],
          borderColor: '#6f42c1',
          backgroundColor: 'rgba(111, 66, 193, 0.1)',
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
        }
      },
      scales: {
        y: {
          beginAtZero: true
        }
      }
    }
  });
});
</script>
@endsection