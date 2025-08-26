@extends('caisse.layouts.template')
@section('content')
<!-- Notifications -->


@if(session('error'))
<div class="alert alert-danger alert-dismissible fade show position-fixed top-0 end-0 m-3" 
     style="z-index: 9999; min-width: 300px;" role="alert">
    <div class="d-flex align-items-center">
        <i class="fas fa-exclamation-circle me-2"></i>
        <strong>{{ session('error') }}</strong>
    </div>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif

<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card card-glass mb-4">
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
                                    <div class="input-group input-group-outline">
                                        <span class="input-group-text bg-transparent"><i class="fas fa-stamp text-primary"></i></span>
                                        <input type="number" 
                                               class="form-control border-radius-lg" 
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
                                </div>
                                
                                <div class="button-row d-flex mt-4">
                                    <button type="submit" class="btn bg-gradient-primary btn-lg w-100 text-white">
                                        <i class="fas fa-plus-circle me-2 text-white"></i> Ajouter les timbres
                                    </button>
                                </div>
                            </form>
                            
                            <div class="mt-5">
                                <h6 class="mb-3 fw-bold">Dernières recharges</h6>
                                <div class="table-responsive">
                                    <table class="table align-items-center mb-0">
                                        <thead>
                                            <tr>
                                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ">Date</th>
                                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2 ">Quantité</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse($dernieres_recharges as $recharge)
                                            <tr>
                                                <td>
                                                    <div class="d-flex px-2 py-1 ">
                                                        <div class="d-flex flex-column justify-content-center">
                                                            <h6 class="mb-0 text-sm">{{ $recharge->created_at->format('d M Y') }}</h6>
                                                            <p class="text-xs text-secondary mb-0 text-center">{{ $recharge->created_at->format('H:i') }}</p>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <span class="text-success text-xs font-weight-bold">+ {{ number_format($recharge->nombre_timbre, 0, ',', ' ') }}</span>
                                                </td>
                                            </tr>
                                            @empty
                                            <tr>
                                                <td colspan="2" class="text-center py-4">
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
                            <div class="card bg-gradient-primary shadow-lg rounded-2 h-100">
                                <div class="card-body text-center p-4 d-flex flex-column justify-content-center">
                                    <div class="icon-shape icon-xl bg-white shadow text-center border-radius-lg mx-auto mb-3">
                                        <i class="fas fa-stamp text-primary text-gradient opacity-10"></i>
                                    </div>
                                    <h6 class="text-white mb-3">Solde actuel de timbres</h6>
                                    <h2 class="text-white display-3 fw-bold mb-3">{{ number_format($solde_timbres, 0, ',', ' ') }}</h2>

                                    <div class="mt-3">
                                        <span class="badge bg-light text-dark">
                                            <i class="fas fa-sync-alt me-1"></i> Timbres disponibles
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


<style>
    :root {
        --primary-gradient: linear-gradient(195deg, #0033c4, #0033c4);
        --glass-bg: rgba(255, 255, 255, 0.95);
        --glass-border: rgba(255, 255, 255, 0.2);
    }
    
    body {
        background: #f8f9fa;
        font-family: 'Inter', 'Segoe UI', sans-serif;
    }
    
    .card-glass {
        background: var(--glass-bg);
        backdrop-filter: blur(10px);
        border: 1px solid var(--glass-border);
        border-radius: 16px;
        overflow: hidden;
        box-shadow: 0 8px 32px rgba(0, 0, 0, 0.05);
    }
    
    .text-gradient {
        background-clip: text;
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        font-weight: 700;
    }
    
    .text-primary {
        background-image: var(--primary-gradient);
    }
    
    .bg-gradient-primary {
        background: var(--primary-gradient) !important;
    }
    
    .btn {
        border-radius: 12px;
        font-weight: 600;
        transition: all 0.3s ease;
    }
    
    .btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 7px 14px rgba(0, 0, 0, 0.1);
    }
    
    .input-group-outline {
        border-radius: 8px;
        transition: all 0.3s;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.03);
        background: #fff;
        border: 1px solid #e2e8f0;
    }
    
    .input-group-outline:focus-within {
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.08);
        border-color: #49a3f1;
    }
    
    .input-group-text {
        background: transparent;
        border: none;
        color: #6c757d;
    }
    
    .form-control {
        border: none;
        background: transparent;
        box-shadow: none;
        padding: 12px 10px;
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
        border-radius: 12px;
    }
    
    .border-radius-lg {
        border-radius: 12px;
    }
    
    .border-radius-md {
        border-radius: 8px;
    }
    
    .display-3 {
        font-size: 3.5rem;
        font-weight: 700;
    }
    
    @media (max-width: 992px) {
        .display-3 {
            font-size: 2.5rem;
        }
    }
    
    .table th {
        border-bottom: none;
        font-size: 0.75rem;
    }
    
    .table td {
        border-bottom: 1px solid #f1f1f1;
    }
</style>

<!-- Inclure Font Awesome pour les icônes -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.getElementById('rechargeForm');
        const input = document.getElementById('nombre_timbre');
        
        // Validation en temps réel
        input.addEventListener('input', function() {
            if (this.value < 0.01) {
                this.setCustomValidity('Veuillez entrer un nombre valide de timbres (min: 0.01)');
                this.parentElement.style.borderColor = '#e53e3e';
            } else {
                this.setCustomValidity('');
                this.parentElement.style.borderColor = '#49a3f1';
            }
        });
        
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const nombreTimbre = parseFloat(input.value);
            
            if (nombreTimbre < 0.01) {
                showNotification('Veuillez entrer un nombre valide de timbres (min: 0.01)', 'danger');
                return;
            }
            
            // Confirmation stylisée
            Swal.fire({
                title: 'Confirmer la recharge',
                html: `Êtes-vous sûr de vouloir ajouter <b>${nombreTimbre.toFixed(2)}</b> timbre(s) ?`,
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#49a3f1',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Oui, ajouter',
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
        
        function showNotification(message, type) {
            // Créer une notification toast simple
            const toast = document.createElement('div');
            toast.className = `alert alert-${type} position-fixed`;
            toast.style.top = '20px';
            toast.style.right = '20px';
            toast.style.zIndex = '9999';
            toast.style.minWidth = '300px';
            toast.style.borderRadius = '12px';
            toast.innerHTML = message;
            
            document.body.appendChild(toast);
            
            // Supprimer après 3 secondes
            setTimeout(() => {
                toast.remove();
            }, 3000);
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

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.getElementById('rechargeForm');
        const input = document.getElementById('nombre_timbre');
        
        // Afficher les messages de session avec SweetAlert2
        @if(session('success'))
        Swal.fire({
            icon: 'success',
            title: 'Succès !',
            text: '{{ session('success') }}',
            confirmButtonColor: '#49a3f1',
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
            confirmButtonColor: '#e53e3e',
            confirmButtonText: 'OK',
            customClass: {
                popup: 'border-radius-lg'
            }
        });
        @endif

        // Validation en temps réel
        input.addEventListener('input', function() {
            if (this.value < 0.01) {
                this.setCustomValidity('Veuillez entrer un nombre valide de timbres (min: 1)');
                this.parentElement.style.borderColor = '#e53e3e';
            } else {
                this.setCustomValidity('');
                this.parentElement.style.borderColor = '#49a3f1';
            }
        });
        
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const nombreTimbre = parseFloat(input.value);
            
            if (nombreTimbre < 1) {
                showNotification('Veuillez entrer un nombre valide de timbres (min: 1)', 'danger');
                return;
            }
            
            // Confirmation stylisée
            Swal.fire({
                title: 'Confirmer la recharge',
                html: `Êtes-vous sûr de vouloir ajouter <b>${nombreTimbre.toFixed(2)}</b> timbre(s) ?`,
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#49a3f1',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Oui, ajouter',
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
        
        function showNotification(message, type) {
            Swal.fire({
                icon: type === 'danger' ? 'error' : 'warning',
                title: 'Attention',
                text: message,
                confirmButtonColor: type === 'danger' ? '#e53e3e' : '#fbbf24',
                confirmButtonText: 'OK',
                customClass: {
                    popup: 'border-radius-lg'
                }
            });
        }
    });
</script>

<!-- Inclure Bootstrap JS pour les alertes -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@endsection