@extends('mairie.layouts.template')
@section('content')

<div class="container-fluid py-4">
    <!-- Filtres -->
   

    <!-- Statistiques principales -->
    <div class="row">
        <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
            <div class="card">
                <div class="card-header p-3 pt-2 bg-primary text-white">
                    <div class="icon icon-lg icon-shape bg-white shadow text-center border-radius-xl mt-n4 position-absolute">
                        <i class="fas fa-baby text-primary"></i>
                    </div>
                    <div class="text-end pt-1">
                        <p class="text-sm mb-0 text-white">Naissances</p>
                        <h4 class="mb-0">0</h4>
                    </div>
                </div>
                <div class="card-footer p-3">
                    <p class="mb-0">
                        <span class="text-success text-sm font-weight-bolder">40% </span>
                        du total
                    </p>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
            <div class="card">
                <div class="card-header p-3 pt-2 bg-danger text-white">
                    <div class="icon icon-lg icon-shape bg-white shadow text-center border-radius-xl mt-n4 position-absolute">
                        <i class="fas fa-cross text-danger"></i>
                    </div>
                    <div class="text-end pt-1">
                        <p class="text-sm mb-0 text-white">Décès</p>
                        <h4 class="mb-0">0</h4>
                    </div>
                </div>
                <div class="card-footer p-3">
                    <p class="mb-0">
                        <span class="text-success text-sm font-weight-bolder">50% </span>
                        du total
                    </p>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
            <div class="card">
                <div class="card-header p-3 pt-2 bg-success text-white">
                    <div class="icon icon-lg icon-shape bg-white shadow text-center border-radius-xl mt-n4 position-absolute">
                        <i class="fas fa-heart text-success"></i>
                    </div>
                    <div class="text-end pt-1">
                        <p class="text-sm mb-0 text-white">Mariages</p>
                        <h4 class="mb-0">0</h4>
                    </div>
                </div>
                <div class="card-footer p-3">
                    <p class="mb-0">60% </span>
                        du total
                    </p>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-sm-6">
            <div class="card">
                <div class="card-header p-3 pt-2 bg-info text-white">
                    <div class="icon icon-lg icon-shape bg-white shadow text-center border-radius-xl mt-n4 position-absolute">
                        <i class="fas fa-hospital text-info"></i>
                    </div>
                    <div class="text-end pt-1">
                        <p class="text-sm mb-0 text-white">Actes Hôpitaux</p>
                        <h4 class="mb-0">0</h4>
                    </div>
                </div>
                <div class="card-footer p-3">
                    <p class="mb-0">
                        <span class="text-success text-sm font-weight-bolder">25% </span>
                        du total
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Graphiques -->
    <div class="row mt-4">
        <div class="col-lg-6">
            <div class="card z-index-2">
                <div class="card-header">
                    <h5>Répartition des actes civils</h5>
                </div>
                <div class="card-body">
                    <canvas id="pieChart" height="300"></canvas>
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="card z-index-2">
                <div class="card-header">
                    <h5>Évolution mensuelle</h5>
                </div>
                <div class="card-body">
                    <canvas id="lineChart" height="300"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Derniers enregistrements -->
    <div class="row mt-4">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h5>Derniers enregistrements</h5>
                </div>
                <div class="card-body">
                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="naissances-tab" data-bs-toggle="tab" data-bs-target="#naissances" type="button" role="tab">Naissances</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="deces-tab" data-bs-toggle="tab" data-bs-target="#deces" type="button" role="tab">Décès</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="mariages-tab" data-bs-toggle="tab" data-bs-target="#mariages" type="button" role="tab">Mariages</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="hopitaux-tab" data-bs-toggle="tab" data-bs-target="#hopitaux" type="button" role="tab">Hôpitaux</button>
                        </li>
                    </ul>
                    <div class="tab-content" id="myTabContent">
                        <div class="tab-pane fade show active" id="naissances" role="tabpanel">
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Nom</th>
                                            <th>Prénom</th>
                                            <th>Date</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        {{-- @foreach($recentNaissances as $naissance)
                                        <tr>
                                            <td>{{ $naissance->id }}</td>
                                            <td>{{ $naissance->nom_enfant }}</td>
                                            <td>{{ $naissance->prenom_enfant }}</td>
                                            <td>{{ $naissance->date_naissance->format('d/m/Y') }}</td>
                                            <td>
                                                <button class="btn btn-sm btn-primary">Voir</button>
                                            </td>
                                        </tr>
                                        @endforeach
                                        @foreach($recentNaissancesd as $naissanced)
                                        <tr>
                                            <td>{{ $naissanced->id }}</td>
                                            <td>{{ $naissanced->nom_enfant }}</td>
                                            <td>{{ $naissanced->prenom_enfant }}</td>
                                            <td>{{ $naissanced->date_naissance->format('d/m/Y') }}</td>
                                            <td>
                                                <button class="btn btn-sm btn-primary">Voir</button>
                                            </td>
                                        </tr>
                                        @endforeach --}}
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="deces" role="tabpanel">
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Nom</th>
                                            <th>Prénom</th>
                                            <th>Date</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        {{-- @foreach($recentDeces as $deces)
                                        <tr>
                                            <td>{{ $deces->id }}</td>
                                            <td>{{ $deces->nom_defunt }}</td>
                                            <td>{{ $deces->prenom_defunt }}</td>
                                            <td>{{ $deces->date_deces->format('d/m/Y') }}</td>
                                            <td>
                                                <button class="btn btn-sm btn-primary">Voir</button>
                                            </td>
                                        </tr>
                                        @endforeach
                                        @foreach($recentDecesdeja as $decesdeja)
                                        <tr>
                                            <td>{{ $decesdeja->id }}</td>
                                            <td>{{ $decesdeja->nom_defunt }}</td>
                                            <td>{{ $decesdeja->prenom_defunt }}</td>
                                            <td>{{ $decesdeja->date_deces->format('d/m/Y') }}</td>
                                            <td>
                                                <button class="btn btn-sm btn-primary">Voir</button>
                                            </td>
                                        </tr>
                                        @endforeach --}}
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="mariages" role="tabpanel">
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Époux</th>
                                            <th>Épouse</th>
                                            <th>Date</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        {{-- @foreach($recentMariages as $mariage)
                                        <tr>
                                            <td>{{ $mariage->id }}</td>
                                            <td>{{ $mariage->nom_epoux }} {{ $mariage->prenom_epoux }}</td>
                                            <td>{{ $mariage->nom_epouse }} {{ $mariage->prenom_epouse }}</td>
                                            <td>{{ $mariage->date_mariage->format('d/m/Y') }}</td>
                                            <td>
                                                <button class="btn btn-sm btn-primary">Voir</button>
                                            </td>
                                        </tr> --}}
                                        {{-- @endforeach --}}
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="hopitaux" role="tabpanel">
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>Type</th>
                                            <th>Nom</th>
                                            <th>Prénom</th>
                                            <th>Date</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        {{-- @foreach($recentNaisshops as $naisshop)
                                        <tr>
                                            <td><span class="badge bg-primary">Naissance</span></td>
                                            <td>{{ $naisshop->nom_enfant }}</td>
                                            <td>{{ $naisshop->prenom_enfant }}</td>
                                            <td>{{ $naisshop->date_naissance->format('d/m/Y') }}</td>
                                            <td>
                                                <button class="btn btn-sm btn-primary">Voir</button>
                                            </td>
                                        </tr>
                                        @endforeach
                                        @foreach($recentDeceshops as $deceshop)
                                        <tr>
                                            <td><span class="badge bg-danger">Décès</span></td>
                                            <td>{{ $deceshop->nom_defunt }}</td>
                                            <td>{{ $deceshop->prenom_defunt }}</td>
                                            <td>{{ $deceshop->date_deces->format('d/m/Y') }}</td>
                                            <td>
                                                <button class="btn btn-sm btn-primary">Voir</button>
                                            </td>
                                        </tr> --}}
                                        {{-- @endforeach --}}
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
{{-- <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Pie Chart - Répartition des actes
    const pieCtx = document.getElementById('pieChart').getContext('2d');
    const pieChart = new Chart(pieCtx, {
        type: 'pie',
        data: {
            labels: ['Naissances', 'Naissances Déjà', 'Décès', 'Décès Déjà', 'Mariages'],
            datasets: [{
                data: [
                    {{ $naissances->count() }},
                    {{ $naissancesD->count() }},
                    {{ $deces->count() }},
                    {{ $decesdeja->count() }},
                    {{ $mariages->count() }}
                ],
                backgroundColor: [
                    '#4e73df',
                    '#1cc88a',
                    '#e74a3b',
                    '#f6c23e',
                    '#36b9cc'
                ],
                hoverBackgroundColor: [
                    '#2e59d9',
                    '#17a673',
                    '#be2617',
                    '#dda20a',
                    '#2c9faf'
                ],
                hoverBorderColor: "rgba(234, 236, 244, 1)",
            }],
        },
        options: {
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'right',
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            let label = context.label || '';
                            let value = context.raw || 0;
                            let total = context.dataset.data.reduce((a, b) => a + b, 0);
                            let percentage = Math.round((value / total) * 100);
                            return `${label}: ${value} (${percentage}%)`;
                        }
                    }
                }
            }
        }
    });

    // Line Chart - Évolution mensuelle
    const lineCtx = document.getElementById('lineChart').getContext('2d');
    const lineChart = new Chart(lineCtx, {
        type: 'line',
        data: {
            labels: ['Jan', 'Fév', 'Mar', 'Avr', 'Mai', 'Jun', 'Jul', 'Aoû', 'Sep', 'Oct', 'Nov', 'Déc'],
            datasets: [
                {
                    label: "Naissances",
                    backgroundColor: "rgba(78, 115, 223, 0.05)",
                    borderColor: "rgba(78, 115, 223, 1)",
                    pointRadius: 3,
                    pointBackgroundColor: "rgba(78, 115, 223, 1)",
                    pointBorderColor: "rgba(78, 115, 223, 1)",
                    pointHoverRadius: 3,
                    pointHoverBackgroundColor: "rgba(78, 115, 223, 1)",
                    pointHoverBorderColor: "rgba(78, 115, 223, 1)",
                    pointHitRadius: 10,
                    pointBorderWidth: 2,
                    data: [65, 59, 80, 81, 56, 55, 40, 30, 45, 60, 55, 70],
                },
                {
                    label: "Décès",
                    backgroundColor: "rgba(231, 74, 59, 0.05)",
                    borderColor: "rgba(231, 74, 59, 1)",
                    pointRadius: 3,
                    pointBackgroundColor: "rgba(231, 74, 59, 1)",
                    pointBorderColor: "rgba(231, 74, 59, 1)",
                    pointHoverRadius: 3,
                    pointHoverBackgroundColor: "rgba(231, 74, 59, 1)",
                    pointHoverBorderColor: "rgba(231, 74, 59, 1)",
                    pointHitRadius: 10,
                    pointBorderWidth: 2,
                    data: [30, 25, 40, 35, 28, 32, 38, 25, 20, 30, 35, 40],
                },
                {
                    label: "Mariages",
                    backgroundColor: "rgba(54, 185, 204, 0.05)",
                    borderColor: "rgba(54, 185, 204, 1)",
                    pointRadius: 3,
                    pointBackgroundColor: "rgba(54, 185, 204, 1)",
                    pointBorderColor: "rgba(54, 185, 204, 1)",
                    pointHoverRadius: 3,
                    pointHoverBackgroundColor: "rgba(54, 185, 204, 1)",
                    pointHoverBorderColor: "rgba(54, 185, 204, 1)",
                    pointHitRadius: 10,
                    pointBorderWidth: 2,
                    data: [15, 20, 25, 30, 35, 40, 45, 40, 35, 30, 25, 20],
                },
            ],
        },
        options: {
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        callback: function(value) {
                            return value;
                        }
                    }
                }
            },
            plugins: {
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            return context.dataset.label + ': ' + context.raw;
                        }
                    }
                }
            }
        }
    });
</script> --}}

@endsection