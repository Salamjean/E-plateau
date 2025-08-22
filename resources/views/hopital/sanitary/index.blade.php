@extends('hopital.layouts.template')

@section('content')
    <title>Liste des centres de santé</title>

    <!-- Insertion de SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    
    <div class="ms-content-wrapper">
        <div class="row">
            <div class="col-md-12">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb pl-0">
                        <li class="breadcrumb-item">
                            <a href="#">
                                <i class="material-icons">home</i> Tableau de bord
                            </a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">Liste des centres de santé</li>
                    </ol>
                </nav>
            </div>
        </div>

        <div class="row">
            <div class="col-xl-12 col-md-12">
                <div class="ms-panel">
                    <div class="ms-panel-header ms-panel-custome">
                        <h6 class="text-white">Liste des centres de santé du plateau</h6>
                        <a href="{{ route('sanitary.create') }}" class="add-patient">
                            <i class="fas fa-plus"></i> Ajouter un centre
                        </a>
                    </div>
                    <div class="ms-panel-body">
                        @if (Session::get('success1'))
                            <script>
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Suppression réussie',
                                    text: '{{ Session::get('success1') }}',
                                    showConfirmButton: true,
                                    confirmButtonText: 'OK',
                                    color: '#b30000'
                                });
                            </script>
                        @endif
                    
                        @if (Session::get('success'))
                            <script>
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Action réussie',
                                    text: '{{ Session::get('success') }}',
                                    showConfirmButton: true,
                                    confirmButtonText: 'OK',
                                    color: '#006600'
                                });
                            </script>
                        @endif
                    
                        @if (Session::get('error'))
                            <script>
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Erreur',
                                    text: '{{ Session::get('error') }}',
                                    showConfirmButton: true,
                                    confirmButtonText: 'OK',
                                    color: 'red'
                                });
                            </script>
                        @endif

                        <div class="table-header">
                            <div class="search-bar">
                                <i class="fas fa-search"></i>
                                <input type="text" id="search" placeholder="Rechercher un centre...">
                            </div>
                        </div>
                    
                        <table id="centres-table" class="modern-table display">
                            <thead>
                                <tr>
                                    <th class="text-center">Nom du centre de santé</th>
                                    <th class="text-center">Type du centre de santé</th>
                                    <th class="text-center">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($sanitaires as $centre)
                                <tr>
                                    <td class="text-center">{{ $centre->name_hospial }}</td>
                                    <td class="text-center">
                                        @switch($centre->type)
                                            @case('hôpital-general')
                                                Hôpital Général
                                                @break
                                            @case('clinique')
                                                Clinique
                                                @break
                                            @case('pmi')
                                                PMI
                                                @break
                                            @case('chu')
                                                CHU
                                                @break
                                            @case('fsu')
                                                FSU
                                                @break
                                            @default
                                                {{ $centre->type }}
                                        @endswitch
                                    </td>
                                    <td class="action-cell text-center">
                                        <div class="btn-group">
                                            <a href="#" class="btn-action btn-edit" title="Modifier">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <button class="btn-action btn-delete" onclick="confirmDelete('#')" title="Supprimer">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="3" class="text-center no-data">Aucun centre de santé trouvé</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        :root {
            --primary-color: #009efb;
            --primary-hover: #0088e0;
            --light-bg: #f8f9fa;
            --border-radius: 10px;
            --box-shadow: 0 5px 15px rgba(0, 158, 251, 0.1);
            --success-color: #28a745;
            --danger-color: #dc3545;
        }
        
        .ms-panel {
            border-radius: var(--border-radius);
            box-shadow: var(--box-shadow);
            border: none;
            overflow: hidden;
        }
        
        .ms-panel-header {
            background: var(--primary-color);
            color: white;
            padding: 20px;
            border-radius: var(--border-radius) var(--border-radius) 0 0 !important;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .ms-panel-header h6 {
            margin: 0;
            font-weight: 600;
            font-size: 1.2rem;
        }
        
        .add-patient {
            background-color: white;
            color: var(--primary-color);
            padding: 10px 20px;
            border-radius: 30px;
            font-size: 14px;
            font-weight: 500;
            text-decoration: none;
            display: flex;
            align-items: center;
            transition: all 0.3s ease;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }
        
        .add-patient:hover {
            background-color: var(--primary-hover);
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.15);
        }
        
        .ms-panel-body {
            padding: 30px;
            background-color: white;
        }
        
        .table-header {
            display: flex;
            justify-content: flex-end;
            margin-bottom: 20px;
        }
        
        .search-bar {
            position: relative;
            width: 300px;
        }
        
        .search-bar i {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: #adb5bd;
        }
        
        .search-bar input {
            width: 100%;
            padding: 12px 15px 12px 45px;
            border: 2px solid #e9ecef;
            border-radius: 30px;
            font-size: 14px;
            transition: all 0.3s ease;
        }
        
        .search-bar input:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(0, 158, 251, 0.2);
            outline: none;
        }
        
        .modern-table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
            border-radius: var(--border-radius);
            overflow: hidden;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        }
        
        .modern-table thead {
            background-color: var(--primary-color);
            color: white;
        }
        
        .modern-table th {
            padding: 15px;
            font-weight: 600;
            text-align: left;
        }
        
        .modern-table tbody tr {
            background-color: white;
            border-bottom: 1px solid #e9ecef;
            transition: all 0.3s ease;
        }
        
        .modern-table tbody tr:hover {
            background-color: #f8fbff;
            transform: translateY(-1px);
            box-shadow: 0 2px 8px rgba(0, 158, 251, 0.1);
        }
        
        .modern-table td {
            padding: 15px;
            vertical-align: middle;
        }
        
        .action-cell {
            width: 120px;
        }
        
        .btn-group {
            display: flex;
            gap: 10px;
        }
        
        .btn-action {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s ease;
            border: none;
            cursor: pointer;
            text-decoration: none;
        }
        
        .btn-edit {
            background-color: rgba(40, 167, 69, 0.1);
            color: var(--success-color);
        }
        
        .btn-edit:hover {
            background-color: var(--success-color);
            color: white;
            transform: scale(1.1);
        }
        
        .btn-delete {
            background-color: rgba(220, 53, 69, 0.1);
            color: var(--danger-color);
        }
        
        .btn-delete:hover {
            background-color: var(--danger-color);
            color: white;
            transform: scale(1.1);
        }
        
        .no-data {
            padding: 30px;
            color: #6c757d;
            font-style: italic;
        }
        
        .breadcrumb {
            background-color: transparent;
            padding: 0;
            margin-bottom: 20px;
        }
        
        .breadcrumb-item a {
            color: var(--primary-color);
            text-decoration: none;
            transition: color 0.2s;
        }
        
        .breadcrumb-item a:hover {
            color: var(--primary-hover);
            text-decoration: underline;
        }
        
        .breadcrumb-item.active {
            color: #6c757d;
        }
        
        @media (max-width: 768px) {
            .ms-panel-header {
                flex-direction: column;
                gap: 15px;
                align-items: flex-start;
            }
            
            .table-header {
                justify-content: center;
            }
            
            .search-bar {
                width: 100%;
            }
            
            .modern-table {
                display: block;
                overflow-x: auto;
            }
            
            .btn-group {
                justify-content: center;
            }
        }
    </style>

    <script>
        $(document).ready(function() {
            $('#centres-table').DataTable({
                pageLength: 10,
                lengthMenu: [5, 10, 15, 20],
                language: {
                    url: "//cdn.datatables.net/plug-ins/1.13.6/i18n/French.json"
                },
                dom: 'rt<"bottom"lp>',
                responsive: true,
                ordering: true,
                order: [[0, 'asc']]
            });

            // Recherche personnalisée
            $('#search').on('input', function() {
                $('#centres-table').DataTable().search(this.value).draw();
            });
        });

        function confirmDelete(route) {
            Swal.fire({
                title: 'Êtes-vous sûr?',
                text: "Vous ne pourrez pas revenir en arrière!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Oui, supprimer!',
                cancelButtonText: 'Annuler'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = route;
                }
            });
        }
    </script>
@endsection