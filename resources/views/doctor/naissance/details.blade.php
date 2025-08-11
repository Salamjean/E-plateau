@extends('doctor.layouts.template')

@section('content')
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des déclarations</title>
    
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
            font-size: 25px;
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
        

        <div class="container">
            <h1>Détails de la déclarations de naissance de l'enfant de {{ $naisshop->NomM }}</h1>
            <div class="header" style="margin-left:40%">
                <a href="{{ route('statement.index') }}" class="add-patient"> Listes des déclarations</a>
            </div>

            <table id="patients-table" class="display text-center">
                <tr>
                    <th>Numéro du Certificat Médical de Naissance</th>
                    <td>{{ $naisshop->codeCMN }}</td>
                </tr>
                <tr>
                    <th>Nom de la Mère</th>
                    <td>{{ $naisshop->NomM }}</td>
                </tr>
                <tr>
                    <th>Prénom de la Mère</th>
                    <td>{{ $naisshop->PrM }}</td>
                </tr>
                <tr>
                    <th>Contact de la Mère</th>
                    <td>{{ $naisshop->contM }}</td>
                </tr>
                <tr>
                    <th>Identité de la Mère (CNI)</th>
                    <td>
                        @if (pathinfo($naisshop->CNI_mere, PATHINFO_EXTENSION) === 'pdf')
                                        <a href="{{ asset('storage/' . $naisshop->CNI_mere) }}" target="_blank">
                                            <img src="{{ asset('assets/assets/img/pdf.jpg') }}" alt="PDF" width="100" height="auto">
                                        </a>
                                    @else
                                        <img src="{{ asset('storage/' . $naisshop->CNI_mere) }}" 
                                             alt="Pièce du parent" 
                                             width="100" 
                                             height="auto" 
                                             onclick="showImage(this)" 
                                             onerror="this.onerror=null; this.src='{{ asset('assets/images/profiles/bébé.jpg') }}'">
                                    @endif
                    </td>
                </tr>
                <tr>
                    <th>Nom de l'accompagnateur</th>
                    <td>{{ $naisshop->NomP }}</td>
                </tr>
                <tr>
                    <th>Prénom de l'accompagnateur</th>
                    <td>{{ $naisshop->PrP }}</td>
                </tr>
                <tr>
                    <th>Contact de l'accompagnateur</th>
                    <td>{{ $naisshop->contP }}</td>
                </tr>
                <tr>
                    <th>Hôpital de Naissance</th>
                    <td>{{ $naisshop->NomEnf }}</td>
                </tr>
                <tr>
                    <th>Commune de Naissance</th>
                    <td>{{ $naisshop->commune }}</td>
                </tr>
                <tr>
                    <th>Nombre d'enfant</th>
                    <td class="text-center">
                        @if ($naisshop->enfants->isNotEmpty())
                            {{ $naisshop->enfants->first()->nombreEnf }}  {{-- Get nombreEnf from the *first* child --}}
                        @else
                            Aucun enfant enregistré
                        @endif
                    </td>
                </tr>
                <tr>
                    <th>Date de Naissance</th>
                    <td class="text-center">
                        @if ($naisshop->enfants->isNotEmpty())
                            <ul class="text-center">
                                @foreach ($naisshop->enfants as $enfant)
                                    <li>
                                        <strong> Enfant {{ $loop->iteration }} </strong> <br>
                                        Date Naissance: {{ \Carbon\Carbon::parse($enfant->date_naissance)->format('d/m/Y') }} <br>
                                        Sexe: {{ $enfant->sexe }}
                                    </li>
                                @endforeach
                            </ul>
                        @else
                            Aucun enfant enregistré
                        @endif
                    </td>
                </tr>
            </table>
        </div>
  

    
</body>
</html>
@endsection