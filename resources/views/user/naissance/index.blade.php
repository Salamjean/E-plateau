@extends('user.layouts.template')

@section('content')
<!-- Styles et Scripts -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">

<style>
    :root {
        --primary-color: #1977cc;
        --secondary-color: #1977cc;
        --success-color: #1977cc;
        --warning-color: #f39c12;
        --danger-color: #e74c3c;
        --light-bg: #f8f9fa;
        --card-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    }

    .form-background {
        background: linear-gradient(135deg, rgba(52, 152, 219, 0.1) 0%, rgba(46, 204, 113, 0.1) 100%);
        padding: 30px;
        border-radius: 16px;
        box-shadow: var(--card-shadow);
        border: none;
    }

    .card-rounded {
        border-radius: 16px;
        overflow: hidden;
        box-shadow: var(--card-shadow);
        border: none;
    }

    .table-responsive {
        border-radius: 12px;
        overflow: hidden;
    }

    table {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0;
    }

    thead {
        background: linear-gradient(to right, var(--secondary-color), var(--primary-color));
        color: white;
    }

    th {
        padding: 15px;
        font-weight: 600;
        text-align: center;
    }

    td {
        padding: 12px 15px;
        vertical-align: middle;
        border-bottom: 1px solid #eee;
        text-align: center;
    }

    tr:nth-child(even) {
        background-color: rgba(0, 0, 0, 0.02);
    }

    tr:hover {
        background-color: rgba(0, 0, 0, 0.05);
    }

    .badge {
        padding: 8px 12px;
        border-radius: 20px;
        font-weight: 600;
        font-size: 0.8rem;
    }

    .badge-warning {
        background-color: rgba(243, 156, 18, 0.1);
        color: var(--warning-color);
    }

    .badge-success {
        background-color: rgba(46, 204, 113, 0.1);
        color: var(--success-color);
    }

    .badge-danger {
        background-color: rgba(231, 76, 60, 0.1);
        color: var(--danger-color);
    }

    .btn-new-request {
        background-color: var(--success-color);
        color: white;
        border: none;
        padding: 10px 20px;
        border-radius: 8px;
        transition: all 0.3s;
    }

    .btn-new-request:hover {
        background-color: #1990f8;
        color: white;
        transform: translateY(-2px);
    }

    .action-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 36px;
        height: 36px;
        border-radius: 50%;
        transition: all 0.3s;
    }

    .action-btn:hover {
        transform: scale(1.1);
    }

    .document-preview {
        width: 40px;
        height: 40px;
        object-fit: cover;
        border-radius: 8px;
        cursor: pointer;
        transition: all 0.3s;
        border: 1px solid #eee;
    }

    .document-preview:hover {
        transform: scale(1.05);
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    .marquee-alert {
        background-color: rgba(231, 76, 60, 0.1);
        padding: 15px;
        border-left: 4px solid var(--danger-color);
        margin-bottom: 20px;
        border-radius: 4px;
        font-weight: 500;
    }

    .section-title {
        color: var(--secondary-color);
        margin-bottom: 20px;
        padding-bottom: 10px;
        border-bottom: 2px solid #eee;
    }

    /* Modal styles */
    .modal-content {
        border-radius: 16px;
        overflow: hidden;
    }

    .modal-image {
        max-width: 100%;
        max-height: 80vh;
        display: block;
        margin: 0 auto;
    }

    .retrait-badge {
        background-color: var(--danger-color);
        color: white;
        padding: 6px 12px;
        border-radius: 20px;
        font-weight: 600;
        font-size: 0.8rem;
    }
</style>
@if($naissances->contains(function ($naissance) { return $naissance->archived_at; }))
    @foreach($naissances as $naissance)
        @if($naissance->archived_at)
            <marquee behavior="" direction="left" style="font-size:15px; color:red; font-weight:bold">
                Motif d'annulation de demande pour l'extrait de {{ $naissance->nom.' '.$naissance->prenom  }} : 
                 {{ $naissance->autre_motif_text ?? $naissance->motif_annulation }}
            </marquee>
        @endif
    @endforeach
@endif
<div class="row flex-grow form-background">
    <div class="col-12 grid-margin stretch-card">
        <div class="card card-rounded">
            <div class="card-body">
                <div class="d-sm-flex justify-content-between align-items-start mb-4">
                    <h4 class="card-title card-title-dash mb-0" style="text-align:center">Les demandes d'extrait que vous avez effectué</h4>
                    <a href="{{route('user.extrait.simple')}}" class="btn btn-new-request">
                        <i class="fas fa-plus me-2"></i>Nouvelle demande
                    </a>
                </div>

                <!-- Demandes avec certificat -->
                <h5 class="section-title">Demandes avec certificat médical</h5>
                <div class="table-responsive mb-5">
                    <table class="table select-table">
                        <thead>
                            <tr>
                                <th>Référence</th>
                                <th>Enfant</th>
                                <th>Parents</th>
                                <th>Documents</th>
                                <th>Statut</th>
                                <th>Agent</th>
                                <th>Actions</th>
                                <th>Retrait</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($naissances as $naissance)
                            <tr>
                                <td>{{ $naissance->reference }}</td>
                                <td>
                                    <strong>{{ $naissance->nom.' '.$naissance->prenom }}</strong><br>
                                    <small>Né(e) le {{ $naissance->lieuNaiss }}</small>
                                </td>
                                <td>
                                    <strong>Mère:</strong> {{ $naissance->nomDefunt }}<br>
                                    <strong>Père:</strong> {{ $naissance->nompere.' '.$naissance->prenompere }}
                                </td>
                                <td>
                                    <div class="d-flex justify-content-center gap-2">
                                        @if (pathinfo($naissance->identiteDeclarant, PATHINFO_EXTENSION) === 'pdf')
                                            <a href="{{ asset('storage/' . $naissance->identiteDeclarant) }}" target="_blank">
                                                <img src="{{ asset('assets/assets/img/pdf.jpg') }}" alt="PDF" class="document-preview">
                                            </a>
                                        @else
                                            <img src="{{ asset('storage/' . $naissance->identiteDeclarant) }}" 
                                                alt="Pièce d'identité" 
                                                class="document-preview"
                                                onclick="showImage(this)">
                                        @endif

                                        @if (pathinfo($naissance->cdnaiss, PATHINFO_EXTENSION) === 'pdf')
                                            <a href="{{ asset('storage/' . $naissance->cdnaiss) }}" target="_blank">
                                                <img src="{{ asset('assets/assets/img/pdf.jpg') }}" alt="PDF" class="document-preview">
                                            </a>
                                        @else
                                            <img src="{{ asset('storage/' . $naissance->cdnaiss) }}" 
                                                alt="Certificat" 
                                                class="document-preview"
                                                onclick="showImage(this)">
                                        @endif
                                    </div>
                                </td>
                                <td>
                                    <span class="badge 
                                        @if($naissance->etat == 'en attente') badge-warning
                                        @elseif($naissance->etat == 'réçu') badge-success
                                        @else badge-danger @endif">
                                        {{ $naissance->etat }}
                                    </span>
                                </td>
                                <td>{{ $naissance->agent ? $naissance->agent->name : 'Non attribué' }}</td>
                                <td>
                                    <div class="d-flex justify-content-center gap-2">
                                        @if ($naissance->etat !== 'réçu' && $naissance->etat !== 'terminé')
                                            <button onclick="confirmDelete('{{ route('user.extrait.certificat.delete', $naissance->id) }}')" 
                                                    class="btn btn-sm btn-danger action-btn" title="Supprimer">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        @else
                                            <button class="btn btn-sm btn-secondary action-btn disabled" title="Non supprimable">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        @endif

                                        @if($naissance->archived_at)
                                            <button type="button" class="btn btn-sm btn-primary action-btn" 
                                                    data-bs-toggle="modal" 
                                                    data-bs-target="#modifierModal{{ $naissance->id }}"
                                                    title="Modifier">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                        @endif
                                    </div>
                                </td>
                                <td>
                                    <span class="retrait-badge">{{ $naissance->choix_option }}</span>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="8" class="text-center py-4">Aucune demande avec certificat trouvée</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Demandes pour tierce personne -->
                <h5 class="section-title">Demandes pour moi/une tierce personne</h5>
                <div class="table-responsive">
                    <table class="table select-table">
                        <thead>
                            <tr>
                                <th>Référence</th>
                                <th>Type</th>
                                <th>Nom sur l'extrait</th>
                                <th>Détails</th>
                                <th>Document</th>
                                <th>Statut</th>
                                <th>Agent</th>
                                <th>Actions</th>
                                <th>Retrait</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($naissancesD as $naissanceD)
                            <tr>
                                <td>{{ $naissanceD->reference }}</td>
                                <td>{{ $naissanceD->type }}</td>
                                <td>
                                    <strong>{{ $naissanceD->name.' '.$naissanceD->prenom }}</strong><br>
                                    <small>({{ $naissanceD->pour }})</small>
                                </td>
                                <td>
                                    <small>
                                        <strong>Registre:</strong> {{ $naissanceD->number }}<br>
                                        <strong>Date:</strong> {{ $naissanceD->DateR }}<br>
                                        <strong>CMU:</strong> {{ $naissanceD->CMU ?? 'N/A'}}
                                    </small>
                                </td>
                                <td>
                                    @if (pathinfo($naissanceD->CNI, PATHINFO_EXTENSION) === 'pdf')
                                        <a href="{{ asset('storage/' . $naissanceD->CNI) }}" target="_blank">
                                            <img src="{{ asset('assets/assets/img/pdf.jpg') }}" alt="PDF" class="document-preview">
                                        </a>
                                    @else
                                        <img src="{{ asset('storage/' . $naissanceD->CNI) }}" 
                                             alt="Pièce d'identité" 
                                             class="document-preview"
                                             onclick="showImage(this)">
                                    @endif
                                </td>
                                <td>
                                    <span class="badge 
                                        @if($naissanceD->etat == 'en attente') badge-warning
                                        @elseif($naissanceD->etat == 'réçu') badge-success
                                        @else badge-danger @endif">
                                        {{ $naissanceD->etat }}
                                    </span>
                                </td>
                                <td>{{ $naissanceD->agent ? $naissanceD->agent->name : 'Non attribué' }}</td>
                                <td>
                                    <div class="d-flex justify-content-center">
                                        @if ($naissanceD->etat !== 'réçu' && $naissanceD->etat !== 'terminé')
                                            <button onclick="confirmDelete('{{ route('user.extrait.simple.delete', $naissanceD->id) }}')" 
                                                    class="btn btn-sm btn-danger action-btn" title="Supprimer">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        @else
                                            <button class="btn btn-sm btn-secondary action-btn disabled" title="Non supprimable">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        @endif
                                    </div>
                                </td>
                                <td>
                                    <span class="retrait-badge">{{ $naissanceD->choix_option }}</span>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="9" class="text-center py-4">Aucune demande pour tierce personne trouvée</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modale pour afficher les images -->
<div class="modal fade" id="imageModal" tabindex="-1" aria-labelledby="imageModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="imageModalLabel">Visualisation du document</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center">
                <img id="modalImage" class="modal-image" src="" alt="Document agrandi">
            </div>
        </div>
    </div>
</div>

<!-- Modales de modification (DÉCOMMENTÉE) -->
@foreach($naissances as $naissance)
    @if($naissance->archived_at)
    <div class="modal fade" id="modifierModal{{ $naissance->id }}" tabindex="-1" role="dialog" aria-labelledby="modifierModalLabel{{ $naissance->id }}" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modifierModalLabel{{ $naissance->id }}">Modifier les informations</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="modifierForm{{ $naissance->id }}" enctype="multipart/form-data">
                        @csrf
                        @method('POST')
                        <div class="form-group mb-3">
                            <label for="newPrenom{{ $naissance->id }}" class="form-label">Nouveau prénom</label>
                            <input type="text" class="form-control" id="newPrenom{{ $naissance->id }}" name="newPrenom" value="{{ $naissance->prenom }}" required>
                        </div>
                        
                        <div class="form-group mb-3">
                            <label for="identiteDeclarant{{ $naissance->id }}" class="form-label">Pièce d'identité du déclarant</label>
                            <input type="file" class="form-control" id="identiteDeclarant{{ $naissance->id }}" name="identiteDeclarant" accept="image/*,.pdf">
                            <small class="text-muted">Formats acceptés: JPG, PNG, PDF. Laisser vide pour ne pas modifier.</small>
                        </div>
                        
                        <div class="form-group mb-3">
                            <label for="cdnaiss{{ $naissance->id }}" class="form-label">Certificat de naissance</label>
                            <input type="file" class="form-control" id="cdnaiss{{ $naissance->id }}" name="cdnaiss" accept="image/*,.pdf">
                            <small class="text-muted">Formats acceptés: JPG, PNG, PDF. Laisser vide pour ne pas modifier.</small>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                    <button type="button" class="btn btn-primary" onclick="submitForm({{ $naissance->id }})">Enregistrer</button>
                </div>
            </div>
        </div>
    </div>
    @endif
@endforeach

<!-- Scripts -->
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    // Initialiser DataTables
    $(document).ready(function() {
        $('.table').DataTable({
            responsive: true,
            language: {
                url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/fr-FR.json'
            }
        });
    });

    function showImage(imageElement) {
        const modalImage = document.getElementById('modalImage');
        modalImage.src = imageElement.src;
        const imageModal = new bootstrap.Modal(document.getElementById('imageModal'));
        imageModal.show();
    }

    function confirmDelete(url) {
        Swal.fire({
            title: 'Confirmation',
            text: "Êtes-vous sûr de vouloir supprimer cette demande ?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Oui, supprimer',
            cancelButtonText: 'Annuler',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = url;
            }
        });
    }

   function submitForm(id) {
    const form = document.getElementById('modifierForm' + id);
    const formData = new FormData(form);
    
    // Afficher un indicateur de chargement
    Swal.fire({
        title: 'Traitement en cours',
        text: 'Veuillez patienter...',
        allowOutsideClick: true,
        didOpen: () => {
            Swal.showLoading()
        }
    });
    
    // Envoyer la requête
    fetch('{{ route("modifier.prenom", ":id") }}'.replace(':id', id), {
        method: 'POST',
        body: formData,
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
    .then(response => response.json())
    .then(data => {
        Swal.close();
        if (data.success) {
            Swal.fire({
                title: 'Succès',
                text: data.message || 'Modifications enregistrées avec succès',
                icon: 'success',
                confirmButtonColor: '#3085d6'
            }).then(() => {
                location.reload();
            });
        } else {
            Swal.fire({
                title: 'Erreur',
                text: data.message || 'Une erreur est survenue',
                icon: 'error',
                confirmButtonColor: '#3085d6'
            });
        }
    })
    .catch(error => {
        Swal.close();
        Swal.fire({
            title: 'Erreur',
            text: 'Une erreur est survenue lors de la modification',
            icon: 'error',
            confirmButtonColor: '#3085d6'
        });
    });
}

    // Notifications
    @if(session('success'))
        Swal.fire({
            title: 'Succès',
            text: "{{ session('success') }}",
            icon: 'success',
            confirmButtonColor: '#3085d6'
        });
    @endif

    @if(session('error'))
        Swal.fire({
            title: 'Erreur',
            text: "{{ session('error') }}",
            icon: 'error',
            confirmButtonColor: '#3085d6'
        });
    @endif
</script>

@endsection