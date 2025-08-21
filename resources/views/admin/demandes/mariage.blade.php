@extends('admin.layouts.template')

@section('content')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
<style>
    .etat-en-attente {
      background-color: orange;
      color: black;
      display: flex;
  }
  
  .etat-validee {
      background-color: green;
      color: white;
  }
  
  .etat-refusee {
      background-color: red;
      color: white;
  }
  .btn{
    background-color: rgb(199, 195, 195);
  }
  
  </style>
<div class="container-fluid" id="container-wrapper">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Listes des demandes d'extraits de Mariage</h1>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Accueil</a></li>
            <li class="breadcrumb-item active" aria-current="page">Tables</li>
        </ol>
    </div>

   

    <!-- Mariages avec fichiers seulement (champ manquants) -->
    <div class="row">
        <div class="col-lg-12">
            <div class="card mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Demande d'extrait de mariage</h6>
                </div>
                <div class="table-responsive p-3">
                    <!-- Champ de recherche -->
                    <input type="text" id="searchInput" class="form-control mb-3" placeholder="Rechercher...">
                
                    <table class="table align-items-center table-flush" id="dataTable">
                        <thead class="bg-navbar text-white">
                            <tr  style="font-size: 12px">
                                <th class="text-center">Commune</th>
                                <th class="text-center">Nom du demandeur</th>
                                <th class="text-center">Nom de l'Époux</th>
                                <th class="text-center">Prénom de l'Époux</th>
                                <th class="text-center">Date de Naissance</th>
                                <th class="text-center">Lieu de Naissance</th>
                                <th>Agent</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($mariages as $mariage)
                            <tr class="text-center" style="font-size: 12px">
                                <td>{{ strtoupper($mariage->commune)}}
                                <td>{{ $mariage->user ? $mariage->user->name : 'Demandeur inconnu' }}
                                <td>{{ $mariage->nomEpoux ?? 'Copie simple'}} </td>
                                <td>{{ $mariage->prenomEpoux  ?? 'Copie simple'}}</td>
                                <td>{{ $mariage->dateNaissanceEpoux  ?? 'Copie simple'}}</td>
                                <td>{{ $mariage->lieuNaissanceEpoux  ?? 'Copie simple'}}</td>
                                <td>{{ $mariage->agent ? $mariage->agent->name . ' ' . $mariage->agent->prenom : 'Non attribué' }}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="8" class="text-center">Aucune déclaration trouvée</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                
                <script>
                    document.getElementById('searchInput').addEventListener('keyup', function() {
                        const filter = this.value.toLowerCase();
                        const rows = document.querySelectorAll('#dataTable tbody tr');
                
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
    </div>
@endsection










  
