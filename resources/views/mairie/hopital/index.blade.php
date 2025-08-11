@extends('mairie.layouts.template')
@section('content')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
<div class="container-fluid px-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="fw-semibold text-primary">Liste des hôpitaux</h1>
        <a href="{{route('hopital.create')}}" class="btn btn-primary rounded-pill">
            <i class="fas fa-plus me-2"></i>Ajouter un hôpital
        </a>
    </div>

    <div class="card border-0 shadow-lg rounded-4 overflow-hidden">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light-primary">
                        <tr>
                            <th class="text-center">Nom de l'hôpital</th>
                            <th class="text-center">Responsable</th>
                            <th class="text-center">Type</th>
                            <th class="text-center">Commune</th>
                            <th class="text-center">Contact</th>
                            <th class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($hopital as $item)
                        <tr class="border-top" style="text-align: center">
                            <td class="text-center" style="text-align: center">
                                <div  style="text-align: center">
                                   
                                    <div class="text-center" style="text-align: center">
                                        <h6 class="mb-0">{{ $item->nomHop }}</h6>
                                        <small class="text-muted">{{ $item->email }}</small>
                                    </div>
                                </div>
                            </td>
                            <td class="text-center">{{ $item->name }}</td>
                            <td class="text-center">
                                @switch($item->type)
                                    @case('hôpital-general')
                                        <span class="badge bg-info">Hôpital Général</span>
                                        @break
                                    @case('clinique')
                                        <span class="badge bg-success">Clinique</span>
                                        @break
                                    @case('pmi')
                                        <span class="badge bg-warning text-dark">PMI</span>
                                        @break
                                    @case('chu')
                                        <span class="badge bg-primary">CHU</span>
                                        @break
                                    @case('fsu')
                                        <span class="badge bg-secondary">FSU</span>
                                        @break
                                    @default
                                        <span class="badge bg-light text-dark">{{ $item->type }}</span>
                                @endswitch
                            </td>
                            <td class="text-center">{{ $item->commune }}</td>
                            <td class="text-center">{{ $item->contact }}</td>
                            <td class="text-end pe-4">
                                <div class="d-flex justify-content-center" style="gap:10px" >
                                    <a href="#" 
                                       class="btn btn-sm btn-outline-warning rounded-circle me-2"
                                       data-bs-toggle="tooltip" title="Modifier">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="#" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" 
                                                class="btn btn-sm btn-outline-danger rounded-circle"
                                                data-bs-toggle="tooltip" title="Supprimer"
                                                onclick="return confirm('Êtes-vous sûr de vouloir supprimer cet hôpital ?')">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center py-4">
                                <div class="d-flex flex-column align-items-center">
                                    <i class="fas fa-hospital text-muted fs-1 mb-2"></i>
                                    <h5 class="text-muted">Aucun hôpital enregistré</h5>
                                    <a href="#" class="btn btn-sm btn-primary mt-2">
                                        Ajouter un hôpital
                                    </a>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<style>
    .bg-light-primary {
        background-color: rgba(63, 128, 234, 0.1);
    }
    
    .table-hover tbody tr:hover {
        background-color: rgba(63, 128, 234, 0.05);
    }
    
    .badge {
        padding: 0.35em 0.65em;
        font-size: 0.75em;
        font-weight: 500;
    }
    
    .rounded-circle {
        width: 32px;
        height: 32px;
        display: flex;
        align-items: center;
        justify-content: center;
    }
</style>

<script>
    // Activer les tooltips Bootstrap
    document.addEventListener('DOMContentLoaded', function() {
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl)
        })
    })
</script>
@endsection