@extends('doctor.layouts.template')

@section('content')
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des Déclarations de Décès</title>
    
    <!-- Insertion de SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        /* Styling global */
        :root {
            --primary-color: #009efb;
            --secondary-color: #3498db;
            --accent-color: #e74c3c;
            --success-color: #27ae60;
            --warning-color: #f39c12;
            --light-color: #ecf0f1;
            --dark-color: #2c3e50;
            --text-color: #34495e;
            --border-radius: 8px;
            --box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            --transition: all 0.3s ease;
        }

        body {
            font-family: 'Poppins', 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f5f7fa;
            color: var(--text-color);
            line-height: 1.6;
        }

        .main-container {
            width: 95%;
            margin: 20px auto;
            background: #ffffff;
            border-radius: var(--border-radius);
            box-shadow: var(--box-shadow);
            padding: 25px;
            transition: var(--transition);
        }

        h1 {
            text-align: center;
            color: var(--primary-color);
            margin-bottom: 25px;
            font-size: 32px;
            font-weight: 700;
            position: relative;
            padding-bottom: 15px;
        }

        h1:after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 50%;
            transform: translateX(-50%);
            width: 80px;
            height: 4px;
            background: var(--secondary-color);
            border-radius: 2px;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            flex-wrap: wrap;
            gap: 15px;
        }

        .search-container {
            position: relative;
            flex: 1;
            max-width: 500px;
        }

        .search-container i {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: #7f8c8d;
        }

        .search-container input {
            width: 100%;
            padding: 12px 15px 12px 45px;
            border: 1px solid #ddd;
            border-radius: 30px;
            outline: none;
            transition: var(--transition);
            font-size: 14px;
            background: #f8f9fa;
        }

        .search-container input:focus {
            border-color: var(--secondary-color);
            box-shadow: 0 0 0 3px rgba(52, 152, 219, 0.2);
            background: #fff;
        }

        .add-btn {
            background: linear-gradient(135deg, var(--secondary-color), #009efb);
            color: white;
            padding: 12px 25px;
            border: none;
            border-radius: 30px;
            font-size: 15px;
            font-weight: 600;
            cursor: pointer;
            text-decoration: none;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: var(--transition);
            box-shadow: 0 4px 8px rgba(52, 152, 219, 0.3);
        }

        .add-btn i {
            margin-right: 8px;
        }

        .add-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 12px rgba(52, 152, 219, 0.4);
        }

        /* Table styling */
        .table-container {
            overflow-x: auto;
            border-radius: var(--border-radius);
            box-shadow: 0 2px 4px rgba(0,0,0,0.05);
        }

        table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
            background: #fff;
        }

        table thead th {
            background: linear-gradient(to bottom, var(--primary-color), #009efb);
            color: white;
            padding: 15px 12px;
            text-align: left;
            font-weight: 600;
            position: sticky;
            top: 0;
            border: none;
        }

        table thead th:first-child {
            border-top-left-radius: var(--border-radius);
        }

        table thead th:last-child {
            border-top-right-radius: var(--border-radius);
        }

        table tbody tr {
            background-color: #fff;
            transition: var(--transition);
        }

        table tbody tr:nth-child(even) {
            background-color: #f8f9fa;
        }

        table tbody tr:hover {
            background-color: #e8f4fc;
            transform: scale(1.002);
            box-shadow: 0 2px 8px rgba(0,0,0,0.05);
        }

        table tbody td {
            padding: 14px 12px;
            border-bottom: 1px solid #eaeaea;
            vertical-align: middle;
        }

        .action-cell {
            text-align: center;
            white-space: nowrap;
        }

        .btn-icon {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 36px;
            height: 36px;
            border-radius: 50%;
            margin: 0 3px;
            transition: var(--transition);
            color: #fff;
            text-decoration: none;
        }

        .btn-edit {
            background-color: var(--success-color);
        }

        .btn-delete {
            background-color: var(--accent-color);
        }

        .btn-view {
            background-color: var(--secondary-color);
        }

        .btn-download {
            background-color: #9b59b6;
        }

        .btn-icon:hover {
            transform: scale(1.1);
            box-shadow: 0 4px 8px rgba(0,0,0,0.15);
        }

        .btn-icon i {
            font-size: 14px;
        }

        .badge {
            display: inline-block;
            padding: 5px 10px;
            border-radius: 15px;
            font-size: 12px;
            font-weight: 600;
        }

        .badge-hospital {
            background-color: #ffeaa7;
            color: #d35400;
        }

        .empty-row td {
            text-align: center;
            padding: 30px;
            color: #7f8c8d;
            font-style: italic;
        }

        /* Responsive adjustments */
        @media (max-width: 992px) {
            .header {
                flex-direction: column;
                align-items: stretch;
            }
            
            .search-container {
                max-width: 100%;
            }
            
            .add-btn {
                align-self: flex-end;
            }
        }

        @media (max-width: 768px) {
            .main-container {
                padding: 15px;
                width: 98%;
            }
            
            h1 {
                font-size: 24px;
            }
            
            table thead {
                display: none;
            }
            
            table tbody tr {
                display: block;
                margin-bottom: 15px;
                border-radius: var(--border-radius);
                box-shadow: 0 2px 5px rgba(0,0,0,0.1);
            }
            
            table tbody td {
                display: block;
                text-align: right;
                padding: 10px 15px;
                position: relative;
                padding-left: 50%;
            }
            
            table tbody td:before {
                content: attr(data-label);
                position: absolute;
                left: 15px;
                width: 45%;
                padding-right: 15px;
                text-align: left;
                font-weight: 600;
                color: var(--primary-color);
            }
            
            .action-cell {
                text-align: center;
            }
            
            .action-cell:before {
                display: none;
            }
        }
    </style>
</head>
<body>
    <div class="main-container">
        <div class="alert-container">
            @if (Session::get('success1')) <!-- Pour la suppression -->
                <script>
                    Swal.fire({
                        icon: 'success',
                        title: 'Suppression réussie',
                        text: '{{ Session::get('success1') }}',
                        showConfirmButton: true,
                        confirmButtonText: 'OK',
                        confirmButtonColor: '#27ae60'
                    });
                </script>
            @endif
        
            @if (Session::get('success')) <!-- Pour la modification -->
                <script>
                    Swal.fire({
                        icon: 'success',
                        title: 'Action réussie',
                        text: '{{ Session::get('success') }}',
                        showConfirmButton: true,
                        confirmButtonText: 'OK',
                        confirmButtonColor: '#27ae60'
                    });
                </script>
            @endif
        
            @if (Session::get('error')) <!-- Pour une erreur générale -->
                <script>
                    Swal.fire({
                        icon: 'error',
                        title: 'Erreur',
                        text: '{{ Session::get('error') }}',
                        showConfirmButton: true,
                        confirmButtonText: 'OK',
                        confirmButtonColor: '#e74c3c'
                    });
                </script>
            @endif
        </div>

        <h1>Liste des Déclarations de Décès</h1>
        
        <div class="header">
            <div class="search-container">
                <i class="fas fa-search"></i>
                <input type="text" id="search" placeholder="Rechercher une déclaration...">
            </div>
            <a href="{{ route('statement.create.death') }}" class="add-btn">
                <i class="fas fa-plus-circle"></i> Nouvelle déclaration
            </a>
        </div>
        
        <div class="table-container">
            <table id="declarations-table">
                <thead>
                    <tr>
                        <th class="text-center">N° CMD</th>
                        <th class="text-center">Nom du défunt</th>
                        <th class="text-center">Prénoms</th>
                        <th class="text-center">Date de naissance</th>
                        <th class="text-center">Date de décès</th>
                        <th class="text-center">Lieu de décès</th>
                        <th class="text-center">Causes</th>
                        <th class="text-center">Commune</th>
                        <th class="text-center">Actions</th>
                        <th class="text-center">Téléchargements</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($deceshops as $deceshop)
                    <tr>
                        <td  class="text-center" data-label="N° CMD"><strong>{{ $deceshop->codeCMD }}</strong></td>
                        <td  class="text-center" data-label="Nom">{{ $deceshop->NomM }}</td>
                        <td  class="text-center" data-label="Prénoms">{{ $deceshop->PrM }}</td>
                        <td class="text-center" data-label="Naissance">{{ $deceshop->DateNaissance }}</td>
                        <td class="text-center" data-label="Décès">{{ $deceshop->DateDeces }}</td>
                        <td class="text-center" data-label="Lieu">
                            <span class="badge badge-hospital">{{ $deceshop->choix }} l'hôpital</span>
                        </td>
                        <td class="text-center" data-label="Causes">{{ Str::limit($deceshop->Remarques, 20) }}</td>
                        <td class="text-center" data-label="Commune">{{ $deceshop->commune }}</td>
                        <td class="text-center" data-label="Actions" class="action-cell">
                            <a href="{{ route('statement.edit.death', $deceshop->id) }}" class="btn-icon btn-edit" title="Modifier">
                                <i class="fas fa-edit"></i>
                            </a>
                            <a href="{{ route('statement.show.death', $deceshop->id) }}" class="btn-icon btn-view" title="Voir détails">
                                <i class="fas fa-eye"></i>
                            </a>
                            <a href="#" onclick="confirmDelete('{{ route('statement.delete.death', $deceshop->id) }}')" class="btn-icon btn-delete" title="Supprimer">
                                <i class="fas fa-trash"></i>
                            </a>
                        </td>
                        <td data-label="Téléchargements" class="action-cell">
                            <a href="{{ route('statement.download.death', $deceshop->id) }}" class="btn-icon btn-download" title="Télécharger Déclaration">
                                <i class="fas fa-file-pdf"></i>
                            </a>
                            <a href="{{ route('statement.downloadcontagion.death', $deceshop->id) }}" class="btn-icon btn-download" title="Télécharger Contagion">
                                <i class="fas fa-file-medical"></i>
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="10" class="empty-row">
                            <i class="fas fa-inbox" style="font-size: 48px; margin-bottom: 15px; color: #bdc3c7;"></i>
                            <br>
                            Aucune déclaration de décès enregistrée
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            $('#declarations-table').DataTable({
                pageLength: 10,
                lengthMenu: [5, 10, 15, 20],
                language: {
                    url: "//cdn.datatables.net/plug-ins/1.13.6/i18n/French.json"
                },
                dom: '<"top"f>rt<"bottom"lip><"clear">',
                initComplete: function() {
                    // Mettre à jour la recherche DataTables avec la valeur de l'input personnalisé
                    $('#search').on('input', function() {
                        $('#declarations-table').DataTable().search(this.value).draw();
                    });
                }
            });
        });

        function confirmDelete(route) {
            Swal.fire({
                title: 'Êtes-vous sûr?',
                text: "Cette action est irréversible!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#e74c3c',
                cancelButtonColor: '#7f8c8d',
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