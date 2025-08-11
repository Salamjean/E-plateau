@extends('agent.layouts.template')

@section('content')
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<style>
  :root {
    --primary-color: #0033c4;
    --primary-light: #3d5afe;
    --secondary-color: #f5f7fb;
    --success-color: #4cc9f0;
    --danger-color: #f72585;
    --warning-color: #f8961e;
    --light-color: #f8f9fa;
    --dark-color: #212529;
    --border-radius: 10px;
    --box-shadow: 0 4px 12px rgba(0, 51, 196, 0.1);
    --transition: all 0.3s ease;
  }

  body {
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    background-color: var(--secondary-color);
  }

  .card {
    border: none;
    border-radius: var(--border-radius);
    box-shadow: var(--box-shadow);
    transition: var(--transition);
    overflow: hidden;
    margin-bottom: 2rem;
  }

  .card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 25px rgba(0, 51, 196, 0.15);
  }

  .card-header {
    background-color: var(--primary-color);
    color: white;
    padding: 1.25rem 1.5rem;
    border-bottom: none;
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
    color: #0033c4;
    border: none;
    font-weight: 500;
    padding: 1rem;
    text-transform: uppercase;
    font-size: 0.75rem;
    letter-spacing: 0.5px;
  }

  .table tbody tr {
    transition: var(--transition);
    background-color: white;
  }

  .table tbody tr:not(:last-child) {
    border-bottom: 1px solid rgba(0, 0, 0, 0.05);
  }

  .table tbody tr:hover {
    background-color: rgba(0, 51, 196, 0.03);
  }

  .table tbody td {
    padding: 1rem;
    vertical-align: middle;
  }

  .badge {
    font-weight: 500;
    padding: 0.5em 0.75em;
    border-radius: 20px;
    font-size: 0.75rem;
    text-transform: uppercase;
    letter-spacing: 0.5px;
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

  .btn {
    border-radius: var(--border-radius);
    font-weight: 500;
    padding: 0.5rem 1rem;
    transition: var(--transition);
    border: none;
  }

  .btn-primary {
    background-color: var(--primary-color);
  }

  .btn-primary:hover {
    background-color: var(--primary-light);
  }

  .btn-danger {
    background-color: var(--danger-color);
  }

  .btn-sm {
    font-size: 0.75rem;
    padding: 0.4rem 0.75rem;
  }

  .search-box {
    position: relative;
    width: 250px;
  }

  .search-box input {
    padding-left: 2.5rem;
    border-radius: 20px;
    border: 1px solid #e0e0e0;
    background-color: rgba(255, 255, 255, 0.9);
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
    color: #6c757d;
  }

  .document-preview {
    width: 40px;
    height: 40px;
    object-fit: cover;
    border-radius: 4px;
    cursor: pointer;
    transition: var(--transition);
    border: 1px solid #e0e0e0;
  }

  .document-preview:hover {
    transform: scale(1.1);
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
  }

  .section-title {
    color: var(--primary-color);
    font-weight: 600;
    margin-bottom: 1.5rem;
    position: relative;
    padding-bottom: 0.5rem;
  }

  .section-title::after {
    content: '';
    position: absolute;
    bottom: 0;
    left: 0;
    width: 50px;
    height: 3px;
    background-color: var(--primary-color);
  }

  .delivery-badge {
    background-color: var(--danger-color);
    color: white;
    padding: 0.4rem 0.75rem;
    border-radius: var(--border-radius);
    font-weight: 500;
    cursor: pointer;
    transition: var(--transition);
    display: inline-flex;
    align-items: center;
    gap: 0.25rem;
  }

  .delivery-badge:hover {
    background-color: #e5177b;
    color: white;
  }

  .user-link {
    color: var(--primary-color);
    font-weight: 500;
    cursor: pointer;
    text-decoration: none;
    transition: var(--transition);
  }

  .user-link:hover {
    color: var(--primary-light);
    text-decoration: underline;
  }

  .page-header {
    margin-bottom: 1.5rem;
  }

  .page-header h1 {
    color: var(--dark-color);
    font-weight: 600;
    font-size: 1.75rem;
  }

  .action-buttons {
    display: flex;
    gap: 0.75rem;
  }

  .modal-content {
    border-radius: var(--border-radius);
    border: none;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
  }

  .modal-header {
    background-color: var(--primary-color);
    color: white;
    border-bottom: none;
    padding: 1.25rem 1.5rem;
  }

  .modal-title {
    font-weight: 600;
  }

  .btn-close {
    filter: invert(1);
  }

  .empty-state {
    padding: 2rem;
    text-align: center;
    color: #6c757d;
  }

  .empty-state i {
    font-size: 3rem;
    color: #e0e0e0;
    margin-bottom: 1rem;
  }

  .section-header {
    margin: 2rem 0 1rem;
    color: var(--primary-color);
    font-weight: 600;
    font-size: 1.5rem;
    position: relative;
    padding-bottom: 0.5rem;
  }

  .section-header::after {
    content: '';
    position: absolute;
    bottom: 0;
    left: 0;
    width: 50px;
    height: 3px;
    background-color: var(--primary-color);
  }
</style>

<div class="container-fluid py-4">
  <!-- SweetAlert Notifications -->
  <div class="row">
    @if (Session::get('success1'))
      <script>
        Swal.fire({
          icon: 'success',
          title: 'Suppression réussie',
          text: '{{ Session::get('success1') }}',
          confirmButtonText: 'OK',
          customClass: {
            popup: 'animated bounceIn'
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
          confirmButtonText: 'OK',
          customClass: {
            popup: 'animated bounceIn'
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
          confirmButtonText: 'OK',
          customClass: {
            popup: 'animated shake'
          }
        });
      </script>
    @endif
  </div>

  <!-- Page Header -->
  <div class="page-header d-flex justify-content-between align-items-center">
    <div>
      <h1>Gestion des demandes d'extrait de décès</h1>
    </div>
  </div>

  <!-- With Certificate Section -->
  <h3 class="section-header">
    <i class="bi bi-file-earmark-medical me-2"></i>Demandes avec certificat médical
  </h3>
  
  <div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
      <h6 class="m-0 font-weight-bold">Liste des demandes</h6>
      <div class="search-box">
        <i class="bi bi-search"></i>
        <input type="text" id="searchInput1" class="form-control form-control-sm" placeholder="Rechercher...">
      </div>
    </div>
    <div class="table-responsive">
      <table class="table align-items-center" id="dataTable1">
        <thead>
          <tr >
            <th class="text-center">Demandeur</th>
            <th class="text-center">Hôpital</th>
            <th class="text-center">Date Décès</th>
            <th class="text-center">Défunt</th>
            <th class="text-center">Documents</th>
            <th class="text-center">État</th>
            <th class="text-center">Actions</th>
          </tr>
        </thead>
        <tbody>
          @forelse ($deces as $decesItem)
          <tr class="text-center">
            <td>
              @if($decesItem->user)
                <a href="#" class="user-link" data-bs-toggle="modal" data-bs-target="#userModal" onclick="showUserModal({{ json_encode($decesItem->user) }})">
                  {{ $decesItem->user->name.' '.$decesItem->user->prenom }}
                </a>
              @else
                <span class="text-muted">Inconnu</span>
              @endif
            </td>
            <td>{{ $decesItem->nomHopital }}</td>
            <td>{{ $decesItem->dateDces }}</td>
            <td>
              <strong>{{ $decesItem->nomDefunt }}</strong><br>
              <small class="text-muted">Né le: {{ $decesItem->dateNaiss }}</small><br>
              <small class="text-muted">À: {{ $decesItem->lieuNaiss }}</small>
            </td>
            <td>
              <div class="d-flex justify-content-center gap-2 flex-wrap">
                <!-- Identité Déclarant -->
                @if($decesItem->identiteDeclarant)
                  @php
                    $identiteDeclarantPath = asset('storage/' . $decesItem->identiteDeclarant);
                    $isIdentiteDeclarantPdf = strtolower(pathinfo($identiteDeclarantPath, PATHINFO_EXTENSION)) === 'pdf';
                  @endphp
                  @if ($isIdentiteDeclarantPdf)
                    <a href="{{ $identiteDeclarantPath }}" target="_blank" class="document-preview">
                      <img src="{{ asset('assets/assets/img/pdf.jpg') }}" alt="PDF" class="document-preview">
                    </a>
                  @else
                    <img src="{{ $identiteDeclarantPath }}" 
                      alt="Pièce déclarant" 
                      class="document-preview"
                      data-bs-toggle="modal" 
                      data-bs-target="#imageModal" 
                      onclick="showImage(this)" 
                      onerror="this.onerror=null; this.src='{{ asset('assets/assets/img/plateau.jpeg') }}'">
                  @endif
                @else
                  <span class="badge bg-secondary">N/A</span>
                @endif

                <!-- Acte Mariage -->
                @if($decesItem->acteMariage)
                  @php
                    $acteMariagePath = asset('storage/' . $decesItem->acteMariage);
                    $isActeMariagePdf = strtolower(pathinfo($acteMariagePath, PATHINFO_EXTENSION)) === 'pdf';
                  @endphp
                  @if ($isActeMariagePdf)
                    <a href="{{ $acteMariagePath }}" target="_blank" class="document-preview">
                      <img src="{{ asset('assets/assets/img/pdf.jpg') }}" alt="PDF" class="document-preview">
                    </a>
                  @else
                    <img src="{{ $acteMariagePath }}" 
                      alt="Acte mariage" 
                      class="document-preview"
                      data-bs-toggle="modal" 
                      data-bs-target="#imageModal" 
                      onclick="showImage(this)" 
                      onerror="this.onerror=null; this.src='{{ asset('assets/assets/img/plateau.jpeg') }}'">
                  @endif
                @else
                  <span class="badge bg-secondary">N/A</span>
                @endif

                <!-- Déclaration Loi -->
                @if($decesItem->deParLaLoi)
                  @php
                    $deParLaLoiPath = asset('storage/' . $decesItem->deParLaLoi);
                    $isDeParLaLoiPdf = strtolower(pathinfo($deParLaLoiPath, PATHINFO_EXTENSION)) === 'pdf';
                  @endphp
                  @if ($isDeParLaLoiPdf)
                    <a href="{{ $deParLaLoiPath }}" target="_blank" class="document-preview">
                      <img src="{{ asset('assets/assets/img/pdf.jpg') }}" alt="PDF" class="document-preview">
                    </a>
                  @else
                    <img src="{{ $deParLaLoiPath }}" 
                      alt="Déclaration loi" 
                      class="document-preview"
                      data-bs-toggle="modal" 
                      data-bs-target="#imageModal" 
                      onclick="showImage(this)" 
                      onerror="this.onerror=null; this.src='{{ asset('assets/assets/img/plateau.jpeg') }}'">
                  @endif
                @else
                  <span class="badge bg-secondary">N/A</span>
                @endif
              </div>
            </td>
            <td>
              <span class="badge 
                @if($decesItem->etat == 'en attente') badge-warning
                @elseif($decesItem->etat == 'réçu') badge-success
                @else badge-danger @endif">
                {{ $decesItem->etat }}
              </span>
            </td>
            <td class="text-center">
              <div class="action-buttons" style="display: flex; justify-content:center">
                <a href="{{ route('agent.demandes.deces.edit', $decesItem->id) }}" class="btn btn-sm btn-primary" title="Modifier">
                  <i class="bi bi-pencil-square"></i>
                </a>
                
                @if($decesItem->choix_option == 'livraison')
                  <a href="#" class="delivery-badge btn-sm" data-bs-toggle="modal" data-bs-target="#livraisonModal" onclick="showLivraison1Modal({{ json_encode($decesItem) }})" title="Livraison">
                    <i class="bi bi-truck"></i>
                  </a>
                @else
                  <span class="badge bg-secondary">Retrait</span>
                @endif
              </div>
            </td>
          </tr>
          @empty
          <tr>
            <td colspan="7" class="empty-state">
              <i class="bi bi-folder-x"></i>
              <p>Aucune demande trouvée</p>
            </td>
          </tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>

  <!-- Third Party Section -->
  <h3 class="section-header">
    <i class="bi bi-people me-2"></i>Demandes pour moi/personne tierce
  </h3>
  
  <div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
      <h6 class="m-0 font-weight-bold">Liste des demandes</h6>
      <div class="search-box">
        <i class="bi bi-search"></i>
        <input type="text" id="searchInput2" class="form-control form-control-sm" placeholder="Rechercher...">
      </div>
    </div>
    <div class="table-responsive">
      <table class="table align-items-center" id="dataTable2">
        <thead>
          <tr class="text-center">
            <th>Demandeur</th>
            <th>Défunt</th>
            <th>Registre</th>
            <th>Documents</th>
            <th>État</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          @forelse ($decesdeja as $dece)
          <tr class="text-center">
            <td>
              @if($dece->user)
                <a href="#" class="user-link" data-bs-toggle="modal" data-bs-target="#userModal" onclick="showUserModal({{ json_encode($dece->user) }})">
                  {{ $dece->user->name.' '.$dece->user->prenom }}
                </a>
              @else
                <span class="text-muted">Inconnu</span>
              @endif
            </td>
            <td>
              <strong>{{ $dece->name }}</strong><br>
              <small class="text-muted">CMU: {{ $dece->CMU }}</small>
            </td>
            <td>
              <small class="text-muted">N°: <strong> {{ $dece->numberR }}</strong></small><br>
              <small class="text-muted">Date: <strong>{{ \Carbon\Carbon::parse($dece->dateR)->format('d/m/Y') }}</strong></small>
            </td>
            <td>
              <div class="d-flex justify-content-center gap-2 flex-wrap">
                <!-- Certificat Médical -->
                @if($dece->pActe)
                  @php
                    $pActePath = asset('storage/' . $dece->pActe);
                    $isPActePdf = strtolower(pathinfo($pActePath, PATHINFO_EXTENSION)) === 'pdf';
                  @endphp
                  @if ($isPActePdf)
                    <a href="{{ $pActePath }}" target="_blank" class="document-preview">
                      <img src="{{ asset('assets/assets/img/pdf.jpg') }}" alt="PDF" class="document-preview">
                    </a>
                  @else
                    <img src="{{ $pActePath }}" 
                      alt="Certificat médical" 
                      class="document-preview"
                      data-bs-toggle="modal" 
                      data-bs-target="#imageModal" 
                      onclick="showImage(this)" 
                      onerror="this.onerror=null; this.src='{{ asset('assets/assets/img/plateau.jpeg') }}'">
                  @endif
                @else
                  <span class="badge bg-secondary">N/A</span>
                @endif

                <!-- CNI Défunt -->
                @if($dece->CNIdfnt)
                  @php
                    $CNIdfntPath = asset('storage/' . $dece->CNIdfnt);
                    $isCNIdfntPdf = strtolower(pathinfo($CNIdfntPath, PATHINFO_EXTENSION)) === 'pdf';
                  @endphp
                  @if ($isCNIdfntPdf)
                    <a href="{{ $CNIdfntPath }}" target="_blank" class="document-preview">
                      <img src="{{ asset('assets/assets/img/pdf.jpg') }}" alt="PDF" class="document-preview">
                    </a>
                  @else
                    <img src="{{ $CNIdfntPath }}" 
                      alt="CNI défunt" 
                      class="document-preview"
                      data-bs-toggle="modal" 
                      data-bs-target="#imageModal" 
                      onclick="showImage(this)" 
                      onerror="this.onerror=null; this.src='{{ asset('assets/assets/img/plateau.jpeg') }}'">
                  @endif
                @else
                  <span class="badge bg-secondary">N/A</span>
                @endif

                <!-- CNI Déclarant -->
                @if($dece->CNIdcl)
                  @php
                    $CNIdclPath = asset('storage/' . $dece->CNIdcl);
                    $isCNIdclPdf = strtolower(pathinfo($CNIdclPath, PATHINFO_EXTENSION)) === 'pdf';
                  @endphp
                  @if ($isCNIdclPdf)
                    <a href="{{ $CNIdclPath }}" target="_blank" class="document-preview">
                      <img src="{{ asset('assets/assets/img/pdf.jpg') }}" alt="PDF" class="document-preview">
                    </a>
                  @else
                    <img src="{{ $CNIdclPath }}" 
                      alt="CNI déclarant" 
                      class="document-preview"
                      data-bs-toggle="modal" 
                      data-bs-target="#imageModal" 
                      onclick="showImage(this)" 
                      onerror="this.onerror=null; this.src='{{ asset('assets/assets/img/plateau.jpeg') }}'">
                  @endif
                @else
                  <span class="badge bg-secondary">N/A</span>
                @endif

                <!-- Document Mariage -->
                @if($dece->documentMariage)
                  @php
                    $documentMariagePath = asset('storage/' . $dece->documentMariage);
                    $isDocumentMariagePdf = strtolower(pathinfo($documentMariagePath, PATHINFO_EXTENSION)) === 'pdf';
                  @endphp
                  @if ($isDocumentMariagePdf)
                    <a href="{{ $documentMariagePath }}" target="_blank" class="document-preview">
                      <img src="{{ asset('assets/assets/img/pdf.jpg') }}" alt="PDF" class="document-preview">
                    </a>
                  @else
                    <img src="{{ $documentMariagePath }}" 
                      alt="Document mariage" 
                      class="document-preview"
                      data-bs-toggle="modal" 
                      data-bs-target="#imageModal" 
                      onclick="showImage(this)" 
                      onerror="this.onerror=null; this.src='{{ asset('assets/assets/img/plateau.jpeg') }}'">
                  @endif
                @else
                  <span class="badge bg-secondary">Non marié(e)</span>
                @endif

                <!-- Requisition Police -->
                @if($dece->RequisPolice)
                  @php
                    $RequisPolicePath = asset('storage/' . $dece->RequisPolice);
                    $isRequisPolicePdf = strtolower(pathinfo($RequisPolicePath, PATHINFO_EXTENSION)) === 'pdf';
                  @endphp
                  @if ($isRequisPolicePdf)
                    <a href="{{ $RequisPolicePath }}" target="_blank" class="document-preview">
                      <img src="{{ asset('assets/assets/img/pdf.jpg') }}" alt="PDF" class="document-preview">
                    </a>
                  @else
                    <img src="{{ $RequisPolicePath }}" 
                      alt="Réquisition police" 
                      class="document-preview"
                      data-bs-toggle="modal" 
                      data-bs-target="#imageModal" 
                      onclick="showImage(this)" 
                      onerror="this.onerror=null; this.src='{{ asset('assets/assets/img/plateau.jpeg') }}'">
                  @endif
                @else
                  <span class="badge bg-secondary">N/A</span>
                @endif
              </div>
            </td>
            <td>
              <span class="badge 
                @if($dece->etat == 'en attente') badge-warning
                @elseif($dece->etat == 'réçu') badge-success
                @else badge-danger @endif">
                {{ $dece->etat }}
              </span>
            </td>
            <td>
              <div class="action-buttons" style="display: flex; justify-content:center">
                <a href="{{ route('agent.demandes.deces.edit.simple', $dece->id) }}" class="btn btn-sm btn-primary" title="Modifier">
                  <i class="bi bi-pencil-square"></i>
                </a>
                
                @if($dece->choix_option == 'livraison')
                  <a href="#" class="delivery-badge btn-sm" data-bs-toggle="modal" data-bs-target="#livraisonModal" onclick="showLivraisonModal({{ json_encode($dece) }})" title="Livraison">
                    <i class="bi bi-truck"></i>
                  </a>
                @else
                  <span class="badge bg-secondary">Retrait</span>
                @endif
              </div>
            </td>
          </tr>
          @empty
          <tr>
            <td colspan="6" class="empty-state">
              <i class="bi bi-folder-x"></i>
              <p>Aucune demande trouvée</p>
            </td>
          </tr>
          @endforelse
        </tbody>
      </table>
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
        <img id="modalImage" src="{{ asset('assets/assets/img/plateau.jpeg') }}" alt="Document" class="img-fluid rounded">
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
          <i class="bi bi-truck me-1"></i> Gérer la livraison
        </a>
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
  });
  
  function showImage(imageElement) {
    const modalImage = document.getElementById('modalImage');
    modalImage.src = imageElement.src.includes('assets/assets/img/plateau.jpeg') ? 
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
  
  function showLivraisonModal(dece) {
    const livraisonDetailsDiv = document.getElementById('livraisonDetails');
    livraisonDetailsDiv.innerHTML = `
      <div class="mb-4">
        <h6 class="text-primary mb-3">Destinataire</h6>
        <p><strong>Nom complet:</strong> ${dece.nom_destinataire} ${dece.prenom_destinataire}</p>
        <p><strong>Contact:</strong> ${dece.contact_destinataire}</p>
        <p><strong>Email:</strong> ${dece.email_destinataire}</p>
      </div>
      <div class="mb-4">
        <h6 class="text-primary mb-3">Adresse de livraison</h6>
        <p><strong>Adresse:</strong> ${dece.adresse_livraison}</p>
        <p><strong>Ville/Commune:</strong> ${dece.ville}, ${dece.commune}</p>
        <p><strong>Quartier:</strong> ${dece.quartier}</p>
        <p><strong>Code postal:</strong> ${dece.code_postal}</p>
      </div>
    `;
  }
  
  function showLivraison1Modal(decesItem) {
    const livraisonDetailsDiv = document.getElementById('livraisonDetails');
    livraisonDetailsDiv.innerHTML = `
      <div class="mb-4">
        <h6 class="text-primary mb-3">Destinataire</h6>
        <p><strong>Nom complet:</strong> ${decesItem.nom_destinataire} ${decesItem.prenom_destinataire}</p>
        <p><strong>Contact:</strong> ${decesItem.contact_destinataire}</p>
        <p><strong>Email:</strong> ${decesItem.email_destinataire}</p>
      </div>
      <div class="mb-4">
        <h6 class="text-primary mb-3">Adresse de livraison</h6>
        <p><strong>Adresse:</strong> ${decesItem.adresse_livraison}</p>
        <p><strong>Ville/Commune:</strong> ${decesItem.ville}, ${decesItem.commune}</p>
        <p><strong>Quartier:</strong> ${decesItem.quartier}</p>
        <p><strong>Code postal:</strong> ${decesItem.code_postal}</p>
      </div>
    `;
  }
</script>
@endsection