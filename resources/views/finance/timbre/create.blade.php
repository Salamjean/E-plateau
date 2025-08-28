@extends('finance.layouts.template')
@section('content')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<div class="container-fluid py-4">
    <div class="row">
        <!-- Carte principale -->
        <div class="col-12">
            <div class="card card-modern mb-4">
                <div class="card-header">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <h5 class="mb-0">Vente de Timbres</h5>
                            <p class="text-sm mb-0">Vendez des timbres depuis votre stock</p>
                        </div>
                        <div class="header-icon">
                            <i class="fas fa-stamp"></i>
                        </div>
                    </div>
                </div>
                
                <div class="card-body">
                    <div class="row">
                        <!-- Colonne de formulaire et historique -->
                        <div class="col-lg-8">
                            <div class="row">
                                <!-- Formulaire de vente -->
                                <div class="col-md-7">
                                    <div class="form-section">
                                        <form id="venteForm" action="{{ route('finance.timbre.storeVente') }}" method="POST">
                                            @csrf
                                            <div class="form-group">
                                                <label for="nombre_timbre">Nombre de timbres à vendre</label>
                                                <div class="input-with-icon">
                                                    <i class="fas fa-stamp"></i>
                                                    <input type="number" 
                                                           id="nombre_timbre" 
                                                           name="nombre_timbre" 
                                                           min="1" 
                                                           step="1"
                                                           required 
                                                           placeholder="Entrez le nombre de timbres"
                                                           value="{{ old('nombre_timbre') }}">
                                                </div>
                                                <div class="form-note">1 timbre = 500 FCFA</div>
                                                @error('nombre_timbre')
                                                    <div class="error-text">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            
                                            <!-- Affichage du montant calculé -->
                                            <div class="amount-card">
                                                <div class="amount-label">Montant total:</div>
                                                <div class="amount-value" id="montantTotal">0 FCFA</div>
                                            </div>
                                            
                                            <button type="submit" class="btn-primary full-width">
                                                <i class="fas fa-cash-register me-2"></i> Valider la vente
                                            </button>
                                        </form>
                                    </div>
                                </div>
                                
                                <!-- Graphique circulaire -->
                                <div class="col-md-5">
                                    <div class="chart-card">
                                        <h6>Répartition des ventes</h6>
                                        <div class="chart-container">
                                            <canvas id="ventesChart" width="200" height="100"></canvas>
                                        </div>
                                        <div class="chart-legend">
                                            <div class="legend-item">
                                                <span class="color-dot" style="background-color: #4361ee;"></span>
                                                <span>Ventes aujourd'hui: <span id="ventesAujourdhui">0</span></span>
                                            </div>
                                            <div class="legend-item">
                                                <span class="color-dot" style="background-color: #3a0ca3;"></span>
                                                <span>Ventes cette semaine: <span id="ventesSemaine">0</span></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            
                            
                            <!-- Dernières ventes -->
                            <div class="row mt-4">
                                <div class="col-12">
                                    <div class="section-title">
                                        <h6>Dernières ventes</h6>
                                        <a href="#" class="view-all">Voir tout</a>
                                    </div>
                                    <div class="sales-list">
                                        @forelse($dernieres_ventes as $vente)
                                        <div class="sale-item">
                                            <div class="sale-info">
                                                <div class="sale-date">
                                                    <div class="date">{{ $vente->created_at->format('d M') }}</div>
                                                    <div class="time">{{ $vente->created_at->format('H:i') }}</div>
                                                </div>
                                                <div class="sale-details">
                                                    <div class="quantity">{{ number_format(abs($vente->nombre_timbre), 0, ',', ' ') }} timbres</div>
                                                    <div class="amount">{{ number_format(abs($vente->nombre_timbre) * 500, 0, ',', ' ') }} FCFA</div>
                                                </div>
                                            </div>
                                            <div class="sale-status completed">
                                                <i class="fas fa-check-circle"></i>
                                            </div>
                                        </div>
                                        @empty
                                        <div class="empty-state">
                                            <i class="fas fa-inbox"></i>
                                            <p>Aucune vente effectuée</p>
                                        </div>
                                        @endforelse
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Colonne de statistiques -->
                        <div class="col-lg-4">
                            <!-- Carte de stock -->
                            <div class="stats-card primary">
                                <div class="stats-icon">
                                    <i class="fas fa-stamp"></i>
                                </div>
                                <div class="stats-content">
                                    <div class="stats-label">Stock actuel de timbres</div>
                                    <div class="stats-value">{{ number_format($solde_timbres, 0, ',', ' ') }}</div>
                                    <div class="stats-note">Timbre(s) disponible(s)</div>
                                </div>
                            </div>
                            
                           
                            
                            <!-- Statistiques de vente -->
                            <div class="stats-card">
                                <h6>Statistiques de vente</h6>
                                <div class="stats-grid">
                                    <div class="stat-item">
                                        <div class="stat-value">{{ number_format($ventes_aujourdhui, 0, ',', ' ') }}</div>
                                        <div class="stat-label">Ventes aujourd'hui</div>
                                    </div>
                                    <div class="stat-item">
                                        <div class="stat-value">{{ number_format($ventes_semaine, 0, ',', ' ') }}</div>
                                        <div class="stat-label">Ventes cette semaine</div>
                                    </div>
                                    <div class="stat-item">
                                        <div class="stat-value">{{ number_format($ventes_mois, 0, ',', ' ') }}</div>
                                        <div class="stat-label">Ventes ce mois</div>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Objectifs -->
                            <div class="stats-card">
                                <h6>Objectif du mois</h6>
                                <div class="progress-container">
                                    <div class="progress-info">
                                        <span id="progressPercent">0%</span>
                                        <span id="progressText">0/0 timbres</span>
                                    </div>
                                    <div class="progress-bar">
                                        <div class="progress-fill" id="progressFill" style="width: 0%"></div>
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

<!-- Inclure Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<style>
    /* Styles CSS identiques à la version précédente */
    :root {
        --primary: #0033c4;
        --primary-light: #3d5afe;
        --primary-dark: #002493;
        --secondary: #6c757d;
        --success: #28a745;
        --info: #17a2b8;
        --warning: #ffc107;
        --danger: #dc3545;
        --light: #f8f9fa;
        --dark: #212529;
        --gray-100: #f8f9fa;
        --gray-200: #e9ecef;
        --gray-300: #dee2e6;
        --gray-800: #343a40;
        --card-shadow: 0 4px 20px rgba(0, 51, 196, 0.1);
        --transition: all 0.3s ease;
    }
    
    body {
        background-color: #f5f7ff;
        color: #2d3748;
        font-family: 'Inter', 'Segoe UI', system-ui, -apple-system, sans-serif;
    }
    
    .card-modern {
        border: none;
        border-radius: 16px;
        box-shadow: var(--card-shadow);
        background: #ffffff;
        overflow: hidden;
    }
    
    .card-header {
        padding: 1.5rem;
        background: transparent;
        border-bottom: 1px solid var(--gray-200);
    }
    
    .card-header h5 {
        font-weight: 700;
        color: var(--primary-dark);
        margin-bottom: 0.25rem;
    }
    
    .card-header p {
        color: var(--secondary);
        font-size: 0.875rem;
        margin-bottom: 0;
    }
    
    .header-icon {
        width: 48px;
        height: 48px;
        border-radius: 12px;
        background: rgba(0, 51, 196, 0.1);
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--primary);
        font-size: 1.25rem;
    }
    
    .card-body {
        padding: 1.5rem;
    }
    
    .form-section {
        background: var(--gray-100);
        border-radius: 12px;
        padding: 1.5rem;
    }
    
    .form-group {
        margin-bottom: 1.5rem;
    }
    
    .form-group label {
        font-weight: 600;
        margin-bottom: 0.5rem;
        display: block;
        color: var(--gray-800);
    }
    
    .input-with-icon {
        position: relative;
    }
    
    .input-with-icon i {
        position: absolute;
        left: 1rem;
        top: 50%;
        transform: translateY(-50%);
        color: var(--primary);
        z-index: 1;
    }
    
    .input-with-icon input {
        width: 100%;
        padding: 0.875rem 1rem 0.875rem 2.75rem;
        border-radius: 10px;
        border: 1px solid var(--gray-300);
        background: #ffffff;
        font-size: 1rem;
        transition: var(--transition);
    }
    
    .input-with-icon input:focus {
        border-color: var(--primary);
        box-shadow: 0 0 0 3px rgba(0, 51, 196, 0.2);
        outline: none;
    }
    
    .form-note {
        font-size: 0.875rem;
        color: var(--secondary);
        margin-top: 0.5rem;
    }
    
    .error-text {
        color: var(--danger);
        font-size: 0.875rem;
        margin-top: 0.5rem;
    }
    
    .amount-card {
        background: rgba(0, 51, 196, 0.05);
        border-radius: 10px;
        padding: 1rem;
        margin-bottom: 1.5rem;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    
    .amount-label {
        font-weight: 600;
        color: var(--gray-800);
    }
    
    .amount-value {
        font-weight: 700;
        font-size: 1.25rem;
        color: var(--primary);
    }
    
    .btn-primary {
        background: var(--primary);
        color: white;
        border: none;
        border-radius: 10px;
        padding: 1rem 1.5rem;
        font-weight: 600;
        width: 100%;
        transition: var(--transition);
        display: flex;
        align-items: center;
        justify-content: center;
    }
    
    .btn-primary:hover {
        background: var(--primary-dark);
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0, 51, 196, 0.3);
    }
    
    .full-width {
        width: 100%;
    }
    
    .chart-card {
        background: #ffffff;
        border-radius: 12px;
        padding: 1.5rem;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        height: 100%;
    }
    
    .chart-card h6 {
        font-weight: 600;
        margin-bottom: 1rem;
        color: var(--gray-800);
    }
    
    .chart-container {
        position: relative;
        height: 200px;
    }
    
    .chart-legend {
        margin-top: 1rem;
    }
    
    .legend-item {
        display: flex;
        align-items: center;
        margin-bottom: 0.5rem;
        font-size: 0.875rem;
    }
    
    .color-dot {
        width: 12px;
        height: 12px;
        border-radius: 50%;
        margin-right: 0.5rem;
    }
    
    .chart-filter select {
        border: 1px solid var(--gray-300);
        border-radius: 6px;
        padding: 0.25rem 0.5rem;
        font-size: 0.875rem;
    }
    
    .section-title {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1rem;
    }
    
    .section-title h6 {
        font-weight: 600;
        margin-bottom: 0;
        color: var(--gray-800);
    }
    
    .view-all {
        font-size: 0.875rem;
        color: var(--primary);
        text-decoration: none;
    }
    
    .sales-list {
        background: #ffffff;
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
    }
    
    .sale-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 1rem 1.5rem;
        border-bottom: 1px solid var(--gray-200);
    }
    
    .sale-item:last-child {
        border-bottom: none;
    }
    
    .sale-info {
        display: flex;
        align-items: center;
    }
    
    .sale-date {
        margin-right: 1rem;
        text-align: center;
    }
    
    .date {
        font-weight: 600;
        color: var(--gray-800);
    }
    
    .time {
        font-size: 0.75rem;
        color: var(--secondary);
    }
    
    .sale-details {
        display: flex;
        flex-direction: column;
    }
    
    .quantity {
        font-weight: 600;
        color: var(--primary);
    }
    
    .amount {
        font-size: 0.875rem;
        color: var(--success);
    }
    
    .sale-status {
        color: var(--success);
    }
    
    .empty-state {
        padding: 2rem;
        text-align: center;
        color: var(--secondary);
    }
    
    .empty-state i {
        font-size: 2rem;
        margin-bottom: 0.5rem;
        opacity: 0.5;
    }
    
    .stats-card {
        background: #ffffff;
        border-radius: 12px;
        padding: 1.5rem;
        margin-bottom: 1.5rem;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
    }
    
    .stats-card.primary {
        background: linear-gradient(135deg, var(--primary) 0%, var(--primary-light) 100%);
        color: white;
    }
    
    .stats-card.secondary {
        background: linear-gradient(135deg, #6c757d 0%, #495057 100%);
        color: white;
    }
    
    .stats-card h6 {
        font-weight: 600;
        margin-bottom: 1rem;
        color: var(--gray-800);
    }
    
    .stats-card.primary h6,
    .stats-card.secondary h6 {
        color: white;
    }
    
    .stats-icon {
        width: 48px;
        height: 48px;
        border-radius: 10px;
        background: rgba(255, 255, 255, 0.2);
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 1rem;
        font-size: 1.25rem;
    }
    
    .stats-content {
        text-align: center;
    }
    
    .stats-label {
        font-size: 0.875rem;
        margin-bottom: 0.5rem;
        opacity: 0.9;
    }
    
    .stats-value {
        font-weight: 700;
        font-size: 1.75rem;
        margin-bottom: 0.5rem;
    }
    
    .stats-note {
        font-size: 0.75rem;
        opacity: 0.8;
    }
    
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 1rem;
    }
    
    .stat-item {
        text-align: center;
    }
    
    .stat-value {
        font-weight: 700;
        font-size: 1.25rem;
        color: var(--primary);
    }
    
    .stat-label {
        font-size: 0.75rem;
        color: var(--secondary);
    }
    
    .progress-container {
        margin-top: 1rem;
    }
    
    .progress-info {
        display: flex;
        justify-content: space-between;
        margin-bottom: 0.5rem;
        font-size: 0.875rem;
    }
    
    .progress-bar {
        height: 8px;
        background: var(--gray-200);
        border-radius: 4px;
        overflow: hidden;
    }
    
    .progress-fill {
        height: 100%;
        background: linear-gradient(135deg, var(--primary) 0%, var(--primary-light) 100%);
        border-radius: 4px;
        transition: width 0.5s ease;
    }
    
    @media (max-width: 992px) {
        .chart-card {
            margin-top: 1.5rem;
        }
    }
    
    @media (max-width: 768px) {
        .card-header {
            flex-direction: column;
            align-items: flex-start;
        }
        
        .header-icon {
            margin-top: 1rem;
        }
        
        .stats-grid {
            grid-template-columns: repeat(2, 1fr);
        }
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.getElementById('venteForm');
        const input = document.getElementById('nombre_timbre');
        const montantTotal = document.getElementById('montantTotal');
        const soldeActuel = {{ $solde_timbres }};
        const prixUnitaire = 500;
        
        // Fonction pour calculer et afficher le montant
        function calculerMontant() {
            const quantite = parseInt(input.value) || 0;
            const total = quantite * prixUnitaire;
            montantTotal.textContent = new Intl.NumberFormat('fr-FR').format(total) + ' FCFA';
        }
        
        // Calcul initial
        calculerMontant();
        
        // Écouter les changements sur l'input
        input.addEventListener('input', function() {
            calculerMontant();
            
            const valeur = parseInt(this.value) || 0;
            if (valeur < 1) {
                this.setCustomValidity('Veuillez entrer un nombre valide de timbres (min: 1)');
            } else if (valeur > soldeActuel) {
                this.setCustomValidity('Stock insuffisant. Maximum: ' + soldeActuel);
            } else {
                this.setCustomValidity('');
            }
        });
        
        // Initialiser les graphiques avec des données dynamiques
        initCharts();
        
        // Afficher les messages de session avec SweetAlert2
        @if(session('success'))
        Swal.fire({
            icon: 'success',
            title: 'Vente réussie !',
            text: '{{ session('success') }}',
            confirmButtonColor: '#0033c4',
            confirmButtonText: 'OK'
        });
        @endif

        @if(session('error'))
        Swal.fire({
            icon: 'error',
            title: 'Erreur !',
            text: '{{ session('error') }}',
            confirmButtonColor: '#0033c4',
            confirmButtonText: 'OK'
        });
        @endif
        
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const nombreTimbre = parseInt(input.value) || 0;
            const montant = nombreTimbre * prixUnitaire;
            
            if (nombreTimbre < 1) {
                showNotification('Veuillez entrer un nombre valide de timbres (min: 1)', 'danger');
                return;
            }
            
            if (nombreTimbre > soldeActuel) {
                showNotification('Stock insuffisant. Maximum: ' + soldeActuel, 'danger');
                return;
            }
            
            // Confirmation stylisée avec le montant
            Swal.fire({
                title: 'Confirmer la vente',
                html: `Êtes-vous sûr de vouloir vendre <b>${nombreTimbre}</b> timbre(s) ?<br>
                      <strong>Montant: ${new Intl.NumberFormat('fr-FR').format(montant)} FCFA</strong><br>
                      <small>Stock après vente: ${soldeActuel - nombreTimbre} timbres</small>`,
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#0033c4',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Oui, vendre',
                cancelButtonText: 'Annuler'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Animation de chargement
                    Swal.fire({
                        title: 'Traitement en cours...',
                        text: 'Veuillez patienter',
                        allowOutsideClick: false,
                        didOpen: () => {
                            Swal.showLoading()
                        }
                    });
                    
                    // Soumission du formulaire
                    form.submit();
                }
            });
        });
        
        function showNotification(message, type) {
            Swal.fire({
                icon: type === 'danger' ? 'error' : 'warning',
                title: 'Attention',
                text: message,
                confirmButtonColor: '#0033c4',
                confirmButtonText: 'OK'
            });
        }
        
        function initCharts() {
            // Récupérer les données dynamiques via AJAX
            fetch('/finance/timbre/statistiques')
                .then(response => response.json())
                .then(data => {
                    // Mettre à jour les statistiques dans le graphique circulaire
                    document.getElementById('ventesAujourdhui').textContent = data.ventesAujourdhui;
                    document.getElementById('ventesSemaine').textContent = data.ventesSemaine;
                    
                    // Mettre à jour la barre de progression
                    const progressPercent = Math.min(100, Math.round((data.ventesMois / data.objectifMois) * 100));
                    document.getElementById('progressPercent').textContent = progressPercent + '%';
                    document.getElementById('progressText').textContent = data.ventesMois + '/' + data.objectifMois + ' timbres';
                    document.getElementById('progressFill').style.width = progressPercent + '%';
                    
                    // Graphique circulaire (répartition des ventes)
                    const ventesCtx = document.getElementById('ventesChart').getContext('2d');
                    const ventesChart = new Chart(ventesCtx, {
                        type: 'doughnut',
                        data: {
                            labels: ['Ventes aujourd\'hui', 'Ventes cette semaine'],
                            datasets: [{
                                data: [data.ventesAujourdhui, data.ventesSemaine - data.ventesAujourdhui],
                                backgroundColor: ['#4361ee', '#3a0ca3'],
                                borderWidth: 0,
                                borderRadius: 6
                            }]
                        },
                        options: {
                            cutout: '70%',
                            plugins: {
                                legend: {
                                    display: false
                                }
                            },
                            animation: {
                                animateScale: true,
                                animateRotate: true
                            }
                        }
                    });
                    
                    // Graphique de tendance des ventes
                    const salesTrendCtx = document.getElementById('salesTrendChart').getContext('2d');
                    const salesTrendChart = new Chart(salesTrendCtx, {
                        type: 'line',
                        data: {
                            labels: data.tendanceVentes.labels,
                            datasets: [{
                                label: 'Ventes journalières',
                                data: data.tendanceVentes.valeurs,
                                borderColor: '#0033c4',
                                backgroundColor: 'rgba(0, 51, 196, 0.1)',
                                borderWidth: 3,
                                tension: 0.3,
                                fill: true,
                                pointBackgroundColor: '#ffffff',
                                pointBorderColor: '#0033c4',
                                pointBorderWidth: 2,
                                pointRadius: 4,
                                pointHoverRadius: 6
                            }]
                        },
                        options: {
                            scales: {
                                y: {
                                    beginAtZero: true,
                                    grid: {
                                        drawBorder: false
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
                    
                    // Changer la plage du graphique
                    document.getElementById('chartRange').addEventListener('change', function() {
                        const days = parseInt(this.value);
                        
                        fetch('/finance/timbre/tendance-ventes?jours=' + days)
                            .then(response => response.json())
                            .then(tendanceData => {
                                salesTrendChart.data.labels = tendanceData.labels;
                                salesTrendChart.data.datasets[0].data = tendanceData.valeurs;
                                salesTrendChart.update();
                            });
                    });
                })
                .catch(error => {
                    console.error('Erreur lors du chargement des statistiques:', error);
                    
                    // Valeurs par défaut en cas d'erreur
                    const ventesAujourdhui = {{ $ventes_aujourdhui }};
                    const ventesSemaine = {{ $ventes_semaine }};
                    const ventesMois = {{ $ventes_mois }};
                    
                    document.getElementById('ventesAujourdhui').textContent = ventesAujourdhui;
                    document.getElementById('ventesSemaine').textContent = ventesSemaine;
                    
                    // Mettre à jour la barre de progression même en cas d'erreur
                    const objectifMois = 2000; // Valeur par défaut
                    const progressPercent = Math.min(100, Math.round((ventesMois / objectifMois) * 100));
                    document.getElementById('progressPercent').textContent = progressPercent + '%';
                    document.getElementById('progressText').textContent = ventesMois + '/' + objectifMois + ' timbres';
                    document.getElementById('progressFill').style.width = progressPercent + '%';
                });
        }
    });
</script>
@endsection