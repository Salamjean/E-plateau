@extends('admin.layouts.template')

@section('content')
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
 <!-- Insertion de SweetAlert2 -->
 <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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

<div class="container-fluid" id="container-wrapper">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
      <h1 class="h3 mb-0 text-gray-800">Listes des demandes d'extrait de Naissance</h1>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Accueil</a></li>
        <li class="breadcrumb-item">Listes</li>
      </ol>
    </div>

    <!-- Row -->
    <div class="row">
      <!-- Datatables -->
      <div class="col-lg-12">
        <div class="card mb-4">
          <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary">Les extraits demandés avec certificat</h6>
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
                        <th>Nom et Prénoms de la mère</th>
                        <th>Nom et Prénoms (choisir) du né</th>
                        <th>Nom et Prénoms du père</th>
                        <th>Date de Naissance de l'enfant</th>
                        <th>Agent</th>
                    </tr>
                </thead>
                
                <tbody>
                    @forelse ($naissances as $naissance)
                    <tr style="font-size: 12px">
                        <td>{{ strtoupper($naissance->commune) }}</td>
                        <td>{{ $naissance->user ? $naissance->user->name : 'Demandeur inconnu' }}</td>
                        <td>{{ $naissance->nomHopital }}</td>
                        <td>{{ $naissance->nomDefunt }}</td>
                        <td>{{ $naissance->nom . ' ' . $naissance->prenom }}</td>
                        <td>{{ $naissance->nompere . ' ' . $naissance->prenompere }}</td>
                        <td>{{ $naissance->lieuNaiss }}</td>
                        </td>
                        <td>{{ $naissance->agent ? $naissance->agent->name . ' ' . $naissance->agent->prenom : 'Non attribué' }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="9" class="text-center">Aucune demande effectuée</td>
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
        </div>
      </div>

    <div class="row">
      <!-- Datatables -->
      <div class="row">
        <!-- Datatables -->
        <div class="col-lg-12">
            <div class="card mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Les extraits demandés</h6>
                </div>
                <div class="table-responsive p-3">
                    <!-- Champ de recherche -->
                    
    
                    <table class="table text-center align-items-center table-flush" id="dataTable">
                        <thead class="bg-navbar text-white">
                            <tr style="font-size: 12px">
                                <th>Commune</th>
                                <th>Demandeur</th>
                                <th>Type de demande</th>
                                <th>Nom sur l'extrait</th>
                                <th>Numéro de régistre</th>
                                <th>Date de régistre</th>
                                <th>Agent</th>
                            </tr>
                        </thead>
                        
                        <tbody>
                            @forelse ($naissancesD as $naissanceD)
                            <tr style="font-size: 12px">
                                <td>{{strtoupper ($naissanceD->commune) }}</td>
                                <td>{{ $naissanceD->user ? $naissanceD->user->name : 'Demandeur inconnu' }}</td>
                                <td>{{ $naissanceD->type }}</td>
                                <td>{{ $naissanceD->name }}</td>
                                <td>{{ $naissanceD->number }}</td>
                                <td>{{ $naissanceD->DateR }}</td>
                                <td>{{ $naissanceD->agent ? $naissanceD->agent->name . ' ' . $naissanceD->agent->prenom : 'Non attribué' }}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="text-center">Aucune demande effectuée</td>
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
            </div>
        </div>
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
@endsection

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