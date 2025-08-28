@extends('caisse.layouts.template')
@section('content')
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rechargement de Timbre</title>
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary: #0033c4;
            --primary-light: #3d5afe;
            --primary-gradient: linear-gradient(135deg, var(--primary) 0%, var(--primary-light) 100%);
            --secondary: #6c757d;
            --success: #198754;
            --danger: #dc3545;
            --warning: #ffc107;
            --light: #f8f9fa;
            --dark: #212529;
            --glass-bg: rgba(255, 255, 255, 0.95);
            --glass-border: rgba(255, 255, 255, 0.2);
            --border-radius: 12px;
            --box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
            --transition: all 0.3s ease;
        }
        
        body {
            background: #f8f9fa;
            font-family: 'Inter', 'Segoe UI', sans-serif;
            color: #495057;
        }
        
        .card-glass {
            background: var(--glass-bg);
            backdrop-filter: blur(10px);
            border: 1px solid var(--glass-border);
            border-radius: var(--border-radius);
            overflow: hidden;
            box-shadow: var(--box-shadow);
            transition: var(--transition);
        }
        
        .card-glass:hover {
            box-shadow: 0 12px 40px rgba(0, 0, 0, 0.15);
        }
        
        .text-gradient {
            background: var(--primary-gradient);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            font-weight: 700;
        }
        
        .bg-gradient-primary {
            background: var(--primary-gradient) !important;
        }
        
        .btn {
            border-radius: var(--border-radius);
            font-weight: 600;
            transition: var(--transition);
            padding: 0.75rem 1.5rem;
        }
        
        .btn-primary {
            background: var(--primary-gradient);
            border: none;
        }
        
        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 7px 14px rgba(0, 0, 0, 0.1);
        }
        
        .input-group {
            border-radius: var(--border-radius);
            transition: var(--transition);
            background: #fff;
            border: 1px solid #e2e8f0;
            overflow: hidden;
        }
        
        .input-group:focus-within {
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.08);
            border-color: var(--primary);
        }
        
        .input-group-text {
            background: transparent;
            border: none;
            color: var(--secondary);
        }
        
        .form-control {
            border: none;
            background: transparent;
            box-shadow: none;
            padding: 1rem 0.75rem;
            font-weight: 500;
        }
        
        .form-control:focus {
            box-shadow: none;
            background: transparent;
        }
        
        .icon-shape {
            width: 48px;
            height: 48px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: var(--border-radius);
        }
        
        .stats-card {
            background: #ffffff;
            border-radius: var(--border-radius);
            padding: 1.5rem;
            margin-bottom: 1.5rem;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
            transition: var(--transition);
        }
        
        .stats-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
        }
        
        .stats-card.primary {
            background: var(--primary-gradient);
            color: white;
        }
        
        .stats-card.secondary {
            background: linear-gradient(135deg, #6c757d 0%, #495057 100%);
            color: white;
        }
        
        .stats-icon {
            font-size: 1.75rem;
            margin-bottom: 1rem;
        }
        
        .stats-value {
            font-size: 1.5rem;
            font-weight: 700;
            margin: 0.5rem 0;
        }
        
        .stats-label {
            font-size: 0.875rem;
            opacity: 0.9;
            margin-bottom: 0.5rem;
        }
        
        .table th {
            border-bottom: none;
            font-size: 0.75rem;
            text-transform: uppercase;
            font-weight: 700;
            color: var(--secondary);
        }
        
        .table td {
            border-bottom: 1px solid #f1f1f1;
            vertical-align: middle;
        }
        
        .alert-notification {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 9999;
            min-width: 300px;
            border-radius: var(--border-radius);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            animation: slideInRight 0.3s ease;
        }
        
        @keyframes slideInRight {
            from {
                transform: translateX(100%);
                opacity: 0;
            }
            to {
                transform: translateX(0);
                opacity: 1;
            }
        }
        
        .cost-estimator {
            background: rgba(0, 51, 196, 0.05);
            border-radius: var(--border-radius);
            padding: 1rem;
            margin-top: 1rem;
            border-left: 4px solid var(--primary);
        }
        
        .fade-in {
            animation: fadeIn 0.5s ease;
        }
        
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        @media (max-width: 768px) {
            .display-3 {
                font-size: 2.5rem;
            }
            
            .stats-card {
                padding: 1rem;
            }
            
            .stats-value {
                font-size: 1.25rem;
            }
        }
    </style>
</head>
<body>
<div class="container-fluid py-4">
    <!-- Notifications -->
    @if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show alert-notification" role="alert">
        <div class="d-flex align-items-center">
            <i class="fas fa-exclamation-circle me-2"></i>
            <strong>{{ session('error') }}</strong>
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show alert-notification" role="alert">
        <div class="d-flex align-items-center">
            <i class="fas fa-check-circle me-2"></i>
            <strong>{{ session('success') }}</strong>
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    <div class="row">
        <div class="col-12">
            <div class="card card-glass mb-4 fade-in">
                <div class="card-header d-flex align-items-center justify-content-between p-4 pb-2">
                    <div>
                        <h5 class="text-gradient text-primary mb-0">Rechargement de Timbre</h5>
                        <p class="mb-0 text-sm">Ajoutez des timbres à votre compte</p>
                    </div>
                    <div class="icon-shape icon-lg bg-gradient-primary shadow text-center border-radius-md">
                        <i class="fas fa-stamp text-white opacity-10"></i>
                    </div>
                </div>
                
                <div class="card-body p-4">
                    <div class="row">
                        <div class="col-lg-7">
                            <form id="rechargeForm" action="{{ route('caisse.timbre.store') }}" method="POST">
                                @csrf
                                <div class="form-group mb-4">
                                    <label for="nombre_timbre" class="form-label mb-2 fw-bold">Nombre de timbres à ajouter</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-transparent"><i class="fas fa-stamp text-primary"></i></span>
                                        <input type="number" 
                                               class="form-control" 
                                               id="nombre_timbre" 
                                               name="nombre_timbre" 
                                               min="1" 
                                               step="1"
                                               required
                                               placeholder="Entrez le nombre de timbres"
                                               value="{{ old('nombre_timbre') }}">
                                    </div>
                                    <div class="form-text text-xs ms-2">Entrez un nombre positif de timbres à ajouter</div>
                                    @error('nombre_timbre')
                                        <div class="text-danger text-xs mt-1">{{ $message }}</div>
                                    @enderror
                                    
                                    <!-- Cost Estimator -->
                                    <div class="cost-estimator mt-3">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <span class="text-sm">Coût estimé:</span>
                                            <span class="fw-bold" id="cost-estimation">0 FCFA</span>
                                        </div>
                                        <div class="progress mt-2" style="height: 5px;">
                                            <div class="progress-bar bg-primary" role="progressbar" id="cost-progress" style="width: 0%" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                        <div class="text-xs text-muted mt-1">Prix unitaire: 500 FCFA</div>
                                    </div>
                                </div>
                                
                                <div class="button-row d-flex mt-4">
                                    <button type="submit" class="btn btn-primary btn-lg w-100">
                                        <i class="fas fa-plus-circle me-2"></i> Ajouter les timbres
                                    </button>
                                </div>
                            </form>
                            
                            <div class="mt-5">
                                <h6 class="mb-3 fw-bold">Dernières recharges</h6>
                                <div class="table-responsive">
                                    <table class="table align-items-center mb-0">
                                        <thead>
                                            <tr>
                                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Date</th>
                                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Quantité</th>
                                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Coût</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse($dernieres_recharges as $recharge)
                                            <tr class="fade-in">
                                                <td>
                                                    <div class="d-flex px-2 py-1">
                                                        <div class="d-flex flex-column justify-content-center">
                                                            <h6 class="mb-0 text-sm">{{ $recharge->created_at->format('d M Y') }}</h6>
                                                            <p class="text-xs text-secondary mb-0">{{ $recharge->created_at->format('H:i') }}</p>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <span class="text-success text-xs font-weight-bold">+ {{ number_format($recharge->nombre_timbre, 0, ',', ' ') }}</span>
                                                </td>
                                                <td>
                                                    <span class="text-dark text-xs font-weight-bold">{{ number_format($recharge->nombre_timbre * 500, 0, ',', ' ') }} FCFA</span>
                                                </td>
                                            </tr>
                                            @empty
                                            <tr>
                                                <td colspan="3" class="text-center py-4">
                                                    <div class="text-muted">
                                                        <i class="fas fa-inbox fa-2x mb-2"></i>
                                                        <p>Aucune recharge effectuée</p>
                                                    </div>
                                                </td>
                                            </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-lg-5 mt-4 mt-lg-0">
                            <!-- Solde de timbres -->
                            <div class="stats-card primary mb-4 fade-in">
                                <div class="stats-icon">
                                    <i class="fas fa-stamp"></i>
                                </div>
                                <div class="stats-content">
                                    <div class="stats-label">Solde actuel de timbres</div>
                                    <div class="stats-value">{{ number_format($solde_timbres, 0, ',', ' ') }}</div>
                                    <div class="stats-footer">
                                        <span class="badge bg-light text-dark">
                                            <i class="fas fa-sync-alt me-1"></i> Timbres disponibles
                                        </span>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Valeur du stock -->
                            <div class="stats-card secondary fade-in">
                                <div class="stats-icon">
                                    <i class="fas fa-coins"></i>
                                </div>
                                <div class="stats-content">
                                    <div class="stats-label">Valeur totale du stock</div>
                                    <div class="stats-value">{{ number_format($solde_timbres * 500, 0, ',', ' ') }} FCFA</div>
                                    <div class="stats-footer">
                                        <span class="badge bg-light text-dark">
                                            <i class="fas fa-tag me-1"></i> 500 FCFA par timbre
                                        </span>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Statistiques de recharge -->
                            <div class="stats-card fade-in">
                                <div class="stats-icon text-primary">
                                    <i class="fas fa-chart-line"></i>
                                </div>
                                <div class="stats-content">
                                    <div class="stats-label">Recharges ce mois</div>
                                    <div class="stats-value">
                                        {{ number_format($dernieres_recharges->where('created_at', '>=', now()->startOfMonth())->sum('nombre_timbre'), 0, ',', ' ') }}
                                    </div>
                                    <div class="stats-footer">
                                        <span class="text-sm text-muted">
                                            <i class="fas fa-history me-1"></i> Total des ajouts mensuels
                                        </span>
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

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.getElementById('rechargeForm');
        const input = document.getElementById('nombre_timbre');
        const costEstimation = document.getElementById('cost-estimation');
        const costProgress = document.getElementById('cost-progress');
        
        // Afficher les messages de session avec SweetAlert2
        @if(session('success'))
        Swal.fire({
            icon: 'success',
            title: 'Succès !',
            text: '{{ session('success') }}',
            confirmButtonColor: '#0033c4',
            confirmButtonText: 'OK',
            customClass: {
                popup: 'border-radius-lg'
            }
        });
        @endif

        @if(session('error'))
        Swal.fire({
            icon: 'error',
            title: 'Erreur !',
            text: '{{ session('error') }}',
            confirmButtonColor: '#dc3545',
            confirmButtonText: 'OK',
            customClass: {
                popup: 'border-radius-lg'
            }
        });
        @endif

        // Mise à jour de l'estimation du coût en temps réel
        input.addEventListener('input', function() {
            const value = parseInt(this.value) || 0;
            const cost = value * 500;
            
            // Mettre à jour l'estimation du coût
            costEstimation.textContent = new Intl.NumberFormat('fr-FR').format(cost) + ' FCFA';
            
            // Mettre à jour la barre de progression (limite à 10000 timbres pour 100%)
            const progress = Math.min((value / 10000) * 100, 100);
            costProgress.style.width = `${progress}%`;
            costProgress.setAttribute('aria-valuenow', progress);
            
            // Validation
            if (value < 1) {
                this.setCustomValidity('Veuillez entrer un nombre valide de timbres (min: 1)');
                this.parentElement.style.borderColor = '#dc3545';
            } else {
                this.setCustomValidity('');
                this.parentElement.style.borderColor = '#0033c4';
            }
        });
        
        // Confirmation de soumission
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const nombreTimbre = parseInt(input.value);
            
            if (nombreTimbre < 1) {
                showNotification('Veuillez entrer un nombre valide de timbres (min: 1)', 'danger');
                return;
            }
            
            const cost = nombreTimbre * 500;
            
            // Confirmation stylisée
            Swal.fire({
                title: 'Confirmer la recharge',
                html: `Êtes-vous sûr de vouloir ajouter <b>${new Intl.NumberFormat('fr-FR').format(nombreTimbre)}</b> timbre(s) pour un total de <b>${new Intl.NumberFormat('fr-FR').format(cost)} FCFA</b> ?`,
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#0033c4',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Oui, confirmer',
                cancelButtonText: 'Annuler',
                customClass: {
                    popup: 'border-radius-lg'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    // Animation de chargement
                    Swal.fire({
                        title: 'Ajout en cours...',
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
        
        // Fonction pour afficher les notifications
        function showNotification(message, type) {
            Swal.fire({
                icon: type === 'danger' ? 'error' : 'warning',
                title: 'Attention',
                text: message,
                confirmButtonColor: type === 'danger' ? '#dc3545' : '#ffc107',
                confirmButtonText: 'OK',
                customClass: {
                    popup: 'border-radius-lg'
                }
            });
        }
        
        // Auto-fermeture des alertes après 5 secondes
        setTimeout(() => {
            const alerts = document.querySelectorAll('.alert');
            alerts.forEach(alert => {
                const bsAlert = new bootstrap.Alert(alert);
                bsAlert.close();
            });
        }, 5000);
    });
</script>
</body>
</html>
@endsection