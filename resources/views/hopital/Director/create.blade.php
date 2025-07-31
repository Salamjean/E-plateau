@extends('hopital.layouts.template')

@section('content')

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
                    <li class="breadcrumb-item active" aria-current="page">Ajout d'un directeur</li>
                </ol>
            </nav>
        </div>

        <div class="col-xl-12 col-md-12">
            <div class="ms-panel">
                <div class="ms-panel-header ms-panel-custome">
                    <h6>Ajout d'un directeur</h6>
                    <a href="{{ route('directeur.create') }}" class="add-patient"><i class="fas fa-bars"></i>&emsp; Liste docteur</a>
                </div>
                <div class="ms-panel-body">
                    <form class="needs-validation" method="POST" enctype="multipart/form-data" action="{{ route('directeur.store') }}" novalidate>
                        @csrf
                        @method('POST')

                        <!-- Nom et Prénom -->
                        <div class="form-row">
                            <div class="col-md-6 mb-3">
                                <label for="validationCustom001">Nom</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" name="name" id="validationCustom001" placeholder="Entre son nom" required>
                                    <div class="valid-feedback">Correct</div>
                                </div>
                                @error('name')
                                    <div class="text-danger text-center">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="validationCustom002">Prénom</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" name="prenom" id="validationCustom002" placeholder="Entre son prénom" required>
                                    <div class="valid-feedback">Correct</div>
                                </div>
                                @error('prenom')
                                    <div class="text-danger text-center">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Email et Contact -->
                        <div class="form-row">
                            <div class="col-md-6 mb-2">
                                <label for="validationCustom003">Email</label>
                                <div class="input-group">
                                    <input type="email" class="form-control" name="email" id="validationCustom003" placeholder="Entre son email" required>
                                    <div class="valid-feedback">Correct</div>
                                </div>
                                @error('email')
                                    <div class="text-danger text-center">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="validationCustom009">Contact</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" name="contact" id="validationCustom009" placeholder="Son Numéro" required>
                                    <div class="valid-feedback">Correct</div>
                                </div>
                                @error('contact')
                                    <div class="text-danger text-center">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Bouton de soumission -->
                        <div class="text-center mt-4">
                            <button class="btn btn-primary w-25" type="submit">Enregistrer</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <style>
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

        .add-patient:hover {
            background-color: #007acd;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.2);
        }

        .ms-panel-body form .form-row {
            margin-bottom: 15px;
        }

        .ms-panel-body form .col-md-6 {
            padding-right: 15px;
            padding-left: 15px;
        }

        .ms-panel-body form .col-md-12 textarea {
            margin-bottom: 10px;
        }

        /* For better button alignment */
        .ms-panel-body .text-center {
            margin-top: 20px;
        }

        .ms-panel-body form button {
            display: inline-block;
            width: 30%;
        }
    </style>

    <title>Liste des docteurs</title>

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
            margin-left: 0 3%;
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

        .edit {
            color: #28a745;
            transition: color 0.3s ease;
        }

        .edit:hover {
            color: #1e7e34;
        }

        .delete {
            color: #dc3545;
            transition: color 0.3s ease;
        }

        .delete:hover {
            color: #c82333;
        }
    </style>

    <div class="row" style="width:100%; justify-content:center">
        @if (Session::get('success1')) <!-- Pour la suppression -->
            <script>
                Swal.fire({
                    icon: 'success',
                    title: 'Suppression réussie',
                    text: '{{ Session::get('success1') }}',
                    showConfirmButton: true,
                    confirmButtonText: 'OK',
                    background: '#ffcccc',
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
                    background: '#ccffcc',
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
                    background: '#f86750',
                    color: '#ffffff'
                });
            </script>
        @endif
    </div>

    <div class="container col-md-12">
        <h1>Liste des directeurs de l'hôpital</h1>
    
        <table id="patients-table" class="display">
            <thead >
                <tr class="text-center">
                    <th class="text-center">Nom</th>
                    <th class="text-center">Prénoms</th>
                    <th class="text-center">Email</th>
                    <th class="text-center">Contact</th>
                    <th class="text-center">Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($directors as $director)
                <tr class="text-center">
                    <td>{{ $director->name }}</td>
                    <td>{{ $director->prenom }}</td>
                    <td>{{ $director->email }}</td>
                    <td>{{ $director->contact }}</td>
                    <td>
                        <button class="edit"><a href="#" class="edit"><i class="fas fa-edit"></i></a></button>
                        <button class="delete"><a href="#" class="delete"><i class="fas fa-trash"></i></a></button>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center">Aucun directeur inscrire</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
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
    </script>

@endsection