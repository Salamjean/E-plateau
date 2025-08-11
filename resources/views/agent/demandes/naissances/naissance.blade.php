@extends('agent.layouts.template')

@section('content')
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

<style>
  :root {
    --primary-color: #0033c4;
    --primary-light: #3a5bff;
    --primary-dark: #001f7a;
    --secondary-color: #2c3e50;
    --success-color: #28a745;
    --warning-color: #fd7e14;
    --danger-color: #dc3545;
    --light-color: #ffffff;
    --dark-color: #212529;
    --gray-color: #6c757d;
    --border-radius: 12px;
    --box-shadow: 0 8px 20px rgba(0, 51, 196, 0.1);
    --transition: all 0.3s ease;
  }

  body {
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    background-color: #f8f9fa;
  }

  .dashboard-container {
    padding: 2rem;
    max-width: 100%;
    margin: 0 10px;
  }

  .dashboard-title {
    color: var(--primary-color);
    font-weight: 700;
    margin-bottom: 1.5rem;
    position: relative;
    padding-bottom: 0.75rem;
  }

  .dashboard-title::after {
    content: '';
    position: absolute;
    bottom: 0;
    left: 0;
    width: 80px;
    height: 4px;
    background-color: var(--primary-color);
    border-radius: 2px;
  }

  .dashboard-card {
    border: none;
    border-radius: var(--border-radius);
    box-shadow: var(--box-shadow);
    transition: var(--transition);
    margin-bottom: 2rem;
    overflow: hidden;
    background-color: var(--light-color);
  }

  .dashboard-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 12px 25px rgba(0, 51, 196, 0.15);
  }

  .card-header {
    background-color: var(--primary-color);
    color: white;
    padding: 1.25rem 1.5rem;
    border-bottom: none;
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
  }

  .card-header h5 {
    margin: 0;
    font-size: 1.25rem;
    font-weight: 600;
    display: flex;
    align-items: center;
  }

  .card-header i {
    font-size: 1.25rem;
    margin-right: 0.75rem;
  }

  .table-responsive {
    border-radius: var(--border-radius);
    overflow: hidden;
  }

  .table {
    margin-bottom: 0;
    border-collapse: separate;
    border-spacing: 0;
  }

  .table thead th {
    background-color: #f1f5ff;
    color: var(--primary-color);
    font-weight: 600;
    border: none;
    padding: 1rem;
    vertical-align: middle;
    border-bottom: 2px solid #e0e8ff;
  }

  .table tbody tr {
    transition: var(--transition);
  }

  .table tbody tr:hover {
    background-color: rgba(0, 51, 196, 0.03);
  }

  .table tbody td {
    padding: 1rem;
    vertical-align: middle;
    border-top: 1px solid #f1f5ff;
  }

  .badge-status {
    padding: 0.5rem 0.75rem;
    border-radius: 20px;
    font-weight: 500;
    font-size: 0.75rem;
    text-transform: uppercase;
  }

  .badge-warning {
    background-color: var(--warning-color);
    color: white;
  }

  .badge-success {
    background-color: var(--success-color);
    color: white;
  }

  .badge-danger {
    background-color: var(--danger-color);
    color: white;
  }

  .btn-action {
    border-radius: var(--border-radius);
    font-weight: 500;
    padding: 0.5rem 1rem;
    transition: var(--transition);
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 0.5rem;
  }

  .btn-primary {
    background-color: var(--primary-color);
    border-color: var(--primary-color);
  }

  .btn-primary:hover {
    background-color: var(--primary-dark);
    border-color: var(--primary-dark);
  }

  .btn-danger {
    background-color: var(--danger-color);
    border-color: var(--danger-color);
  }

  .btn-sm {
    font-size: 0.75rem;
    padding: 0.375rem 0.75rem;
  }

  .search-box {
    position: relative;
    margin-bottom: 1rem;
    width: 100%;
    max-width: 300px;
  }

  .search-box input {
    padding-left: 2.5rem;
    border-radius: 20px;
    border: 1px solid #e0e8ff;
    transition: var(--transition);
  }

  .search-box input:focus {
    border-color: var(--primary-color);
    box-shadow: 0 0 0 3px rgba(0, 51, 196, 0.1);
  }

  .search-box i {
    position: absolute;
    left: 1rem;
    top: 50%;
    transform: translateY(-50%);
    color: var(--gray-color);
  }

  .document-preview {
    width: 50px;
    height: 50px;
    object-fit: cover;
    border-radius: 4px;
    cursor: pointer;
    transition: var(--transition);
  }

  .document-preview:hover {
    transform: scale(1.05);
    box-shadow: var(--box-shadow);
  }

  .delivery-badge {
    background-color: var(--danger-color);
    color: white;
    padding: 0.5rem 0.75rem;
    border-radius: var(--border-radius);
    font-weight: 500;
    cursor: pointer;
    transition: var(--transition);
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
  }

  .delivery-badge:hover {
    background-color: #c82333;
  }

  .user-link {
    color: var(--primary-color);
    font-weight: 500;
    cursor: pointer;
    text-decoration: none;
    transition: var(--transition);
  }

  .user-link:hover {
    color: var(--primary-dark);
    text-decoration: underline;
  }

  .modal-content {
    border-radius: var(--border-radius);
    border: none;
    box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
  }

  .modal-header {
    background-color: var(--primary-color);
    color: white;
    border-bottom: none;
  }

  .modal-body p {
    margin-bottom: 0.75rem;
  }

  .modal-body strong {
    color: var(--primary-color);
  }

  .empty-state {
    text-align: center;
    padding: 2rem 0;
    color: var(--gray-color);
  }

  .empty-state i {
    font-size: 3rem;
    margin-bottom: 1rem;
    color: #dee2e6;
  }

  .empty-state h5 {
    font-weight: 500;
    color: var(--secondary-color);
  }

  @media (max-width: 768px) {
    .dashboard-container {
      padding: 1rem;
    }
    
    .card-header {
      flex-direction: column;
      align-items: flex-start;
      gap: 1rem;
    }
    
    .search-box {
      max-width: 100%;
    }
    
    .table thead {
      display: none;
    }
    
    .table tbody tr {
      display: block;
      margin-bottom: 1rem;
      border: 1px solid #f1f5ff;
      border-radius: var(--border-radius);
      padding: 1rem;
    }
    
    .table tbody td {
      display: flex;
      justify-content: space-between;
      align-items: center;
      padding: 0.75rem;
      border: none;
      border-bottom: 1px solid #f1f5ff;
    }
    
    .table tbody td::before {
      content: attr(data-label);
      font-weight: 600;
      color: var(--primary-color);
      margin-right: 1rem;
    }
    
    .table tbody td:last-child {
      border-bottom: none;
    }
  }
</style>

<div class="dashboard-container">
  <!-- SweetAlert Notifications -->
  @if (Session::get('success1'))
    <script>
      Swal.fire({
        icon: 'success',
        title: 'Succès',
        text: '{{ Session::get('success1') }}',
        confirmButtonColor: '#0033c4',
        background: 'white'
      });
    </script>
  @endif

  @if (Session::get('success'))
    <script>
      Swal.fire({
        icon: 'success',
        title: 'Succès',
        text: '{{ Session::get('success') }}',
        confirmButtonColor: '#0033c4',
        background: 'white'
      });
    </script>
  @endif

  @if (Session::get('error'))
    <script>
      Swal.fire({
        icon: 'error',
        title: 'Erreur',
        text: '{{ Session::get('error') }}',
        confirmButtonColor: '#0033c4',
        background: 'white'
      });
    </script>
  @endif

  <!-- Page Header -->
  <div class="d-flex justify-content-between align-items-center mb-4">
    <div>
      <h1 class="dashboard-title">
        <i class="fas fa-baby me-2"></i>Gestion des demandes d'extrait de naissance
      </h1>
    </div>
  </div>

  <!-- First Table: With Certificate -->
  <div class="dashboard-card mb-4">
    <div class="card-header d-flex justify-content-between align-items-center">
      <h5><i class="fas fa-file-medical me-2"></i>Demandes avec certificat médical</h5>
      <div class="search-box">
        <i class="fas fa-search"></i>
        <input type="text" id="searchInput1" class="form-control" placeholder="Rechercher...">
      </div>
    </div>
    <div class="table-responsive">
      <table class="table align-items-center" id="dataTable1">
        <thead>
          <tr class="text-center">
            <th>Demandeur</th>
            <th>Hôpital</th>
            <th>Nouveau Né</th>
            <th>Date Naiss.</th>
            <th>Mère</th>
            <th>Père</th>
            <th>Pièces</th>
            <th>État</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          @forelse ($naissances as $naissance)
          <tr class="text-center">
            <td>
              @if($naissance->user)
                <a href="#" class="user-link" data-bs-toggle="modal" data-bs-target="#userModal" onclick="showUserModal({{ json_encode($naissance->user) }})">
                  {{ $naissance->user->name.' '.$naissance->user->prenom }}
                </a>
              @else
                <span class="text-muted">Inconnu</span>
              @endif
            </td>
            <td>{{ $naissance->nomHopital }}</td>
            <td>{{ $naissance->nom .' '.$naissance->prenom }}</td>
            <td>{{ $naissance->lieuNaiss }}</td>
            <td>{{ $naissance->nomDefunt }}</td>
            <td>{{ $naissance->nompere.' '.$naissance->prenompere }}</td>
            <td>
              <div class="d-flex justify-content-center gap-2">
                @if($naissance->identiteDeclarant)
                  @php
                    $identiteDeclarantPath = asset('storage/' . $naissance->identiteDeclarant);
                    $isIdentiteDeclarantPdf = strtolower(pathinfo($identiteDeclarantPath, PATHINFO_EXTENSION)) === 'pdf';
                  @endphp
                  @if ($isIdentiteDeclarantPdf)
                    <a href="{{ $identiteDeclarantPath }}" target="_blank" class="document-preview">
                      <img src="{{ asset('assets/assets/img/pdf.jpg') }}" alt="PDF" class="document-preview">
                    </a>
                  @else
                    <img src="{{ $identiteDeclarantPath }}" 
                      alt="Pièce parent" 
                      class="document-preview"
                      data-bs-toggle="modal" 
                      data-bs-target="#imageModal" 
                      onclick="showImage(this)" 
                      onerror="this.onerror=null; this.src='{{ asset('assets/images/profiles/bébé.jpg') }}'">
                  @endif
                @else
                  <span class="badge bg-secondary">N/A</span>
                @endif

                @if($naissance->cdnaiss)
                  @php
                    $cdnaissPath = asset('storage/' . $naissance->cdnaiss);
                    $isCdnaissPdf = strtolower(pathinfo($cdnaissPath, PATHINFO_EXTENSION)) === 'pdf';
                  @endphp
                  @if ($isCdnaissPdf)
                    <a href="{{ $cdnaissPath }}" target="_blank" class="document-preview">
                      <img src="{{ asset('assets/assets/img/pdf.jpg') }}" alt="PDF" class="document-preview">
                    </a>
                  @else
                    <img src="{{ $cdnaissPath }}" 
                      alt="Certificat" 
                      class="document-preview"
                      data-bs-toggle="modal" 
                      data-bs-target="#imageModal" 
                      onclick="showImage(this)" 
                      onerror="this.onerror=null; this.src='{{ asset('assets/images/profiles/bébé.jpg') }}'">
                  @endif
                @else
                  <span class="badge bg-secondary">N/A</span>
                @endif
              </div>
            </td>
            <td>
              <span class="badge-status 
                @if($naissance->etat == 'en attente') badge-warning
                @elseif($naissance->etat == 'réçu') badge-success
                @else badge-danger @endif">
                {{ $naissance->etat }}
              </span>
            </td>
            <td>
              <div class="d-flex justify-content-center gap-2">
                <a href="{{ route('agent.demandes.naissance.edit', $naissance->id) }}" class="btn btn-sm btn-primary">
                  <i class="fas fa-pencil-alt"></i>
                </a>
                
                @if($naissance->choix_option == 'livraison')
                  <a href="#" class="delivery-badge btn-sm" data-bs-toggle="modal" data-bs-target="#livraisonModal" onclick="showLivraison1Modal({{ json_encode($naissance) }})">
                    <i class="fas fa-truck"></i> Livraison
                  </a>
                @else
                  <span class="badge bg-secondary">Retrait</span>
                @endif
                
                <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#annulationModal" data-demande-id="{{ $naissance->id }}">
                  <i class="fas fa-times-circle"></i>
                </button>
              </div>
            </td>
          </tr>
          @empty
          <tr>
            <td colspan="9" class="empty-state">
              <i class="fas fa-baby-carriage"></i>
              <h5>Aucune demande trouvée</h5>
            </td>
          </tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>

  <!-- Second Table: Without Certificate -->
  <div class="dashboard-card mb-4">
    <div class="card-header d-flex justify-content-between align-items-center">
      <h5><i class="fas fa-file-alt me-2"></i>Demandes sans certificat médical</h5>
      <div class="search-box">
        <i class="fas fa-search"></i>
        <input type="text" id="searchInput2" class="form-control" placeholder="Rechercher...">
      </div>
    </div>
    <div class="table-responsive">
      <table class="table align-items-center" id="dataTable2">
        <thead>
          <tr class="text-center">
            <th>Demandeur</th>
            <th>Type</th>
            <th>Nom Extrait</th>
            <th>N° Registre</th>
            <th>Date Registre</th>
            <th>CNI</th>
            <th>État</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          @forelse ($naissancesD as $naissanceD)
          <tr class="text-center">
            <td>
              @if($naissanceD->user)
                <a href="#" class="user-link" data-bs-toggle="modal" data-bs-target="#userModal" onclick="showUserModal({{ json_encode($naissanceD->user) }})">
                  {{ $naissanceD->user->name .' '.$naissanceD->user->prenom }}
                </a>
              @else
                <span class="text-muted">Inconnu</span>
              @endif
            </td>
            <td>{{ $naissanceD->type }}</td>
            <td>{{ $naissanceD->name.' '.$naissanceD->prenom .' ('.$naissanceD->pour.')'}}</td>
            <td>{{ $naissanceD->number }}</td>
            <td>{{ $naissanceD->DateR }}</td>
            <td>
              @if($naissanceD->CNI)
                @php
                  $CNIPath = asset('storage/' . $naissanceD->CNI);
                  $isCNIPdf = strtolower(pathinfo($CNIPath, PATHINFO_EXTENSION)) === 'pdf';
                @endphp
                @if ($isCNIPdf)
                  <a href="{{ $CNIPath }}" target="_blank" class="document-preview">
                    <img src="{{ asset('assets/assets/img/pdf.jpg') }}" alt="PDF" class="document-preview">
                  </a>
                @else
                  <img src="{{ $CNIPath }}"
                    alt="CNI" 
                    class="document-preview"
                    data-bs-toggle="modal" 
                    data-bs-target="#imageModal" 
                    onclick="showImage(this)" 
                    onerror="this.onerror=null; this.src='{{ asset('assets/images/profiles/bébé.jpg') }}'">
                @endif
              @else
                <span class="badge bg-secondary">N/A</span>
              @endif
            </td>
            <td>
              <span class="badge-status 
                @if($naissanceD->etat == 'en attente') badge-warning
                @elseif($naissanceD->etat == 'réçu') badge-success
                @else badge-danger @endif">
                {{ $naissanceD->etat }}
              </span>
            </td>
            <td>
              <div class="d-flex justify-content-center gap-2">
                <a href="{{ route('agent.demandes.naissance.edit.simple', $naissanceD->id) }}" class="btn btn-sm btn-primary">
                  <i class="fas fa-pencil-alt"></i>
                </a>
                
                @if($naissanceD->choix_option == 'livraison')
                  <a href="#" class="delivery-badge btn-sm" data-bs-toggle="modal" data-bs-target="#livraisonModal" onclick="showLivraisonModal({{ json_encode($naissanceD) }})">
                    <i class="fas fa-truck"></i> Livraison
                  </a>
                @else
                  <span class="badge bg-secondary">Retrait</span>
                @endif
              </div>
            </td>
          </tr>
          @empty
          <tr>
            <td colspan="8" class="empty-state">
              <i class="fas fa-file-alt"></i>
              <h5>Aucune demande trouvée</h5>
            </td>
          </tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>

  <!-- Annulation Modal -->
  <div class="modal fade" id="annulationModal" tabindex="-1" aria-labelledby="annulationModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="annulationModalLabel">Motif d'annulation</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
        </div>
        <div class="modal-body">
          <form id="annulationForm" method="POST" action="{{ route('agent.demandes.naissance.annuler', 'demandeId') }}">
            @csrf
            @method('post')
            <input type="hidden" name="demande_id" id="demande_id_input" value="">
    
            <div class="mb-3">
              <label for="motif_annulation" class="form-label">Motif d'annulation:</label>
              <select class="form-select" id="motif_annulation" name="motif_annulation" required>
                <option value="Une erreur du demandeur">Erreur du demandeur</option>
                <option value="Document Incomplet ou Incorret">Document incomplet/incorrect</option>
                <option value="Demande dupliquée">Demande dupliquée</option>
                <option value="autre">Autre motif</option>
              </select>
            </div>
            <div class="mb-3" id="autreMotifDiv" style="display: none;">
              <label for="autre_motif_text" class="form-label">Précisez le motif:</label>
              <textarea class="form-control" id="autre_motif_text" name="autre_motif_text" rows="3"></textarea>
            </div>
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
          <button type="button" class="btn btn-danger" onclick="submitAnnulationForm()">
            <i class="fas fa-times-circle me-1"></i> Annuler
          </button>
        </div>
      </div>
    </div>
  </div>
  
  <!-- Image Preview Modal -->
  <div class="modal fade" id="imageModal" tabindex="-1" aria-labelledby="imageModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="imageModalLabel">Aperçu du document</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
        </div>
        <div class="modal-body text-center">
          <img id="modalImage" src="{{ asset('assets/images/profiles/bébé.jpg') }}" alt="Document" class="img-fluid rounded">
        </div>
      </div>
    </div>
  </div>
  
  <!-- User Info Modal -->
  <div class="modal fade" id="userModal" tabindex="-1" aria-labelledby="userModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="userModalLabel">Informations du demandeur</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
        </div>
        <div class="modal-body">
          <div id="userDetails" class="row">
            <!-- Content will be loaded here -->
          </div>
        </div>
      </div>
    </div>
  </div>
  
  <!-- Livraison Info Modal -->
  <div class="modal fade" id="livraisonModal" tabindex="-1" aria-labelledby="livraisonModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="livraisonModalLabel">Détails de livraison</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
        </div>
        <div class="modal-body">
          <div id="livraisonDetails">
            <!-- Content will be loaded here -->
          </div>
        </div>
        <div class="modal-footer">
          <a href="#" class="btn btn-primary">
            <i class="fas fa-truck me-1"></i> Gérer la livraison
          </a>
        </div>
      </div>
    </div>
  </div>
</div>

<script>
  // Initialize modals and search functionality
  document.addEventListener('DOMContentLoaded', function() {
    // Search functionality for first table
    document.getElementById('searchInput1').addEventListener('keyup', function() {
      const filter = this.value.toLowerCase();
      const rows = document.querySelectorAll('#dataTable1 tbody tr');
  
      rows.forEach(row => {
        const cells = row.querySelectorAll('td');
        const match = Array.from(cells).some(cell => 
          cell.textContent.toLowerCase().includes(filter)
        );
        row.style.display = match ? '' : 'none';
      });
    });
    
    // Search functionality for second table
    document.getElementById('searchInput2').addEventListener('keyup', function() {
      const filter = this.value.toLowerCase();
      const rows = document.querySelectorAll('#dataTable2 tbody tr');
  
      rows.forEach(row => {
        const cells = row.querySelectorAll('td');
        const match = Array.from(cells).some(cell => 
          cell.textContent.toLowerCase().includes(filter)
        );
        row.style.display = match ? '' : 'none';
      });
    });
    
    // Annulation modal setup
    const annulationModal = document.getElementById('annulationModal');
    if (annulationModal) {
      annulationModal.addEventListener('show.bs.modal', function(event) {
        const button = event.relatedTarget;
        const demandeId = button.getAttribute('data-demande-id');
        document.getElementById('demande_id_input').value = demandeId;
        
        let formAction = "{{ route('agent.demandes.naissance.annuler', 'demandeId') }}";
        formAction = formAction.replace('demandeId', demandeId);
        document.getElementById('annulationForm').action = formAction;
      });
    }
    
    // Motif selection logic
    const motifSelect = document.getElementById('motif_annulation');
    const autreMotifDiv = document.getElementById('autreMotifDiv');
    
    if (motifSelect && autreMotifDiv) {
      motifSelect.addEventListener('change', function() {
        if (this.value === 'autre') {
          autreMotifDiv.style.display = 'block';
          document.getElementById('autre_motif_text').setAttribute('required', 'required');
        } else {
          autreMotifDiv.style.display = 'none';
          document.getElementById('autre_motif_text').removeAttribute('required');
        }
      });
    }
  });
  
  function submitAnnulationForm() {
    document.getElementById('annulationForm').submit();
  }
  
  function showImage(imageElement) {
    const modalImage = document.getElementById('modalImage');
    modalImage.src = imageElement.src.includes('assets/images/profiles/bébé.jpg') ? 
      imageElement.src : 
      imageElement.src;
  }
  
  function showUserModal(user) {
    const userDetailsDiv = document.getElementById('userDetails');
    userDetailsDiv.innerHTML = `
      <div class="col-md-6 mb-3">
        <div class="card border-0 bg-light p-3 h-100">
          <h6 class="text-primary mb-3">Identité</h6>
          <p><strong>Nom:</strong> ${user.name}</p>
          <p><strong>Prénom(s):</strong> ${user.prenom}</p>
          <p><strong>Email:</strong> ${user.email}</p>
        </div>
      </div>
      <div class="col-md-6 mb-3">
        <div class="card border-0 bg-light p-3 h-100">
          <h6 class="text-primary mb-3">Contact</h6>
          <p><strong>Téléphone:</strong> ${user.contact}</p>
          <p><strong>Commune:</strong> ${user.commune}</p>
          <p><strong>N°CMU:</strong> ${user.CMU || 'N/A'}</p>
        </div>
      </div>
    `;
  }
  
  function showLivraisonModal(naissanceD) {
    const livraisonDetailsDiv = document.getElementById('livraisonDetails');
    livraisonDetailsDiv.innerHTML = `
      <div class="mb-4">
        <h6 class="text-primary mb-3">Destinataire</h6>
        <p><strong>Nom complet:</strong> ${naissanceD.nom_destinataire} ${naissanceD.prenom_destinataire}</p>
        <p><strong>Contact:</strong> ${naissanceD.contact_destinataire}</p>
        <p><strong>Email:</strong> ${naissanceD.email_destinataire}</p>
      </div>
      <div class="mb-4">
        <h6 class="text-primary mb-3">Adresse de livraison</h6>
        <p><strong>Adresse:</strong> ${naissanceD.adresse_livraison}</p>
        <p><strong>Ville/Commune:</strong> ${naissanceD.ville}, ${naissanceD.commune}</p>
        <p><strong>Quartier:</strong> ${naissanceD.quartier}</p>
        <p><strong>Code postal:</strong> ${naissanceD.code_postal}</p>
      </div>
    `;
  }
  
  function showLivraison1Modal(naissance) {
    const livraisonDetailsDiv = document.getElementById('livraisonDetails');
    livraisonDetailsDiv.innerHTML = `
      <div class="mb-4">
        <h6 class="text-primary mb-3">Destinataire</h6>
        <p><strong>Nom complet:</strong> ${naissance.nom_destinataire} ${naissance.prenom_destinataire}</p>
        <p><strong>Contact:</strong> ${naissance.contact_destinataire}</p>
        <p><strong>Email:</strong> ${naissance.email_destinataire}</p>
      </div>
      <div class="mb-4">
        <h6 class="text-primary mb-3">Adresse de livraison</h6>
        <p><strong>Adresse:</strong> ${naissance.adresse_livraison}</p>
        <p><strong>Ville/Commune:</strong> ${naissance.ville}, ${naissance.commune}</p>
        <p><strong>Quartier:</strong> ${naissance.quartier}</p>
        <p><strong>Code postal:</strong> ${naissance.code_postal}</p>
      </div>
    `;
  }
</script>
@endsection