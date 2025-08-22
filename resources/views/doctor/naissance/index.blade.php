@extends('doctor.layouts.template')

@section('content')
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des déclarations de naissance</title>
    
    <!-- Insertion de SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        /* Variables de couleurs */
        :root {
            --primary: #009efb;
            --primary-dark: #009efb;
            --secondary: #6c757d;
            --success: #28a745;
            --info: #17a2b8;
            --warning: #ffc107;
            --danger: #dc3545;
            --light: #f8f9fa;
            --dark: #343a40;
            --white: #ffffff;
            --gray-100: #f8f9fa;
            --gray-200: #e9ecef;
            --gray-300: #dee2e6;
            --gray-400: #ced4da;
            --gray-500: #adb5bd;
            --gray-600: #6c757d;
            --gray-700: #495057;
            --gray-800: #343a40;
            --gray-900: #212529;
            --border-radius: 12px;
            --box-shadow: 0 8px 20px rgba(0, 0, 0, 0.08);
            --transition: all 0.3s ease;
        }

        /* Styling global */
        body {
            font-family: 'Inter', 'Segoe UI', system-ui, -apple-system, sans-serif;
            background-color: #f5f7fa;
            color: var(--gray-800);
            line-height: 1.6;
        }

        .main-container {
            max-width: 100%;
            padding: 20px;
        }

        .card {
            background: var(--white);
            border-radius: var(--border-radius);
            box-shadow: var(--box-shadow);
            padding: 24px;
            margin-bottom: 24px;
            transition: var(--transition);
        }

        .card:hover {
            box-shadow: 0 12px 30px rgba(0, 0, 0, 0.12);
        }

        .page-title {
            color: var(--primary);
            font-weight: 700;
            font-size: 28px;
            margin-bottom: 24px;
            position: relative;
            padding-bottom: 12px;
        }

        .page-title::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 60px;
            height: 4px;
            background: var(--primary);
            border-radius: 2px;
        }

        .header-actions {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 24px;
            flex-wrap: wrap;
            gap: 16px;
        }

        .search-container {
            position: relative;
            flex: 1;
            max-width: 400px;
        }

        .search-input {
            width: 100%;
            padding: 12px 20px 12px 44px;
            border: 1px solid var(--gray-300);
            border-radius: 30px;
            background-color: var(--white);
            font-size: 15px;
            transition: var(--transition);
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.05);
        }

        .search-input:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 2px 8px rgba(58, 123, 213, 0.15);
        }http://127.0.0.1:8000/doctor/statement/indexbirth#

        .search-icon {
            position: absolute;
            left: 16px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--gray-500);
        }

        .btn-primary {
            background-color: var(--primary);
            color: var(--white);
            padding: 12px 24px;
            border: none;
            border-radius: 30px;
            font-weight: 600;
            font-size: 15px;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: var(--transition);
            text-decoration: none;
            box-shadow: 0 4px 10px rgba(58, 123, 213, 0.3);
        }

        .btn-primary:hover {
            background-color: var(--primary-dark);
            transform: translateY(-2px);
            box-shadow: 0 6px 15px rgba(58, 123, 213, 0.4);
        }

        /* Table styles */
        .table-container {
            overflow-x: auto;
            border-radius: var(--border-radius);
            background: var(--white);
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        }

        table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
        }

        th {
            background-color: var(--primary);
            color: var(--white);
            padding: 16px;
            text-align: left;
            font-weight: 600;
            position: sticky;
            top: 0;
        }

        th:first-child {
            border-top-left-radius: 10px;
        }

        th:last-child {
            border-top-right-radius: 10px;
        }

        td {
            padding: 16px;
            border-bottom: 1px solid var(--gray-200);
            vertical-align: middle;
        }

        tr:last-child td {
            border-bottom: none;
        }

        tr {
            transition: var(--transition);
        }

        tr:hover {
            background-color: rgba(58, 123, 213, 0.04);
        }

        /* Action buttons */
        .action-buttons {
            display: flex;
            gap: 8px;
            justify-content: center;
        }

        .btn-action {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 36px;
            height: 36px;
            border-radius: 50%;
            background: var(--gray-100);
            color: var(--gray-700);
            transition: var(--transition);
            text-decoration: none;
        }

        .btn-action:hover {
            transform: scale(1.1);
        }

        .btn-edit:hover {
            background: rgba(40, 167, 69, 0.15);
            color: var(--success);
        }

        .btn-delete:hover {
            background: rgba(220, 53, 69, 0.15);
            color: var(--danger);
        }

        .btn-view:hover {
            background: rgba(23, 162, 184, 0.15);
            color: var(--info);
        }

        .btn-download:hover {
            background: rgba(58, 123, 213, 0.15);
            color: var(--primary);
        }

        /* Badge for children count */
        .badge {
            display: inline-block;
            padding: 4px 10px;
            border-radius: 20px;
            font-size: 13px;
            font-weight: 600;
        }

        .badge-primary {
            background-color: #009efb;
            color: white;
        }

        /* Children list */
        .children-list {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .child-item {
            padding: 8px 0;
            border-bottom: 1px solid var(--gray-100);
        }

        .child-item:last-child {
            border-bottom: none;
        }

        .child-info {
            font-size: 14px;
            color: var(--gray-700);
        }

        /* Empty state */
        .empty-state {
            text-align: center;
            padding: 40px 20px;
            color: var(--gray-600);
        }

        .empty-state i {
            font-size: 48px;
            margin-bottom: 16px;
            color: var(--gray-400);
        }

        /* Responsive adjustments */
        @media (max-width: 992px) {
            .header-actions {
                flex-direction: column;
                align-items: stretch;
            }
            
            .search-container {
                max-width: 100%;
            }
        }

        @media (max-width: 768px) {
            .card {
                padding: 16px;
            }
            
            th, td {
                padding: 12px 8px;
            }
            
            .action-buttons {
                flex-wrap: wrap;
            }
        }
    </style>
</head>
<body>
    <div class="main-container">
        <div class="card">
            <h1 class="page-title">Liste des naissances déclarées</h1>
            
            <div class="header-actions">
                <div class="search-container">
                    <input type="text" id="search" class="search-input" placeholder="Rechercher une déclaration...">
                </div>
                <a href="{{ route('statement.create') }}" class="btn-primary">
                    <i class="fas fa-plus"></i> Nouvelle déclaration
                </a>
            </div>
            
            <div class="table-container">
                <table id="patients-table">
                    <thead>
                        <tr  style="text-align: center">
                            <th class="text-center">N° CMN</th>
                            <th class="text-center">Nom de la mère</th>
                            <th class="text-center">Accompagnateur</th>
                            <th class="text-center">Hôpital</th>
                            <th class="text-center">N°CMU Mère</th>
                            <th class="text-center">Nb. enfants</th>
                            <th class="text-center">Date de Naissance</th>
                            <th class="text-center">Actions</th>
                            <th class="text-center">Télécharger</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($naisshops as $naisshop)
                        <tr>
                            <td class="text-center">{{ $naisshop->codeCMN }}</td>
                            <td class="text-center">{{ $naisshop->NomM . ' ' . $naisshop->PrM }}</td>
                            <td class="text-center">{{ $naisshop->NomP . ' ' . $naisshop->PrP }}</td>
                            <td class="text-center">{{ $naisshop->NomEnf . ' ' . $naisshop->preEnf }}</td>
                            <td class="text-center">{{ $naisshop->codeCMU }}</td>
                            <td class="text-center">
                                @if ($naisshop->enfants->isNotEmpty())
                                    <span class="badge" style="background-color: #009efb; color:white">
                                        {{ $naisshop->enfants->first()->nombreEnf }}
                                    </span>
                                @else
                                    <span class="badge">Aucun</span>
                                @endif
                            </td>
                            <td class="text-center">
                                @if ($naisshop->enfants->isNotEmpty())
                                    <ul class="children-list">
                                        @foreach ($naisshop->enfants as $enfant)
                                            <li class="child-item">
                                                <div class="child-info">
                                                    <strong>Enfant {{ $loop->iteration }}</strong><br>
                                                    {{ \Carbon\Carbon::parse($enfant->date_naissance)->format('d/m/Y') }} • 
                                                    {{ $enfant->sexe == 'masculin' ? 'Garçon' : 'Fille' }}
                                                </div>
                                            </li>
                                        @endforeach
                                    </ul>
                                @else
                                    Aucun enfant
                                @endif
                            </td>
                            <td class="text-center">
                                <div class="action-buttons">
                                    <a href="{{ route('statement.edit', $naisshop->id) }}" class="btn-action btn-edit" title="Modifier">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <a href="#" onclick="confirmDelete('{{ route('statement.delete', $naisshop->id) }}')" class="btn-action btn-delete" title="Supprimer">
                                        <i class="fas fa-trash"></i>
                                    </a>
                                    <a href="{{ route('statement.show', $naisshop->id) }}" class="btn-action btn-view" title="Voir détails">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                </div>
                            </td>
                            <td class="text-center">
                                <a href="{{ route('statement.download', $naisshop->id) }}" class="btn-action btn-download" title="Télécharger le certificat">
                                    <i class="fas fa-download"></i>
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="9">
                                <div class="empty-state">
                                    <i class="fas fa-folder-open"></i>
                                    <h3>Aucune naissance déclarée</h3>
                                    <p>Commencez par ajouter une nouvelle déclaration</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script>
        // Notifications SweetAlert
        @if (Session::get('success1'))
            Swal.fire({
                icon: 'success',
                title: 'Suppression réussie',
                text: '{{ Session::get('success1') }}',
                confirmButtonColor: '#3a7bd5',
                confirmButtonText: 'OK'
            });
        @endif
    
        @if (Session::get('success'))
            Swal.fire({
                icon: 'success',
                title: 'Action réussie',
                text: '{{ Session::get('success') }}',
                confirmButtonColor: '#3a7bd5',
                confirmButtonText: 'OK'
            });
        @endif
    
        @if (Session::get('error'))
            Swal.fire({
                icon: 'error',
                title: 'Erreur',
                text: '{{ Session::get('error') }}',
                confirmButtonColor: '#3a7bd5',
                confirmButtonText: 'OK'
            });
        @endif

        // Configuration DataTables
        $(document).ready(function() {
            $('#patients-table').DataTable({
                pageLength: 10,
                lengthMenu: [5, 10, 15, 20],
                language: {
                    url: "//cdn.datatables.net/plug-ins/1.13.6/i18n/French.json"
                },
                dom: '<"top"f>rt<"bottom"lip><"clear">',
                responsive: true,
                initComplete: function() {
            // Personnaliser le champ de recherche de DataTables pour qu'il corresponde à notre style
            $('.dataTables_filter input').addClass('search-input');
            $('.dataTables_filter').prepend('<i class="fas fa-search search-icon"></i>');
            $('.dataTables_filter').css({'position': 'relative', 'margin-bottom': '20px'});
            $('.dataTables_filter .search-icon').css({
                'position': 'absolute',
                'left': '12px',
                'top': '50%',
                'transform': 'translateY(-50%)',
                'color': '#adb5bd'
            });
            $('.dataTables_filter input').css('padding-left', '40px');
        }
            });

            // Recherche personnalisée
            $('#search').on('input', function() {
                $('#patients-table').DataTable().search(this.value).draw();
            });
        });

        // Fonction de confirmation de suppression
        function confirmDelete(route) {
            Swal.fire({
                title: 'Êtes-vous sûr?',
                text: "Cette action est irréversible!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3a7bd5',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Oui, supprimer!',
                cancelButtonText: 'Annuler',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = route;
                }
            });
        }
    </script>
</body>
</html>
@endsection