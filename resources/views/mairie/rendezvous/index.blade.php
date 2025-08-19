@extends('mairie.layouts.template')

@section('content')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<style>
  :root {
    --primary-color: #0033c4;
    --primary-light: #3d5afe;
    --primary-dark: #001f8e;
    --secondary-color: #ffffff;
    --success-color: #28a745;
    --warning-color: #ffc107;
    --danger-color: #dc3545;
    --light-color: #f8f9fa;
    --dark-color: #343a40;
    --border-radius: 8px;
    --box-shadow: 0 4px 12px rgba(0, 51, 196, 0.1);
    --transition: all 0.3s ease;
  }

  body {
    background-color: #f8f9fa;
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    color: #333;
  }

  .card {
    border: none;
    border-radius: var(--border-radius);
    box-shadow: var(--box-shadow);
    transition: var(--transition);
    margin-bottom: 25px;
    background-color: var(--secondary-color);
  }

  .card:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 20px rgba(0, 51, 196, 0.15);
  }

  .card-header {
    background-color: var(--primary-color);
    color: var(--secondary-color);
    border-radius: var(--border-radius) var(--border-radius) 0 0 !important;
    padding: 15px 20px;
    font-weight: 600;
    border-bottom: none;
  }

  .table-responsive {
    border-radius: var(--border-radius);
    overflow: hidden;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
  }

  .table {
    margin-bottom: 0;
    background-color: var(--secondary-color);
  }

  .table thead th {
    background-color: #f1f5ff;
    color: #0033c4;
    font-weight: 600;
    border: none;
    padding: 12px 15px;
    vertical-align: middle;
  }

  .table tbody tr {
    transition: var(--transition);
  }

  .table tbody tr:hover {
    background-color: rgba(0, 51, 196, 0.05);
  }

  .table tbody td {
    padding: 12px 15px;
    vertical-align: middle;
    border-top: 1px solid rgba(0, 0, 0, 0.03);
  }

  .status-badge {
    padding: 6px 12px;
    border-radius: 20px;
    font-size: 12px;
    font-weight: 600;
    text-transform: uppercase;
    display: inline-block;
    min-width: 100px;
    text-align: center;
  }

  .status-en-attente {
    background-color: var(--warning-color);
    color: var(--dark-color);
  }

  .status-validee {
    background-color: var(--success-color);
    color: var(--secondary-color);
  }

  .status-refusee {
    background-color: var(--danger-color);
    color: var(--secondary-color);
  }

  .search-box {
    position: relative;
    margin-bottom: 20px;
    max-width: 300px;
  }

  .search-box input {
    padding-left: 40px;
    border-radius: 20px;
    border: 1px solid #ddd;
    box-shadow: none;
    transition: var(--transition);
  }

  .search-box input:focus {
    border-color: var(--primary-light);
    box-shadow: 0 0 0 0.2rem rgba(0, 51, 196, 0.1);
  }

  .search-box i {
    position: absolute;
    left: 15px;
    top: 10px;
    color: var(--primary-color);
  }

  .img-thumbnail {
    width: 50px;
    height: 50px;
    object-fit: cover;
    border-radius: 4px;
    cursor: pointer;
    transition: var(--transition);
    border: 1px solid rgba(0, 51, 196, 0.1);
    background-color: var(--secondary-color);
  }

  .img-thumbnail:hover {
    transform: scale(1.1);
    box-shadow: 0 4px 8px rgba(0, 51, 196, 0.2);
    border-color: var(--primary-light);
  }

  .pdf-icon {
    width: 30px;
    height: 30px;
    cursor: pointer;
    transition: var(--transition);
  }

  .pdf-icon:hover {
    transform: scale(1.1);
  }

  .breadcrumb {
    background-color: transparent;
    padding: 0;
    font-size: 14px;
  }

  .breadcrumb-item a {
    color: var(--primary-color);
    text-decoration: none;
    transition: var(--transition);
  }

  .breadcrumb-item a:hover {
    color: var(--primary-dark);
    text-decoration: underline;
  }

  .breadcrumb-item.active {
    color: var(--primary-dark);
    font-weight: 500;
  }

  .page-title {
    color: var(--primary-dark);
    font-weight: 700;
    margin-bottom: 20px;
  }

  .modal-content {
    border-radius: var(--border-radius);
    border: none;
    box-shadow: 0 5px 20px rgba(0, 51, 196, 0.2);
  }

  .modal-header {
    background-color: var(--primary-color);
    color: var(--secondary-color);
    border-radius: var(--border-radius) var(--border-radius) 0 0;
    border-bottom: none;
  }

  .modal-body img {
    max-height: 70vh;
    width: auto;
    margin: 0 auto;
    display: block;
    border-radius: 4px;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
  }

  .empty-state {
    text-align: center;
    padding: 40px 0;
    color: #6c757d;
  }

  .empty-state i {
    font-size: 50px;
    margin-bottom: 15px;
    color: var(--primary-light);
  }

  .badge-agent {
    background-color: var(--primary-color);
    color: var(--secondary-color);
    padding: 4px 8px;
    border-radius: 4px;
    font-size: 12px;
    font-weight: 500;
  }

  .document-container {
    position: relative;
    width: 60px;
    height: 60px;
    margin: 0 auto;
  }

  .document-placeholder {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    font-size: 12px;
    color: gray;
    text-align: center;
    width: 100%;
  }

  .btn-close {
    filter: invert(1);
  }

  @media (max-width: 768px) {
    .table-responsive {
      border: 1px solid rgba(0, 51, 196, 0.1);
    }
    
    .table thead {
      display: none;
    }
    
    .table tbody tr {
      display: block;
      margin-bottom: 15px;
      border: 1px solid rgba(0, 51, 196, 0.1);
      border-radius: var(--border-radius);
      box-shadow: 0 2px 5px rgba(0, 51, 196, 0.05);
    }
    
    .table tbody td {
      display: block;
      text-align: right;
      padding-left: 50%;
      position: relative;
      border-top: 1px solid rgba(0, 51, 196, 0.05);
    }
    
    .table tbody td::before {
      content: attr(data-label);
      position: absolute;
      left: 15px;
      width: 45%;
      padding-right: 10px;
      font-weight: 600;
      text-align: left;
      color: var(--primary-color);
    }
    
    .img-thumbnail {
      float: right;
    }

    .page-title {
      font-size: 1.5rem;
    }

    .card-header {
      flex-direction: column;
      align-items: flex-start;
    }

    .search-box {
      max-width: 100%;
      width: 100%;
      margin-top: 10px;
    }
  }
</style>

<div class="container-fluid">
  <!-- Notifications SweetAlert -->
  <div class="row" style="width:100%; justify-content:center">
    @if (Session::get('success1'))
      <script>
        Swal.fire({
          icon: 'success',
          title: 'Suppression réussie',
          text: '{{ Session::get('success1') }}',
          showConfirmButton: true,
          confirmButtonText: 'OK',
          customClass: {
            popup: 'custom-swal-popup',
            confirmButton: 'btn-swal-confirm'
          }
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
          customClass: {
            popup: 'custom-swal-popup',
            confirmButton: 'btn-swal-confirm'
          }
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
          customClass: {
            popup: 'custom-swal-popup',
            confirmButton: 'btn-swal-confirm'
          }
        });
      </script>
    @endif
  </div>

  <!-- En-tête de page -->
  <div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="page-title"><i class="fas fa-home me-2 mt-4" style="color: var(--primary-color);"></i>Liste des hôpitaux du plateau</h1>
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="{{ route('mairie.dashboard') }}"><i class="fas fa-home"></i> Accueil</a></li>
      <li class="breadcrumb-item active">hôpitaux</li>
    </ol>
  </div>

  <!-- Première table - Décès déclarés -->
  <div class="row">
    <div class="col-lg-12">
      <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
          <h6 class="m-0 font-weight-bold"><i class="fas fa-user me-2"> </i>Hôpital du plateau</h6>
          <div class="search-box">
            <i class="fas fa-search"></i>
            <input type="text" id="searchInput1" class="form-control" placeholder="Rechercher...">
          </div>
        </div>
        <div class="table-responsive">
          <table class="table align-items-center" id="dataTable1">
            <thead>
                <tr class="text-center">
                    <th>Informations époux</th>
                    <th>Informations épouse</th>
                    <th>Contact</th>
                    <th>Rendez-vous</th>
                </tr>
            </thead>
            <tbody>
              @forelse ($rendezvous as $item)
                            <tr class="animate__animated animate__fadeIn">
                                 <td class="text-center" style="text-align: center">
                                    <div  style="text-align: center">
                                    
                                        <div class="text-center" style="text-align: center">
                                            <h6 class="mb-1 text-muted">Nom: <span class="text-black">{{ $item->nom_epoux.' '.$item->prenom_epoux }} </span></h6>
                                            <h6 class="mb-1 text-muted">Date Naiss: <span class="text-black">{{ $item->date_naissance_epoux }}  </span></h6>
                                            <small class="mb-1 text-muted">Lieu Naiss: <span class="text-black">{{ $item->lieu_naissance_epoux }}  </span></small>
                                        </div>
                                    </div>
                                 </td>
                                <td class="text-center" style="text-align: center">
                                    <div  style="text-align: center">
                                    
                                        <div class="text-center" style="text-align: center">
                                            <h6 class="mb-1 text-muted">Nom: <span class="text-black">{{ $item->nom_epouse.' '.$item->prenom_epouse }} </span></h6>
                                            <h6 class="mb-1 text-muted">Date Naiss: <span class="text-black">{{ $item->date_naissance_epouse }} </span></h6>
                                            <small class="mb-1 text-muted">Lieu Naiss: <span class="text-black">{{ $item->lieu_naissance_epouse }}</span></small>
                                        </div>
                                    </div>
                                 </td>
                                <td class="text-center" style="text-align: center">
                                    <div  style="text-align: center">
                                    
                                        <div class="text-center" style="text-align: center">
                                            <h6 class="mb-1 text-muted">Adresse: <span class="text-black">{{ $item->adresse }}</span></h6>
                                            <h6 class="mb-1 text-muted">Contact: <span class="text-black">{{ $item->telephone }}</span></h6>
                                            <small class="mb-1 text-muted">Email: <span class="text-black">{{ $item->email }}</span></small>
                                        </div>
                                    </div>
                                 </td>
                                 
                                <td class="text-center" style="text-align: center">
                                    <div  style="text-align: center">
                                    
                                        <div class="text-center" style="text-align: center">
                                            <h6 class="mb-1 text-muted">Date: <span class="text-black">{{ $item->date_mariage_souhaitee }}</span></h6>
                                            <h6 class="mb-1 text-muted">Heure: <span class="text-black">{{ $item->heure_souhaitee }}</span></h6>
                                           @php
                                                $badgeClasses = [
                                                    'en attente' => 'bg-warning text-white',
                                                    'confirmé' => 'bg-success text-white',
                                                    'annulé' => 'bg-danger text-white',
                                                    'terminé' => 'bg-primary text-white',
                                                    'reporté' => 'bg-info text-dark'
                                                ];
                                                
                                                $defaultClass = 'bg-secondary text-white';
                                            @endphp

                                            <span class="badge {{ $badgeClasses[$item->statut] ?? $defaultClass }}">
                                                {{ $item->statut }}
                                            </span>
                                        </div>
                                        <!-- Bouton modifier -->
                                        <button class="btn btn-sm btn-primary mt-2" data-bs-toggle="modal" data-bs-target="#editModal{{ $item->id }}">
                                            <i class="fas fa-edit"></i> Modifier
                                        </button>

                                    </div>
                                 </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="8">
                                    <div class="empty-state">
                                        <i class="fas fa-inbox"></i>
                                        <h5 class="mt-3">Aucun rendez vous trouvée</h5>
                                        <p class="text-muted">Vous n'avez effectué aucun rendez vous de mariage</p>
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

  <!-- Modal de modification -->
<div class="modal fade" id="editModal{{ $item->id }}" tabindex="-1" aria-labelledby="editModalLabel{{ $item->id }}" aria-hidden="true">
  <div class="modal-dialog">
    <form action="{{ route('rendezvous.update', $item->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel{{ $item->id }}">Modifier rendez-vous</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label for="date_mariage_souhaitee_{{ $item->id }}" class="form-label">Date souhaitée</label>
                    <input type="date" name="date_mariage_souhaitee" id="date_mariage_souhaitee_{{ $item->id }}" class="form-control" value="{{ $item->date_mariage_souhaitee }}" required>
                </div>
                <div class="mb-3">
                    <label for="heure_souhaitee_{{ $item->id }}" class="form-label">Heure souhaitée</label>
                    <input type="time" name="heure_souhaitee" id="heure_souhaitee_{{ $item->id }}" class="form-control" value="{{ $item->heure_souhaitee }}" required>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                <button type="submit" class="btn btn-primary">Enregistrer</button>
            </div>
        </div>
    </form>
  </div>
</div>


  @endsection