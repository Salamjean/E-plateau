@extends('doctor.layouts.template')

@section('content')
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des Patients</title>
    
    <!-- Insertion de SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        /* Styling global */
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f8f9fa;
            padding: 0;
            color: #333;
        }

        .container {
            width: 95%;
            margin: 0 auto;
            justify-content: center;
            background: #ffffff;
            border-radius: 8px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
        }

        h1 {
            text-align: center;
            color: black;
            margin-bottom: 20px;
            font-size: 40px;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 15px;
        }

        .header .search-bar {
            display: flex;
            align-items: center;
            width: 70%;
        }

        .header input[type="text"] {
            flex: 1;
            padding: 10px 15px;
            border: 1px solid #ccc;
            border-radius: 25px;
            outline: none;
            transition: all 0.3s ease;
            font-size: 14px;
        }

        .header input[type="text"]:focus {
            border-color: #009efb;
            box-shadow: 0 0 5px rgba(0, 158, 251, 0.5);
        }

        .add-patient {
            background-color: #009efb;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 25px;
            font-size: 14px;
            cursor: pointer;
            text-decoration: none;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: background-color 0.3s ease, box-shadow 0.3s ease;
        }

        .add-patient i {
            margin-right: 8px;
        }

        .add-patient:hover {
            background-color: #007acd;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.2);
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        table thead th {
            background-color: #009efb;
            color: white;
            padding: 10px;
            text-align: left;
        }

        table tbody tr {
            background-color: #f9f9f9;
            border-bottom: 1px solid #dddddd;
            transition: background-color 0.3s ease;
        }

        table tbody tr:hover {
            background-color: #f1faff;
        }

        table tbody td {
            padding: 10px;
        }

        table tbody td:last-child {
            text-align: center;
        }

        button {
            border: none;
            background: none;
            cursor: pointer;
            font-size: 16px;
        }

        a .edit {
            color: #28a745;
            transition: color 0.3s ease;
        }
        a .eye {
            color: #3047b8;
            transition: color 0.3s ease;
        }

        a .delete {
            color: #dc3545;
            transition: color 0.3s ease;
        }

        .edit:hover {
            color: #1e7e34;
        }
        .eye:hover {
            color: #1e617e;
        }
        .delete:hover {
            color: #c82333;
        }
    </style>
</head>
<body>
    <div class="row" style="width:100%; justify-content:center">
        <div class="row" style="width:100%; justify-content:center">
            @if (Session::get('success1')) <!-- Pour la suppression -->
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
        
            @if (Session::get('success')) <!-- Pour la modification -->
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
        
            @if (Session::get('error')) <!-- Pour une erreur générale -->
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
        </div>

        <div class="container col-11">
            <h1>Liste des déclarations de décès</h1>
            <div class="header">
                <div class="search-bar">
                    <input type="text" id="search" placeholder="Rechercher une déclaration...">
                </div>
                <a href="{{ route('statement.create.death') }}" class="add-patient"><i class="fas fa-plus"></i> Ajouter une nouvelle déclaration</a>
            </div>
            
            <table id="patients-table" class="display">
                <thead style="text-align: center">
                    <tr class="text-center">
                        <th class="text-center">N° CMD</th>
                        <th class="text-center">Nom du défunt</th>
                        <th class="text-center">Prénoms du défunt</th>
                        <th class="text-center">Date de naissance</th>
                        <th class="text-center">Date de décès</th>
                        <th class="text-center">Lieu de décès</th>
                        <th class="text-center">Causes du décès</th>
                        <th class="text-center">Commune de décès</th>
                        <th colspan="3" style="text-align: center">Action</th>
                        <th colspan="2" style="text-align: center">Télécharger</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($deceshops as $deceshop)
                    <tr class="text-center">
                        <td>{{ $deceshop->codeCMD }}</td>
                        <td>{{ $deceshop->NomM }}</td>
                        <td>{{ $deceshop->PrM }}</td>
                        <td>{{ $deceshop->DateNaissance }}</td>
                        <td>{{ $deceshop->DateDeces }}</td>
                        <td>{{ $deceshop->choix }} l'hôpital</td>
                        <td>{{ $deceshop->Remarques }}</td>
                        <td>{{ $deceshop->commune }}</td>
                        <td>
                            <button class="edit"><a href="{{ route('statement.edit.death', $deceshop->id) }}" class="edit"><i class="fas fa-edit"></i></a></button>
                        </td>
                        <td>
                            <button class="delete" onclick="confirmDelete('{{ route('statement.delete.death', $deceshop->id) }}')">
                                <i class="fas fa-trash"></i>
                            </button>
                        </td>
                        <td>
                            <button class="eye"><a href="{{ route('statement.show.death', $deceshop->id) }}" class="eye"><i class="fas fa-eye"></i></a></button>
                        </td>
                        <td>
                            <button class="eye">
                                <a href="{{ route('statement.download.death', $deceshop->id) }}" style="color: #009efb">
                                    <i class="fas fa-download" style="color: blue"></i><br> Déclaration
                                </a>
                            </button>
                        </td>
                        <td>
                            <button class="eye">
                                <a href="{{ route('statement.downloadcontagion.death', $deceshop->id) }}" style="color: #009efb">
                                    <i class="fas fa-download" style="color: blue"></i> <br>Contagion
                                </a>
                            </button>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="12" class="text-center">Aucun Décès Déclaré</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
            
            <script>
                document.getElementById('search').addEventListener('keyup', function() {
                    const filter = this.value.toLowerCase();
                    const rows = document.querySelectorAll('#patients-table tbody tr');
            
                    rows.forEach(row => {
                        const cells = row.querySelectorAll('td');
                        const match = Array.from(cells).some(cell => 
                            cell.textContent.toLowerCase().includes(filter)
                        );
                        row.style.display = match ? '' : 'none';
                    });
                });
            </script>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            $('#patients-table').DataTable({
                pageLength: 10,
                lengthMenu: [5, 10, 15, 20],
                language: {
                    url: "//cdn.datatables.net/plug-ins/1.13.6/i18n/French.json"
                },
                dom: 'rt<"bottom"lp>'
            });

            // Recherche personnalisée
            $('#search').on('input', function() {
                $('#patients-table').DataTable().search(this.value).draw();
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
                    // Rediriger vers l'URL de suppression
                    window.location.href = route;
                }
            });
        }
    </script>
</body>
</html>
@endsection