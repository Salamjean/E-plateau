@extends('admin.layouts.template')

@section('content')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
<style>
    .etat-en-attente {
      background-color: orange;
      color: black;
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
    <div class="row" style="width:100%; justify-content:center">
        <div class="row" style="width:100%; justify-content:center">
            @if (Session::get('success1')) <!-- Pour la suppression -->
                <script>
                    Swal.fire({
                        icon: 'success',
                        title: 'Suppression réussie',
                        text: '{{ Session::get('success1') }}',
                        showConfirmButton: true,  // Afficher le bouton OK
                        confirmButtonText: 'OK',  // Texte du bouton
                        background: '#ffcccc',   // Couleur de fond personnalisée
                        color: '#b30000'          // Texte rouge foncé
                    });
                </script>
            @endif
        
            @if (Session::get('success')) <!-- Pour la modification -->
                <script>
                    Swal.fire({
                        icon: 'success',
                        title: 'Action réussie',
                        text: '{{ Session::get('success') }}',
                        showConfirmButton: true,  // Afficher le bouton OK
                        confirmButtonText: 'OK',  // Texte du bouton
                        background: '#ccffcc',   // Couleur de fond personnalisée
                        color: '#006600'          // Texte vert foncé
                    });
                </script>
            @endif
        
            @if (Session::get('error')) <!-- Pour une erreur générale -->
                <script>
                    Swal.fire({
                        icon: 'error',
                        title: 'Erreur',
                        text: '{{ Session::get('error') }}',
                        showConfirmButton: true,  // Afficher le bouton OK
                        confirmButtonText: 'OK',  // Texte du bouton
                        background: '#f86750',    // Couleur de fond rouge vif
                        color: '#ffffff'          // Texte blanc
                    });
                </script>
            @endif
        </div>
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Liste des extraits de Décès</h1>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Accueil</a></li>
            <li class="breadcrumb-item active" aria-current="page">Décès</li>
        </ol>
    </div>
  

    <!-- Row -->
    <div class="row">
        <!-- Datatables -->
        <div class="col-lg-12">
            <div class="card mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Les Décès Déclarés</h6>
                </div>
                <div class="table-responsive p-3">
                    <!-- Champ de recherche -->
                    <input type="text" id="searchInput" class="form-control mb-3" placeholder="Rechercher...">
                
                    <table class="table align-items-center table-flush" id="dataTable">
                        <thead class="bg-navbar text-white">
                            <tr style="font-size: 12px">
                                <th>Commune</th>
                                <th>Demandeur</th>
                                <th>Hôpital</th>
                                <th>Date de Décès</th>
                                <th>Nom du Défunt</th>
                                <th>Date de Naissance</th>
                                <th>Lieu de Naissance</th>
                                <th>Agent</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($deces as $deces)
                            <tr style="font-size: 12px">
                                <td>{{ strtoupper($deces->commune) }}</td>
                                <td>{{ $deces->user ? $deces->user->name : 'Demandeur inconnu' }}</td>
                                <td>{{ $deces->nomHopital }}</td>
                                <td>{{ $deces->dateDces }}</td>
                                <td>{{ $deces->nomDefunt }}</td>
                                <td>{{ $deces->dateNaiss }}</td>
                                <td>{{ $deces->lieuNaiss }}</td>
                                
                                <td>{{ $deces->agent ? $deces->agent->name . ' ' . $deces->agent->prenom : 'Non attribué' }}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="8" class="text-center">Aucune déclaration trouvée</td>
                            </tr>
                            @endforelse
                
                            <!-- Modal -->
                            <div class="modal fade" id="imageModal" tabindex="-1" aria-labelledby="imageModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="imageModalLabel">Aperçu de l'image</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
                                        </div>
                                        <div class="modal-body text-center">
                                            <img id="modalImage" src="{{ asset('assets/images/profiles/bébé.jpg') }}" alt="Image prévisualisée" class="img-fluid">
                                        </div>
                                    </div>
                                </div>
                            </div>
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
</div>
    <!-- Row -->
    <div class="row">
        <!-- Datatables -->
        <div class="col-lg-12">
            <div class="card mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Les Décès Déclarés</h6>
                </div>
                <div class="table-responsive p-3">
                    <table class="table align-items-center table-flush" id="dataTable">
                        <thead class="bg-navbar text-white">
                            <tr style="font-size: 12px">
                                <th>Commune</th>
                                <th>Demandeur</th>
                                <th>Nom et prénoms du défunt</th>
                                <th>Numéro du régistre</th>
                                <th>Date du régistre</th>
                                <th>Numéro CMU</th>
                                <th>Agent</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($decesdeja as $dece)
                            <tr style="font-size: 12px">
                                <td>{{ strtoupper($dece->commune) }}</td>
                                <td>{{ $dece->user ? $dece->user->name : 'Demandeur inconnu' }}</td>
                                <td>{{ $dece->name }}</td>
                                <td>{{ $dece->numberR }}</td>
                                <td>{{ $dece->dateR }}</td>
                                <td>{{ $dece->CMU }}</td>
                                <td>{{ $dece->agent ? $dece->agent->name . ' ' . $dece->agent->prenom : 'Non attribué' }}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="10" class="text-center">Aucune déclaration trouvée</td>
                            </tr>
                            @endforelse
                
                            <!-- Modal -->
                            <div class="modal fade" id="imageModal" tabindex="-1" aria-labelledby="imageModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="imageModalLabel">Aperçu de l'image</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
                                        </div>
                                        <div class="modal-body text-center">
                                            <img id="modalImage" src="{{ asset('assets/images/profiles/bébé.jpg') }}" alt="Image prévisualisée" class="img-fluid">
                                        </div>
                                    </div>
                                </div>
                            </div>
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
</div>
@endsection

<script>
function showImage(imageElement) {
    const modalImage = document.getElementById('modalImage');
    modalImage.src = imageElement.src;
}

function updateInputPlaceholder() {
    const searchType = document.getElementById('searchType').value;
    const searchInput = document.getElementById('searchInput');

    if (searchType === 'nomDefunt') {
        searchInput.placeholder = "Entrez le nom du défunt";
    } else if (searchType === 'nomHopital') {
        searchInput.placeholder = "Entrez le nom de l'hôpital";
    } else {
        searchInput.placeholder = "Entrez un critère de recherche";
    }
}

document.querySelector('form').addEventListener('submit', function(e) {
    const searchType = document.getElementById('searchType').value;
    const searchInput = document.getElementById('searchInput').value.trim();

    if (!searchType || !searchInput) {
        e.preventDefault();
        alert('Veuillez sélectionner un type de recherche et entrer un critère.');
    }
});

</script>
<script>
    function showImage(imageElement) {
      const modalImage = document.getElementById('modalImage');
  
      // Vérifier si l'image utilise déjà la valeur de remplacement (image par défaut)
      if (imageElement.src.includes('assets/images/profiles/bébé.jpg')) {
          modalImage.src = imageElement.src; // Utiliser l'image par défaut
      } else {
          modalImage.src = imageElement.src; // Utiliser l'image actuelle (valide)
      }
  }
  
  </script>

