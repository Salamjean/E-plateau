@extends('agent.layouts.template')

@section('content')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<style>
  :root {
    --primary-color: #f1f5ff;
    --secondary-color: #0033c4;
    --success-color: #2ecc71;
    --warning-color: #f39c12;
    --danger-color: #e74c3c;
    --light-color: #ecf0f1;
    --dark-color: #34495e;
    --border-radius: 8px;
    --box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    --transition: all 0.3s ease;
  }

  body {
    background-color: #f8f9fa;
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
  }

  .card {
    border: none;
    border-radius: var(--border-radius);
    box-shadow: var(--box-shadow);
    transition: var(--transition);
    margin-bottom: 25px;
  }

  .card:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
  }

  .card-header {
    background-color: var(--secondary-color);
    color: white;
    border-radius: var(--border-radius) var(--border-radius) 0 0 !important;
    padding: 15px 20px;
    font-weight: 600;
  }

  .table-responsive {
    border-radius: var(--border-radius);
    overflow: hidden;
  }

  .table {
    margin-bottom: 0;
  }

  .table thead th {
    background-color: var(--primary-color);
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
    background-color: rgba(52, 152, 219, 0.1);
  }

  .table tbody td {
    padding: 12px 15px;
    vertical-align: middle;
    border-top: 1px solid #e9ecef;
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

  .status-terminé {
    background-color: var(--warning-color);
    color: white;
  }

  .status-validee {
    background-color: var(--success-color);
    color: white;
  }

  .status-terminé {
    background-color: var(--danger-color);
    color: white;
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
  }

  .search-box i {
    position: absolute;
    left: 15px;
    top: 10px;
    color: #aaa;
  }

  .img-thumbnail {
    width: 50px;
    height: 50px;
    object-fit: cover;
    border-radius: 4px;
    cursor: pointer;
    transition: var(--transition);
    border: 1px solid #ddd;
  }

  .img-thumbnail:hover {
    transform: scale(1.1);
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
  }

  .pdf-icon {
    width: 30px;
    height: 30px;
    cursor: pointer;
  }

  .breadcrumb {
    background-color: transparent;
    padding: 0;
    font-size: 14px;
  }

  .breadcrumb-item a {
    color: var(--primary-color);
    text-decoration: none;
  }

  .breadcrumb-item.active {
    color: var(--secondary-color);
  }

  .page-title {
    color: var(--secondary-color);
    font-weight: 700;
    margin-bottom: 20px;
  }

  .modal-content {
    border-radius: var(--border-radius);
    border: none;
  }

  .modal-header {
    background-color: var(--primary-color);
    color: white;
    border-radius: var(--border-radius) var(--border-radius) 0 0;
  }

  .modal-body img {
    max-height: 70vh;
    width: auto;
    margin: 0 auto;
    display: block;
  }

  .empty-state {
    text-align: center;
    padding: 40px 0;
    color: #7f8c8d;
  }

  .empty-state i {
    font-size: 50px;
    margin-bottom: 15px;
    color: #bdc3c7;
  }

  .badge-agent {
    background-color: var(--secondary-color);
    color: white;
    padding: 4px 8px;
    border-radius: 4px;
    font-size: 12px;
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

  @media (max-width: 768px) {
    .table-responsive {
      border: 1px solid #ddd;
    }
    
    .table thead {
      display: none;
    }
    
    .table tbody tr {
      display: block;
      margin-bottom: 15px;
      border: 1px solid #ddd;
      border-radius: var(--border-radius);
    }
    
    .table tbody td {
      display: block;
      text-align: right;
      padding-left: 50%;
      position: relative;
      border-top: 1px solid #e9ecef;
    }
    
    .table tbody td::before {
      content: attr(data-label);
      position: absolute;
      left: 15px;
      width: 45%;
      padding-right: 10px;
      font-weight: 600;
      text-align: left;
      color: var(--secondary-color);
    }
    
    .img-thumbnail {
      float: right;
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
            popup: 'custom-swal-popup'
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
            popup: 'custom-swal-popup'
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
            popup: 'custom-swal-popup'
          }
        });
      </script>
    @endif
  </div>

  <!-- En-tête de page -->
  <div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="page-title"><i class="fas fa-church me-2"></i>Liste des extraits de Décès</h1>
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="{{ route('agent.dashboard') }}"><i class="fas fa-home"></i> Accueil</a></li>
      <li class="breadcrumb-item active">Décès</li>
    </ol>
  </div>

  <!-- Première table - Décès déclarés -->
  <div class="row">
    <div class="col-lg-12">
      <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
          <h6 class="m-0 font-weight-bold"><i class="fas fa-hospital me-2"></i>Demandes avec certificat</h6>
          <div class="search-box">
            <i class="fas fa-search"></i>
            <input type="text" id="searchInput1" class="form-control" placeholder="Rechercher...">
          </div>
        </div>
        <div class="table-responsive">
          <table class="table align-items-center" id="dataTable1">
            <thead>
              <tr class="text-center">
                <th>Code de livraison	</th>
                <th>Statut de livraison	</th>
                <th>Demandeur</th>
                <th>Hôpital</th>
                <th>Date décès</th>
                <th>Nom défunt</th>
                <th>Date naissance</th>
                <th>Lieu naissance</th>
                <th>Pièce déclarant</th>
                <th>Acte mariage</th>
                <th>Déclaration loi</th>
                <th>État</th>
                <th>Agent</th>
              </tr>
            </thead>
            <tbody>
              @forelse ($taskenddeces as $deces)
                <tr class="text-center">
                  <td  class="badge bg-success text-white">{{ $deces->livraison_code ?? 'Retrait sur place'}}</td>
                  <td>
                    <span class="badge 
                      @if($deces->statut_livraison == 'en attente') badge-warning
                      @elseif($deces->statut_livraison == 'en cours') badge-success
                      @else badge-danger @endif">
                      {{ $deces->statut_livraison }}
                    </span>
                  </td>
                  <td>{{ $deces->user ? $deces->user->name.' '.$deces->user->prenom : 'Inconnu' }}</td>
                  <td>{{ $deces->nomHopital }}</td>
                  <td>{{ $deces->dateDces }}</td>
                  <td>{{ $deces->nomDefunt }}</td>
                  <td>{{ $deces->dateNaiss }}</td>
                  <td>{{ $deces->lieuNaiss }}</td>
                  <td>
                    @if($deces->identiteDeclarant)
                      @php
                        $identiteDeclarantPath = asset('storage/' . $deces->identiteDeclarant);
                        $isIdentiteDeclarantPdf = strtolower(pathinfo($identiteDeclarantPath, PATHINFO_EXTENSION)) === 'pdf';
                      @endphp
                      @if ($isIdentiteDeclarantPdf)
                        <a href="{{ $identiteDeclarantPath }}" target="_blank">
                          <img src="{{ asset('assets/assets/img/pdf.jpg') }}" class="pdf-icon" alt="PDF">
                        </a>
                      @else
                        <div class="document-container">
                          <img src="{{ $identiteDeclarantPath }}" 
                            class="img-thumbnail"
                            data-bs-toggle="modal" 
                            data-bs-target="#imageModal" 
                            onclick="showImage(this)" 
                            onerror="this.style.display='none'; document.getElementById('placeholder1-{{ $loop->index }}').style.display='block';">
                          <span id="placeholder1-{{ $loop->index }}" class="document-placeholder" style="display: none;">Aucun fichier</span>
                        </div>
                      @endif
                    @else
                      <span class="text-muted">N/A</span>
                    @endif
                  </td>
                  <td>
                    @if($deces->acteMariage)
                      @php
                        $acteMariagePath = asset('storage/' . $deces->acteMariage);
                        $isActeMariagePdf = strtolower(pathinfo($acteMariagePath, PATHINFO_EXTENSION)) === 'pdf';
                      @endphp
                      @if ($isActeMariagePdf)
                        <a href="{{ $acteMariagePath }}" target="_blank">
                          <img src="{{ asset('assets/assets/img/pdf.jpg') }}" class="pdf-icon" alt="PDF">
                        </a>
                      @else
                        <div class="document-container">
                          <img src="{{ $acteMariagePath }}" 
                            class="img-thumbnail"
                            data-bs-toggle="modal" 
                            data-bs-target="#imageModal" 
                            onclick="showImage(this)" 
                            onerror="this.style.display='none'; document.getElementById('placeholder2-{{ $loop->index }}').style.display='block';">
                          <span id="placeholder2-{{ $loop->index }}" class="document-placeholder" style="display: none;">Aucun fichier</span>
                        </div>
                      @endif
                    @else
                      <span class="text-muted">N/A</span>
                    @endif
                  </td>
                  <td>
                    @if($deces->deParLaLoi)
                      @php
                        $deParLaLoiPath = asset('storage/' . $deces->deParLaLoi);
                        $isDeParLaLoiPdf = strtolower(pathinfo($deParLaLoiPath, PATHINFO_EXTENSION)) === 'pdf';
                      @endphp
                      @if ($isDeParLaLoiPdf)
                        <a href="{{ $deParLaLoiPath }}" target="_blank">
                          <img src="{{ asset('assets/assets/img/pdf.jpg') }}" class="pdf-icon" alt="PDF">
                        </a>
                      @else
                        <div class="document-container">
                          <img src="{{ $deParLaLoiPath }}" 
                            class="img-thumbnail"
                            data-bs-toggle="modal" 
                            data-bs-target="#imageModal" 
                            onclick="showImage(this)" 
                            onerror="this.style.display='none'; document.getElementById('placeholder3-{{ $loop->index }}').style.display='block';">
                          <span id="placeholder3-{{ $loop->index }}" class="document-placeholder" style="display: none;">Aucun fichier</span>
                        </div>
                      @endif
                    @else
                      <span class="text-muted">N/A</span>
                    @endif
                  </td>
                  <td>
                    <span class="status-badge status-{{ str_replace(' ', '-', strtolower($deces->etat)) }}">
                      {{ $deces->etat }}
                    </span>
                  </td>
                  <td>
                    @if($deces->agent)
                      <span class="badge-agent">
                        {{ $deces->agent->name.' '.$deces->agent->prenom }}
                      </span>
                    @else
                      <span class="text-muted">Non attribué</span>
                    @endif
                  </td>
                </tr>
              @empty
                <tr>
                  <td colspan="13" class="empty-state">
                    <i class="fas fa-folder-open"></i>
                    <h5>Aucun décès déclaré trouvé</h5>
                  </td>
                </tr>
              @endforelse
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>

  <!-- Deuxième table - Décès déjà enregistrés -->
  <div class="row">
    <div class="col-lg-12">
      <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
          <h6 class="m-0 font-weight-bold"><i class="fas fa-archive me-2"></i>Demandes sans certificat</h6>
          <div class="search-box">
            <i class="fas fa-search"></i>
            <input type="text" id="searchInput2" class="form-control" placeholder="Rechercher...">
          </div>
        </div>
        <div class="table-responsive">
          <table class="table align-items-center" id="dataTable2">
            <thead>
              <tr class="text-center">
                <th>Code de livraison</th>
                <th>Statut de livraison</th>
                <th>Demandeur</th>
                <th>Nom défunt</th>
                <th>N° registre</th>
                <th>Date registre</th>
                <th>N° CMU</th>
                <th>Certificat médical</th>
                <th>CNI défunt</th>
                <th>CNI déclarant</th>
                <th>Document mariage</th>
                <th>Réquisition police</th>
                <th>État</th>
                <th>Agent</th>
              </tr>
            </thead>
            <tbody>
              @forelse ($taskenddecedejas as $dece)
                <tr class="text-center">
                  <td  class="badge bg-success text-white">{{ $dece->livraison_code ?? 'Retrait sur place'}}</td>
                  <td>
                    <span class="badge 
                      @if($dece->statut_livraison == 'en attente') badge-warning
                      @elseif($dece->statut_livraison == 'en cours') badge-success
                      @else badge-danger @endif">
                      {{ $dece->statut_livraison }}
                    </span>
                  </td>
                  <td>{{ $dece->user ? $dece->user->name.' '.$dece->user->prenom : 'Inconnu' }}</td>
                  <td>{{ $dece->name }}</td>
                  <td>{{ $dece->numberR }}</td>
                  <td>{{ \Carbon\Carbon::parse($dece->dateR)->format('d/m/Y') }}</td>
                  <td>{{ $dece->CMU }}</td>
                  <td>
                    @if($dece->pActe)
                      @php
                        $pActePath = asset('storage/' . $dece->pActe);
                        $isPActePdf = strtolower(pathinfo($pActePath, PATHINFO_EXTENSION)) === 'pdf';
                      @endphp
                      @if ($isPActePdf)
                        <a href="{{ $pActePath }}" target="_blank">
                          <img src="{{ asset('assets/assets/img/pdf.jpg') }}" class="pdf-icon" alt="PDF">
                        </a>
                      @else
                        <div class="document-container">
                          <img src="{{ $pActePath }}" 
                            class="img-thumbnail"
                            data-bs-toggle="modal" 
                            data-bs-target="#imageModal" 
                            onclick="showImage(this)" 
                            onerror="this.style.display='none'; document.getElementById('placeholder4-{{ $loop->index }}').style.display='block';">
                          <span id="placeholder4-{{ $loop->index }}" class="document-placeholder" style="display: none;">Aucun fichier</span>
                        </div>
                      @endif
                    @else
                      <span class="text-muted">N/A</span>
                    @endif
                  </td>
                  <td>
                    @if($dece->CNIdfnt)
                      @php
                        $CNIdfntPath = asset('storage/' . $dece->CNIdfnt);
                        $isCNIdfntPdf = strtolower(pathinfo($CNIdfntPath, PATHINFO_EXTENSION)) === 'pdf';
                      @endphp
                      @if ($isCNIdfntPdf)
                        <a href="{{ $CNIdfntPath }}" target="_blank">
                          <img src="{{ asset('assets/assets/img/pdf.jpg') }}" class="pdf-icon" alt="PDF">
                        </a>
                      @else
                        <div class="document-container">
                          <img src="{{ $CNIdfntPath }}" 
                            class="img-thumbnail"
                            data-bs-toggle="modal" 
                            data-bs-target="#imageModal" 
                            onclick="showImage(this)" 
                            onerror="this.style.display='none'; document.getElementById('placeholder5-{{ $loop->index }}').style.display='block';">
                          <span id="placeholder5-{{ $loop->index }}" class="document-placeholder" style="display: none;">Aucun fichier</span>
                        </div>
                      @endif
                    @else
                      <span class="text-muted">N/A</span>
                    @endif
                  </td>
                  <td>
                    @if($dece->CNIdcl)
                      @php
                        $CNIdclPath = asset('storage/' . $dece->CNIdcl);
                        $isCNIdclPdf = strtolower(pathinfo($CNIdclPath, PATHINFO_EXTENSION)) === 'pdf';
                      @endphp
                      @if ($isCNIdclPdf)
                        <a href="{{ $CNIdclPath }}" target="_blank">
                          <img src="{{ asset('assets/assets/img/pdf.jpg') }}" class="pdf-icon" alt="PDF">
                        </a>
                      @else
                        <div class="document-container">
                          <img src="{{ $CNIdclPath }}" 
                            class="img-thumbnail"
                            data-bs-toggle="modal" 
                            data-bs-target="#imageModal" 
                            onclick="showImage(this)" 
                            onerror="this.style.display='none'; document.getElementById('placeholder6-{{ $loop->index }}').style.display='block';">
                          <span id="placeholder6-{{ $loop->index }}" class="document-placeholder" style="display: none;">Aucun fichier</span>
                        </div>
                      @endif
                    @else
                      <span class="text-muted">N/A</span>
                    @endif
                  </td>
                  <td>
                    @if($dece->documentMariage)
                      @php
                        $documentMariagePath = asset('storage/' . $dece->documentMariage);
                        $isDocumentMariagePdf = strtolower(pathinfo($documentMariagePath, PATHINFO_EXTENSION)) === 'pdf';
                      @endphp
                      @if ($isDocumentMariagePdf)
                        <a href="{{ $documentMariagePath }}" target="_blank">
                          <img src="{{ asset('assets/assets/img/pdf.jpg') }}" class="pdf-icon" alt="PDF">
                        </a>
                      @else
                        <div class="document-container">
                          <img src="{{ $documentMariagePath }}" 
                            class="img-thumbnail"
                            data-bs-toggle="modal" 
                            data-bs-target="#imageModal" 
                            onclick="showImage(this)" 
                            onerror="this.style.display='none'; document.getElementById('placeholder7-{{ $loop->index }}').style.display='block';">
                          <span id="placeholder7-{{ $loop->index }}" class="document-placeholder" style="display: none;">Non marié(e)</span>
                        </div>
                      @endif
                    @else
                      <span class="text-muted">Non marié(e)</span>
                    @endif
                  </td>
                  <td>
                    @if($dece->RequisPolice)
                      @php
                        $RequisPolicePath = asset('storage/' . $dece->RequisPolice);
                        $isRequisPolicePdf = strtolower(pathinfo($RequisPolicePath, PATHINFO_EXTENSION)) === 'pdf';
                      @endphp
                      @if ($isRequisPolicePdf)
                        <a href="{{ $RequisPolicePath }}" target="_blank">
                          <img src="{{ asset('assets/assets/img/pdf.jpg') }}" class="pdf-icon" alt="PDF">
                        </a>
                      @else
                        <div class="document-container">
                          <img src="{{ $RequisPolicePath }}" 
                            class="img-thumbnail"
                            data-bs-toggle="modal" 
                            data-bs-target="#imageModal" 
                            onclick="showImage(this)" 
                            onerror="this.style.display='none'; document.getElementById('placeholder8-{{ $loop->index }}').style.display='block';">
                          <span id="placeholder8-{{ $loop->index }}" class="document-placeholder" style="display: none;">Non disponible</span>
                        </div>
                      @endif
                    @else
                      <span class="text-muted">Non disponible</span>
                    @endif
                  </td>
                  <td>
                    <span class="status-badge status-{{ str_replace(' ', '-', strtolower($dece->etat)) }}">
                      {{ $dece->etat }}
                    </span>
                  </td>
                  <td>
                    @if($dece->agent)
                      <span class="badge-agent">
                        {{ $dece->agent->name.' '.$dece->agent->prenom }}
                      </span>
                    @else
                      <span class="text-muted">Non attribué</span>
                    @endif
                  </td>
                </tr>
              @empty
                <tr>
                  <td colspan="14" class="empty-state">
                    <i class="fas fa-folder-open"></i>
                    <h5>Aucun décès enregistré trouvé</h5>
                  </td>
                </tr>
              @endforelse
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Modal pour l'aperçu des images -->
<div class="modal fade" id="imageModal" tabindex="-1" aria-labelledby="imageModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="imageModalLabel">Aperçu du document</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
      </div>
      <div class="modal-body text-center">
        <img id="modalImage" src="{{ asset('assets/images/profiles/bébé.jpg') }}" alt="Document prévisualisé" class="img-fluid">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
      </div>
    </div>
  </div>
</div>

<script>
  // Fonction pour la recherche dans la première table
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

  // Fonction pour la recherche dans la deuxième table
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

  // Fonction pour afficher l'image dans la modal
  function showImage(imageElement) {
    const modalImage = document.getElementById('modalImage');
    modalImage.src = imageElement.src;
  }

  // Adaptation pour les écrans mobiles
  function adaptForMobile() {
    if (window.innerWidth <= 768px) {
      const tables = [document.getElementById('dataTable1'), document.getElementById('dataTable2')];
      
      tables.forEach(table => {
        if (table) {
          const headers = [];
          const ths = table.querySelectorAll('thead th');
          
          ths.forEach(th => {
            headers.push(th.textContent.trim());
          });
          
          const rows = table.querySelectorAll('tbody tr');
          
          rows.forEach(row => {
            const cells = row.querySelectorAll('td');
            
            cells.forEach((cell, index) => {
              if (headers[index]) {
                cell.setAttribute('data-label', headers[index]);
              }
            });
          });
        }
      });
    }
  }

  // Exécuter au chargement et lors du redimensionnement
  window.addEventListener('load', adaptForMobile);
  window.addEventListener('resize', adaptForMobile);
</script>
@endsection