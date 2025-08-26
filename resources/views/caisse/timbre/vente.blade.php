@extends('caisse.layouts.template')
@section('content')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<div class="container-fluid py-4">
    <div class="row">
         <!-- Cartes statistiques -->
        <div class="col-md-4">
            <div class="card stat-card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="card-title text-white">Aujourd'hui</h6>
                            <h3 class="stat-value">{{ number_format($stats['today'], 0, ',', ' ') }}</h3>
                            <p class="stat-label">Timbres vendus</p>
                        </div>
                        <div class="stat-icon">
                            <i class="fas fa-calendar-day"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card stat-card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="card-title  text-white">Cette semaine</h6>
                            <h3 class="stat-value">{{ number_format($stats['this_week'], 0, ',', ' ') }}</h3>
                            <p class="stat-label">Timbres vendus</p>
                        </div>
                        <div class="stat-icon">
                            <i class="fas fa-calendar-week"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card stat-card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="card-title  text-white">Ce mois</h6>
                            <h3 class="stat-value">{{ number_format($stats['this_month'], 0, ',', ' ') }}</h3>
                            <p class="stat-label">Timbres vendus</p>
                        </div>
                        <div class="stat-icon">
                            <i class="fas fa-calendar-alt"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12">
            <div class="card custom-card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <h4 class="card-title mb-0">Liste des ventes effectuées par les financiers</h4>
                        <div class="card-actions">
                            <a href="{{ route('caisse.timbre.vente') }}" class="btn btn-sm btn-icon" data-bs-toggle="tooltip" title="Actualiser">
                                <i class="fas fa-sync-alt"></i>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="filter-section">
                        <form method="GET" class="filter-form">
                            <div class="filter-inputs">
                                <div class="input-group">
                                    <label class="form-label">Date début</label>
                                    <input type="date" name="date_debut" class="form-control" 
                                        value="{{ request('date_debut') }}">
                                </div>
                                <div class="input-group">
                                    <label class="form-label">Date fin</label>
                                    <input type="date" name="date_fin" class="form-control" 
                                        value="{{ request('date_fin') }}">
                                </div>
                                <div class="input-group">
                                    <label class="form-label">Financier</label>
                                    <select name="financier_id" class="form-control">
                                        <option value="">Tous les financiers</option>
                                        @foreach($financiers as $financier)
                                            <option value="{{ $financier->id }}" 
                                                    {{ request('financier_id') == $financier->id ? 'selected' : '' }}>
                                                {{ $financier->name }} {{ $financier->prenom }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="input-group">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-filter me-2"></i> Appliquer
                                    </button>
                                </div>
                                <div class="input-group">
                                    <a href="{{ route('caisse.timbre.vente') }}" class="btn btn-primary">
                                        <i class="fas fa-times me-2"></i> Réinitialiser
                                    </a>
                                </div>
                            </div>
                        </form>
                    </div>
                    
                    <div class="data-table">
                        <table class="table">
                            <thead >
                                <tr style="background-color: #0033c4">
                                    <th scope="col">Date</th>
                                    <th scope="col">Heure</th>
                                    <th scope="col">Financier</th>
                                    <th scope="col" class="text-right">Quantité vendue</th>
                                    <th scope="col" class="text-center">Type opération</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($ventes as $vente)
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <i class="far fa-calendar-alt me-2"></i>
                                            {{ $vente->created_at->format('d/m/Y') }}
                                        </div>
                                    </td>
                                    <td>
                                        <span class="time-badge">
                                            <i class="far fa-clock me-1"></i>
                                            {{ $vente->created_at->format('H:i') }}
                                        </span>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="user-avatar">
                                                {{ substr(($vente->finance->name ?? 'N'), 0, 1) }}{{ substr(($vente->finance->prenom ?? 'A'), 0, 1) }}
                                            </div>
                                            <div class="user-info">
                                                {{ $vente->finance->name ?? 'N/A' }} {{ $vente->finance->prenom ?? '' }}
                                            </div>
                                        </div>
                                    </td>
                                    <td class="text-right">
                                        <span class="quantity">
                                            {{ number_format(abs($vente->nombre_timbre), 0, ',', ' ') }}
                                            <i class="fas fa-stamp ms-1"></i>
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        <span class="operation-badge">
                                            <i class="fas fa-shopping-cart me-1"></i> Vente
                                        </span>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="text-center">
                                        <div class="empty-state">
                                            <i class="fas fa-receipt"></i>
                                            <p>Aucune vente enregistrée pour les financiers</p>
                                            <a href="{{ route('caisse.timbre.vente') }}" class="btn btn-outline">
                                                Actualiser
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    
                    @if($ventes->hasPages())
                    <div class="pagination-container">
                        <div class="pagination-info">
                            Affichage de {{ $ventes->firstItem() }} à {{ $ventes->lastItem() }} sur {{ $ventes->total() }} résultats
                        </div>
                        <div class="pagination-links">
                            {{ $ventes->appends(request()->query())->links('pagination.custom') }}
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<style>
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
        --card-shadow: 0 5px 20px rgba(0, 51, 196, 0.12);
        --transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
    }

    
    
    body {
        background-color: #f5f7ff;
        color: #2d3748;
        font-family: 'Inter', 'Segoe UI', system-ui, -apple-system, sans-serif;
        line-height: 1.6;
    }
    
    .custom-card {
        border: none;
        border-radius: 16px;
        box-shadow: var(--card-shadow);
        overflow: hidden;
        background: #ffffff;
        transition: var(--transition);
    }
    
    .custom-card:hover {
        box-shadow: 0 8px 25px rgba(0, 51, 196, 0.15);
    }
    
    .card-header {
        padding: 1.5rem 1.5rem 0;
        background: transparent;
        border: none;
    }
    
    .card-title {
        color: var(--primary-dark);
        font-weight: 700;
        font-size: 1.5rem;
        margin-bottom: 0;
    }
    
    .card-body {
        padding: 1.5rem;
    }
    
    .filter-section {
        margin-bottom: 1.5rem;
    }
    
    .filter-form {
        background: var(--gray-100);
        border-radius: 12px;
        padding: 1.25rem;
    }
    
    .filter-inputs {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 1rem;
        align-items: end;
    }
    
    .input-group {
        display: flex;
        flex-direction: column;
    }
    
    .form-label {
        font-weight: 500;
        font-size: 0.875rem;
        margin-bottom: 0.5rem;
        color: var(--gray-800);
    }
    
    .form-control {
        border-radius: 10px;
        border: 1px solid var(--gray-300);
        padding: 0.75rem 1rem;
        font-size: 0.95rem;
        transition: var(--transition);
        background: #ffffff;
    }
    
    .form-control:focus {
        border-color: var(--primary);
        box-shadow: 0 0 0 3px rgba(0, 51, 196, 0.2);
    }
    
    .btn {
        border-radius: 10px;
        font-weight: 600;
        padding: 0.75rem 1.25rem;
        transition: var(--transition);
        border: none;
        display: inline-flex;
        align-items: center;
        justify-content: center;
    }
    
    .btn-sm {
        padding: 0.5rem 1rem;
        font-size: 0.875rem;
    }
    
    .btn-icon {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        background: var(--gray-100);
        color: var(--primary);
        transition: var(--transition);
    }
    
    .btn-icon:hover {
        background: var(--primary);
        color: white;
        transform: rotate(45deg);
    }
    
    .btn-primary {
        background: var(--primary);
        color: white;
        box-shadow: 0 4px 10px rgba(0, 51, 196, 0.25);
    }
    
    .btn-primary:hover {
        background: var(--primary-dark);
        transform: translateY(-2px);
        box-shadow: 0 6px 15px rgba(0, 51, 196, 0.35);
    }
    
    .btn-secondary {
        background: var(--gray-200);
        color: var(--gray-800);
    }
    
    .btn-secondary:hover {
        background: var(--gray-300);
        transform: translateY(-2px);
    }
    
    .btn-outline {
        background: transparent;
        border: 1px solid var(--primary);
        color: var(--primary);
    }
    
    .btn-outline:hover {
        background: var(--primary);
        color: white;
    }
    
    .alert {
        border-radius: 12px;
        border: none;
        padding: 1rem 1.5rem;
        background: rgba(0, 51, 196, 0.08);
        color: var(--primary-dark);
        display: flex;
        align-items: center;
        margin-bottom: 1.5rem;
    }
    
    .alert i {
        color: var(--primary);
        font-size: 1.2rem;
        margin-right: 0.75rem;
    }
    
    .data-table {
        background: white;
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
    }
    
    .table {
        margin-bottom: 0;
        border-collapse: separate;
        border-spacing: 0;
        width: 100%;
    }
    
    .table thead tr {
        background: linear-gradient(135deg, var(--primary) 0%, var(--primary-light) 100%);
    }
    
    .table th {
        padding: 1.25rem 1rem;
        font-weight: 600;
        font-size: 0.875rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        color: white;
        border: none;
        text-align: left;
    }
    
    .table th.text-right {
        text-align: right;
    }
    
    .table th.text-center {
        text-align: center;
    }
    
    .table td {
        padding: 1.25rem 1rem;
        vertical-align: middle;
        border-bottom: 1px solid var(--gray-200);
        color: var(--gray-800);
    }
    
    .table tbody tr {
        transition: var(--transition);
    }
    
    .table tbody tr:last-child td {
        border-bottom: none;
    }
    
    .table tbody tr:hover {
        background: rgba(0, 51, 196, 0.03);
    }
    
    .user-avatar {
        width: 42px;
        height: 42px;
        border-radius: 50%;
        background: linear-gradient(135deg, var(--primary) 0%, var(--primary-light) 100%);
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 600;
        margin-right: 0.75rem;
        flex-shrink: 0;
    }
    
    .user-info {
        font-weight: 500;
    }
    
    .time-badge {
        background: var(--gray-100);
        padding: 0.5rem 0.75rem;
        border-radius: 8px;
        font-size: 0.875rem;
        font-weight: 500;
        display: inline-flex;
        align-items: center;
    }
    
    .quantity {
        font-weight: 700;
        font-size: 1.1rem;
        color: var(--primary);
        display: inline-flex;
        align-items: center;
    }
    
    .operation-badge {
        background: rgba(220, 53, 69, 0.1);
        color: var(--danger);
        padding: 0.5rem 0.75rem;
        border-radius: 8px;
        font-size: 0.875rem;
        font-weight: 500;
        display: inline-flex;
        align-items: center;
    }
    
    .empty-state {
        padding: 3rem 1rem;
        text-align: center;
        color: var(--gray-800);
    }
    
    .empty-state i {
        font-size: 3.5rem;
        color: var(--gray-300);
        margin-bottom: 1rem;
    }
    
    .empty-state p {
        margin-bottom: 1.5rem;
        font-size: 1.1rem;
    }
    
    .pagination-container {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-top: 1.5rem;
        padding: 1rem;
        background: var(--gray-100);
        border-radius: 12px;
    }
    
    .pagination-info {
        font-size: 0.875rem;
        color: var(--gray-800);
    }
    
    .pagination {
        margin-bottom: 0;
    }
    
    .page-link {
        border-radius: 8px;
        margin: 0 0.25rem;
        border: 1px solid var(--gray-300);
        color: var(--gray-800);
        padding: 0.5rem 0.75rem;
        transition: var(--transition);
    }
    
    .page-link:hover {
        background: var(--primary);
        border-color: var(--primary);
        color: white;
    }
    
    .page-item.active .page-link {
        background: var(--primary);
        border-color: var(--primary);
    }

    .stat-card {
        border: none;
        border-radius: 16px;
        box-shadow: var(--card-shadow);
        transition: var(--transition);
        background: linear-gradient(135deg, var(--primary) 0%, var(--primary-light) 100%);
        color: white;
        margin-bottom: 1.5rem;
    }
    
    .stat-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 25px rgba(0, 51, 196, 0.2);
    }
    
    .stat-value {
        font-weight: 700;
        font-size: 2.2rem;
        margin: 0.5rem 0;
    }
    
    .stat-label {
        opacity: 0.9;
        font-size: 0.9rem;
        margin: 0;
    }
    
    .stat-icon {
        font-size: 2.5rem;
        opacity: 0.8;
    }
    
    @media (max-width: 768px) {
        .stat-value {
            font-size: 1.8rem;
        }
        
        .stat-icon {
            font-size: 2rem;
        }
    }
    
    @media (max-width: 992px) {
        .filter-inputs {
            grid-template-columns: 1fr 1fr;
        }
    }
    
    @media (max-width: 768px) {
        .card-title {
            font-size: 1.25rem;
        }
        
        .filter-inputs {
            grid-template-columns: 1fr;
        }
        
        .pagination-container {
            flex-direction: column;
            gap: 1rem;
            text-align: center;
        }
        
        .table thead {
            display: none;
        }
        
        .table tbody tr {
            display: block;
            margin-bottom: 1rem;
            border-radius: 12px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            padding: 1rem;
        }
        
        .table tbody td {
            display: block;
            text-align: right;
            padding: 0.75rem;
            border-bottom: 1px solid var(--gray-200);
            position: relative;
        }
        
        .table tbody td:before {
            content: attr(data-label);
            position: absolute;
            left: 1rem;
            font-weight: 600;
            text-transform: uppercase;
            font-size: 0.8rem;
            color: var(--gray-800);
        }
        
        .table tbody td:last-child {
            border-bottom: none;
        }

        
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Animation pour l'apparition des éléments
        const cards = document.querySelectorAll('.custom-card');
        cards.forEach((card, index) => {
            card.style.opacity = '0';
            card.style.transform = 'translateY(20px)';
            setTimeout(() => {
                card.style.transition = 'opacity 0.5s ease, transform 0.5s ease';
                card.style.opacity = '1';
                card.style.transform = 'translateY(0)';
            }, index * 100);
        });
        
        // Tooltip initialization
        const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });
        
        // Add data labels for mobile view
        if (window.innerWidth < 768) {
            const headers = document.querySelectorAll('.table th');
            const cells = document.querySelectorAll('.table td');
            
            headers.forEach((header, index) => {
                const label = header.textContent;
                document.querySelectorAll('.table td:nth-child(' + (index + 1) + ')').forEach(cell => {
                    cell.setAttribute('data-label', label);
                });
            });
        }
    });
</script>
@endsection