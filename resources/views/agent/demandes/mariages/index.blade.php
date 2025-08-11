@extends('agent.layouts.template')

@section('content')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        :root {
            --primary-color: #0033c4;
            --secondary-color: #0033c4;;
            --success-color: #4cc9f0;
            --danger-color: #f72585;
            --warning-color: #f8961e;
            --light-color: #f8f9fa;
            --dark-color: #212529;
            --border-radius: 8px;
            --box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            --transition: all 0.3s ease;
        }
        
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f5f7fb;
        }
        
        .card {
            border: none;
            border-radius: var(--border-radius);
            box-shadow: var(--box-shadow);
            transition: var(--transition);
        }
        
        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
        }
        
        .card-header {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            color: white;
            border-radius: var(--border-radius) var(--border-radius) 0 0 !important;
            padding: 1.25rem 1.5rem;
        }
        
        .breadcrumb {
            background-color: transparent;
            padding: 0;
            font-size: 0.9rem;
        }
        
        .breadcrumb-item.active {
            color: var(--primary-color);
            font-weight: 500;
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
            color: white;
            font-weight: 500;
            text-transform: uppercase;
            font-size: 0.75rem;
            letter-spacing: 0.5px;
            border: none;
            padding: 1rem 0.75rem;
        }
        
        .table tbody tr {
            transition: var(--transition);
        }
        
        .table tbody tr:hover {
            background-color: rgba(67, 97, 238, 0.05);
        }
        
        .table tbody td {
            padding: 1rem 0.75rem;
            vertical-align: middle;
            border-top: 1px solid #eceff1;
            font-size: 0.85rem;
        }
        
        .btn {
            border-radius: 50px;
            padding: 0.5rem 1.25rem;
            font-size: 0.8rem;
            font-weight: 500;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            transition: var(--transition);
            border: none;
            box-shadow: none;
        }
        
        .btn-primary {
            background-color: var(--primary-color);
        }
        
        .btn-primary:hover {
            background-color: var(--secondary-color);
            transform: translateY(-2px);
        }
        
        .btn-sm {
            padding: 0.35rem 0.75rem;
            font-size: 0.75rem;
        }
        
        .badge {
            padding: 0.5rem 0.75rem;
            font-weight: 500;
            font-size: 0.75rem;
            border-radius: 50px;
        }
        
        .etat-en-attente {
            background-color: var(--warning-color);
            color: white;
        }
        
        .etat-validee {
            background-color: var(--success-color);
            color: white;
        }
        
        .etat-refusee {
            background-color: var(--danger-color);
            color: white;
        }
        
        .search-box {
            position: relative;
            margin-bottom: 1.5rem;
        }
        
        .search-box .form-control {
            border-radius: 50px;
            padding-left: 2.5rem;
            border: 1px solid #e0e0e0;
            box-shadow: none;
        }
        
        .search-box .search-icon {
            position: absolute;
            left: 1rem;
            top: 50%;
            transform: translateY(-50%);
            color: #6c757d;
        }
        
        .pagination {
            justify-content: center;
            margin-top: 1.5rem;
        }
        
        .page-item.active .page-link {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
        }
        
        .page-link {
            color: var(--primary-color);
            border-radius: var(--border-radius);
            margin: 0 0.25rem;
            border: none;
            box-shadow: var(--box-shadow);
        }
        
        .modal-header {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            color: white;
        }
        
        .modal-title {
            font-weight: 600;
        }
        
        .img-thumbnail {
            border-radius: var(--border-radius);
            transition: var(--transition);
            cursor: pointer;
        }
        
        .img-thumbnail:hover {
            transform: scale(1.05);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }
        
        .delivery-badge {
            background-color: var(--danger-color);
            color: white;
            padding: 0.5rem 1rem;
            border-radius: var(--border-radius);
            display: inline-block;
            font-weight: 500;
            cursor: pointer;
            transition: var(--transition);
        }
        
        .delivery-badge:hover {
            background-color: #d1145a;
            transform: translateY(-2px);
        }
        
        .user-link {
            color: var(--primary-color);
            font-weight: 500;
            text-decoration: none;
            transition: var(--transition);
        }
        
        .user-link:hover {
            color: var(--secondary-color);
            text-decoration: underline;
        }
        
        .status-badge {
            padding: 0.5rem 1rem;
            border-radius: 50px;
            font-size: 0.75rem;
            font-weight: 500;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        
        .bg-navbar {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
        }
        
        .action-btn {
            background-color: var(--primary-color);
            color: white;
        }
        
        .action-btn:hover {
            background-color: var(--secondary-color);
            color: white;
        }
        
        .empty-state {
            text-align: center;
            padding: 2rem;
            color: #6c757d;
        }
        
        .empty-state i {
            font-size: 3rem;
            color: #dee2e6;
            margin-bottom: 1rem;
        }
        
        .h3, h3 {
            font-weight: 600;
            color: var(--dark-color);
        }
    </style>

    <!-- SweetAlert Notifications -->
    <div class="row">
        @if (Session::get('success1'))
            <script>
                Swal.fire({
                    icon: 'success',
                    title: 'Suppression réussie',
                    text: '{{ Session::get('success1') }}',
                    showConfirmButton: true,
                    confirmButtonText: 'OK',
                    background: '#fff',
                    color: '#212529',
                    iconColor: '#4cc9f0'
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
                    background: '#fff',
                    color: '#212529',
                    iconColor: '#4cc9f0'
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
                    background: '#fff',
                    color: '#212529',
                    iconColor: '#f72585'
                });
            </script>
        @endif
    </div>

    <div class="container-fluid" id="container-wrapper">
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Liste des demandes d'extraits de Mariage</h1>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="./" class="text-primary"><i class="fas fa-home"></i> Accueil</a></li>
                <li class="breadcrumb-item">Tables</li>
                <li class="breadcrumb-item active text-primary" aria-current="page">Demandes</li>
            </ol>
        </div>

        <!-- Combined Marriage Table -->
        <div class="row">
            <div class="col-lg-12">
                <div class="card mb-4">
                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                        <h6 class="m-0 font-weight-bold"><i class="fas fa-list-alt me-2"></i>Demandes d'Extraits de Mariage</h6>
                        
                    </div>
                    <div class="card-body">
                        <!-- Search Box -->
                        <div class="search-box mb-4">
                            <i class="fas fa-search search-icon"></i>
                            <input type="text" id="searchInput" class="form-control" placeholder="Rechercher par nom, prénom ou lieu...">
                        </div>
                        
                        <div class="table-responsive">
                            <table class="table align-items-center table-flush" id="dataTable">
                                <thead class="bg-navbar text-white">
                                    <tr>
                                        <th class="text-center">Demandeur</th>
                                        <th class="text-center">Conjoint(e)</th>
                                        <th class="text-center">Prénoms</th>
                                        <th class="text-center">Naissance</th>
                                        <th class="text-center">Lieu</th>
                                        <th class="text-center">Pièce d'Identité</th>
                                        <th class="text-center">Extrait</th>
                                        <th class="text-center">État</th>
                                        <th class="text-center">Actions</th>
                                        <th class="text-center">Retrait</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($mariages as $mariage)
                                        <tr>
                                            <td class="text-center">
                                                @if($mariage->user)
                                                    <a href="#" class="user-link" data-bs-toggle="modal" data-bs-target="#userModal" onclick="showUserModal({{ json_encode($mariage->user) }})">
                                                        {{ $mariage->user->name .' '. $mariage->user->prenom}}
                                                        <i class="fas fa-info-circle ms-1"></i>
                                                    </a>
                                                @else
                                                    <span class="text-muted">Demandeur inconnu</span>
                                                @endif
                                            </td>
                                            <td class="text-center">{{ $mariage->nomEpoux ? $mariage->nomEpoux : 'Copie-simple' }}</td>
                                            <td class="text-center">{{ $mariage->prenomEpoux ? $mariage->prenomEpoux : 'Copie-simple' }}</td>
                                            <td class="text-center">{{ $mariage->dateNaissanceEpoux ? $mariage->dateNaissanceEpoux : 'Copie-simple' }}</td>
                                            <td class="text-center">{{ $mariage->lieuNaissanceEpoux ? $mariage->lieuNaissanceEpoux : 'Copie-simple' }}</td>
                                            <td class="text-center">
                                                @if($mariage->pieceIdentite)
                                                    @php
                                                        $pieceIdentitePath = asset('storage/' . $mariage->pieceIdentite);
                                                        $isPieceIdentitePdf = strtolower(pathinfo($pieceIdentitePath, PATHINFO_EXTENSION)) === 'pdf';
                                                    @endphp
                                                    @if ($isPieceIdentitePdf)
                                                        <a href="{{ $pieceIdentitePath }}" target="_blank" class="btn btn-sm btn-outline-primary">
                                                            <i class="fas fa-file-pdf me-1"></i>
                                                        </a>
                                                    @else
                                                        <img src="{{ $pieceIdentitePath }}" 
                                                             alt="Pièce d'identité"
                                                             class="img-thumbnail"
                                                             width="50"
                                                             data-bs-toggle="modal"
                                                             data-bs-target="#imageModal"
                                                             onclick="showImage(this)"
                                                             onerror="this.onerror=null; this.src='{{ asset('assets/images/profiles/default.jpg') }}'">
                                                    @endif
                                                @else
                                                    <span class="text-muted">Non disponible</span>
                                                @endif
                                            </td>
                                            <td class="text-center">
                                                @if($mariage->extraitMariage)
                                                    @php
                                                        $extraitMariagePath = asset('storage/' . $mariage->extraitMariage);
                                                        $isExtraitMariagePdf = strtolower(pathinfo($extraitMariagePath, PATHINFO_EXTENSION)) === 'pdf';
                                                    @endphp
                                                    @if ($isExtraitMariagePdf)
                                                        <a href="{{ $extraitMariagePath }}" target="_blank" class="btn btn-sm btn-outline-primary">
                                                            <i class="fas fa-file-pdf me-1"></i> 
                                                        </a>
                                                    @else
                                                        <img src="{{ $extraitMariagePath }}"
                                                             alt="Extrait de mariage"
                                                             class="img-thumbnail"
                                                             width="50"
                                                             data-bs-toggle="modal"
                                                             data-bs-target="#imageModal"
                                                             onclick="showImage(this)"
                                                             onerror="this.onerror=null; this.src='{{ asset('assets/images/profiles/default.jpg') }}'">
                                                    @endif
                                                @else
                                                    <span class="text-muted">Non disponible</span>
                                                @endif
                                            </td>
                                            <td class="text-center">
                                                <span class="status-badge 
                                                    @if($mariage->etat == 'en attente') bg-warning
                                                    @elseif($mariage->etat == 'réçu') bg-success
                                                    @else bg-danger
                                                    @endif">
                                                    {{ $mariage->etat }}
                                                </span>
                                            </td>
                                            <td class="text-center">
                                                <a href="{{ route('agent.demandes.wedding.edit', $mariage->id) }}" class="btn btn-sm action-btn">
                                                    <i class="fas fa-edit me-1"></i> Mettre à jour
                                                </a>
                                            </td>
                                            <td class="text-center">
                                                @if($mariage->choix_option == 'livraison')
                                                    <a href="#" data-bs-toggle="modal" data-bs-target="#livraisonModal" onclick="showLivraisonModal({{ json_encode($mariage) }})" style="color: white">
                                                        <span class="delivery-badge" style="color: white">
                                                            <i class="fas fa-truck me-1" ></i> {{ $mariage->choix_option }}
                                                        </span>
                                                    </a>
                                                @else
                                                    <span class="badge bg-primary text-white">
                                                        <i class="fas fa-store me-1"></i> {{ $mariage->choix_option }}
                                                    </span>
                                                @endif
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="10" class="text-center py-4">
                                                <div class="empty-state">
                                                    <i class="fas fa-folder-open"></i>
                                                    <h4>Aucune demande effectuée</h4>
                                                    <p class="text-muted">Aucune demande d'extrait de mariage n'a été trouvée.</p>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        
                        @if($mariages->count())
                            <div class="d-flex justify-content-between align-items-center mt-3">
                                <div class="text-muted">
                                    Affichage de <b>{{ $mariages->firstItem() }}</b> à <b>{{ $mariages->lastItem() }}</b> sur <b>{{ $mariages->total() }}</b> demandes
                                </div>
                                {{ $mariages->links() }}
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Image Preview Modal -->
    <div class="modal fade" id="imageModal" tabindex="-1" aria-labelledby="imageModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="imageModalLabel">Aperçu de l'image</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
                </div>
                <div class="modal-body text-center">
                    <img id="modalImage" src="{{ asset('assets/images/profiles/default.jpg') }}" alt="Image prévisualisée" class="img-fluid rounded">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                    <a id="downloadImage" href="#" class="btn btn-primary" download>
                        <i class="fas fa-download me-1"></i> Télécharger
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Delivery Information Modal -->
    <div class="modal fade" id="livraisonModal" tabindex="-1" aria-labelledby="livraisonModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="livraisonModalLabel">
                        <i class="fas fa-truck me-2"></i>Informations de livraison
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div id="livraisonDetails"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                    <a href="#" class="btn btn-primary">
                        <i class="fas fa-user-tie me-1"></i> Assigner un livreur
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- User Information Modal -->
    <div class="modal fade" id="userModal" tabindex="-1" aria-labelledby="userModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="userModalLabel">
                        <i class="fas fa-user-circle me-2"></i>Informations du demandeur
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div id="userDetails"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        function showImage(imageElement) {
            const modalImage = document.getElementById('modalImage');
            const downloadLink = document.getElementById('downloadImage');
            
            modalImage.src = imageElement.src;
            downloadLink.href = imageElement.src;
        }
        
        document.getElementById('searchInput').addEventListener('keyup', function() {
            const filter = this.value.toLowerCase();
            const rows = document.querySelectorAll('#dataTable tbody tr');
    
            rows.forEach(row => {
                let match = false;
                const cells = row.querySelectorAll('td');
                
                // Check each cell in the row (except action cells)
                for (let i = 0; i < cells.length - 2; i++) {
                    if (cells[i].textContent.toLowerCase().includes(filter)) {
                        match = true;
                        break;
                    }
                }
                
                row.style.display = match ? '' : 'none';
            });
        });
        
        function showUserModal(user) {
            const userDetailsDiv = document.getElementById('userDetails');
            userDetailsDiv.innerHTML = `
                <div class="row mb-3">
                    <div class="col-md-6">
                        <p><strong><i class="fas fa-user me-2"></i>Nom:</strong> ${user.name}</p>
                    </div>
                    <div class="col-md-6">
                        <p><strong><i class="fas fa-user me-2"></i>Prénom(s):</strong> ${user.prenom}</p>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-6">
                        <p><strong><i class="fas fa-envelope me-2"></i>Email:</strong> ${user.email}</p>
                    </div>
                    <div class="col-md-6">
                        <p><strong><i class="fas fa-phone me-2"></i>Contact:</strong> ${user.contact}</p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <p><strong><i class="fas fa-map-marker-alt me-2"></i>Commune:</strong> ${user.commune}</p>
                    </div>
                    <div class="col-md-6">
                        <p><strong><i class="fas fa-id-card me-2"></i>N°CMU:</strong> ${user.CMU}</p>
                    </div>
                </div>
            `;
        }

        function showLivraisonModal(mariage) {
            const livraisonDetailsDiv = document.getElementById('livraisonDetails');
            livraisonDetailsDiv.innerHTML = `
                <div class="mb-3">
                    <h6 class="font-weight-bold text-primary"><i class="fas fa-user-tag me-2"></i>Destinataire</h6>
                    <div class="ps-4">
                        <p><strong>Nom complet:</strong> ${mariage.nom_destinataire} ${mariage.prenom_destinataire}</p>
                        <p><strong>Email:</strong> ${mariage.email_destinataire}</p>
                        <p><strong>Contact:</strong> ${mariage.contact_destinataire}</p>
                    </div>
                </div>
                
                <div class="mb-3">
                    <h6 class="font-weight-bold text-primary"><i class="fas fa-map-marked-alt me-2"></i>Adresse de livraison</h6>
                    <div class="ps-4">
                        <p>${mariage.adresse_livraison}</p>
                        <p>${mariage.ville}, ${mariage.commune}</p>
                        <p>${mariage.quartier}, Code postal: ${mariage.code_postal}</p>
                    </div>
                </div>
                
                <div class="alert alert-info">
                    <i class="fas fa-info-circle me-2"></i>
                    Vous pouvez maintenant assigner un livreur pour cette demande.
                </div>
            `;
        }
    </script>
@endsection