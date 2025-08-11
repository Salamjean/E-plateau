@extends('agent.layouts.template')

@section('content')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
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
    background-color: #f8f9fa;
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
  }

  .dashboard-container {
    padding: 30px;
    max-width: 100%;
    margin: 0 10px;
  }

  .dashboard-title {
    color: var(--primary-color);
    font-weight: 700;
    margin-bottom: 30px;
    text-align: center;
    position: relative;
    padding-bottom: 15px;
  }

  .dashboard-title:after {
    content: '';
    position: absolute;
    bottom: 0;
    left: 50%;
    transform: translateX(-50%);
    width: 100px;
    height: 4px;
    background: var(--primary-color);
    border-radius: 2px;
  }

  .dashboard-card {
    border: none;
    border-radius: var(--border-radius);
    box-shadow: var(--box-shadow);
    transition: var(--transition);
    margin-bottom: 30px;
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
    padding: 18px 25px;
    font-weight: 600;
    border-bottom: none;
    display: flex;
    justify-content: space-between;
    align-items: center;
  }

  .card-header h5 {
    margin: 0;
    font-size: 1.2rem;
    font-weight: 600;
    display: flex;
    align-items: center;
  }

  .card-header i {
    font-size: 1.3rem;
    margin-right: 12px;
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
    padding: 15px;
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
    padding: 15px;
    vertical-align: middle;
    border-top: 1px solid #f1f5ff;
  }

  .badge-type {
    padding: 6px 12px;
    border-radius: 20px;
    font-size: 12px;
    font-weight: 600;
    text-transform: uppercase;
  }

  .badge-naiss {
    background-color: var(--primary-color);
    color: white;
  }

  .badge-deces {
    background-color: var(--danger-color);
    color: white;
  }

  .badge-mariage {
    background-color: var(--success-color);
    color: white;
  }

  .btn-action {
    background-color: var(--primary-color);
    border: none;
    border-radius: 20px;
    padding: 8px 15px;
    font-size: 0.9rem;
    font-weight: 500;
    transition: var(--transition);
    color: white;
    display: inline-flex;
    align-items: center;
    justify-content: center;
  }

  .btn-action:hover {
    background-color: var(--primary-dark);
    transform: translateY(-2px);
    box-shadow: 0 4px 8px rgba(0, 51, 196, 0.2);
  }

  .btn-action:active {
    transform: translateY(0);
  }

  .search-box {
    position: relative;
    margin-bottom: 20px;
  }

  .search-box input {
    padding-left: 40px;
    border-radius: 20px;
    border: 1px solid #e0e8ff;
    box-shadow: none;
    height: 40px;
    transition: var(--transition);
  }

  .search-box input:focus {
    border-color: var(--primary-color);
    box-shadow: 0 0 0 3px rgba(0, 51, 196, 0.1);
  }

  .search-box i {
    position: absolute;
    left: 15px;
    top: 50%;
    transform: translateY(-50%);
    color: var(--gray-color);
  }

  .empty-state {
    text-align: center;
    padding: 40px 0;
    color: var(--gray-color);
  }

  .empty-state i {
    font-size: 50px;
    margin-bottom: 15px;
    color: #dee2e6;
  }

  .empty-state h5 {
    font-weight: 500;
    color: var(--secondary-color);
  }

  @media (max-width: 768px) {
    .dashboard-container {
      padding: 15px;
    }
    
    .card-header {
      padding: 15px;
    }
    
    .card-header h5 {
      font-size: 1.1rem;
    }
    
    .table thead {
      display: none;
    }
    
    .table tbody tr {
      display: block;
      margin-bottom: 15px;
      border: 1px solid #f1f5ff;
      border-radius: var(--border-radius);
      padding: 10px;
    }
    
    .table tbody td {
      display: flex;
      justify-content: space-between;
      align-items: center;
      padding: 8px 15px;
      border: none;
      border-bottom: 1px solid #f1f5ff;
    }
    
    .table tbody td::before {
      content: attr(data-label);
      font-weight: 600;
      color: var(--primary-color);
      margin-right: 15px;
    }
    
    .table tbody td:last-child {
      border-bottom: none;
    }
  }
</style>

<div class="dashboard-container">
  <!-- Notifications -->
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

  <h1 class="dashboard-title">
    <i class="fas fa-history me-2"></i>Demandes récentes
  </h1>

  <!-- Naissances et Décès -->
  <div class="row">
    <!-- Naissances -->
    <div class="col-lg-6">
      <div class="dashboard-card">
        <div class="card-header">
          <h5><i class="fas fa-baby me-2"></i>Extraits de naissance</h5>
        </div>
        <div class="card-body">
          <div class="table-responsive">
            <table class="table">
              <thead>
                <tr class="text-center">
                  <th>Type</th>
                  <th>Date</th>
                  <th>Heure</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
                @foreach ([$recentNaissances, $recentNaissancesd] as $naissancesGroup)
                  @forelse ($naissancesGroup as $naissance)
                    <tr class="text-center">
                      <td>
                        <span class="badge-type badge-naiss">
                          {{ $loop->parent->index === 0 ? 'Nouveau né' : $naissance->type }}
                        </span>
                      </td>
                      <td>{{ $naissance->created_at->format('d/m/Y') }}</td>
                      <td>{{ $naissance->created_at->format('H:i') }}</td>
                      <td>
                        <form action="{{ route('naissance.traiter', $naissance->id) }}" method="POST" style="display:inline;">
                          @csrf
                          @method('POST')
                          <button type="submit" class="btn-action">
                            <i class="fas fa-download me-1"></i>Récupérer
                          </button>
                        </form>
                      </td>
                    </tr>
                  @empty
                    @if ($loop->first)
                      <tr>
                        <td colspan="5" class="empty-state">
                          <i class="fas fa-baby-carriage"></i>
                          <h5>Aucune naissance récente</h5>
                        </td>
                      </tr>
                    @endif
                    @if ($loop->last)
                      <tr>
                        <td colspan="5" class="empty-state">
                          <i class="fas fa-baby-carriage"></i>
                          <h5>Aucune naissance existante</h5>
                        </td>
                      </tr>
                    @endif
                  @endforelse
                @endforeach
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>

    <!-- Décès -->
    <div class="col-lg-6">
      <div class="dashboard-card">
        <div class="card-header">
          <h5><i class="fas fa-cross me-2"></i>Extraits de décès</h5>
        </div>
        <div class="card-body">
          {{-- <div class="search-box">
            <i class="fas fa-search"></i>
            <input type="text" id="searchDeces" class="form-control" placeholder="Rechercher...">
          </div> --}}
          <div class="table-responsive">
            <table class="table">
              <thead>
                <tr class="text-center">
                  <th>Type</th>
                  <th>Date</th>
                  <th>Heure</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody id="decesTableBody">
                @forelse ($recentDeces as $deces)
                  <tr class="text-center">
                    <td><span class="badge-type badge-deces">Décès</span></td>
                    <td>{{ $deces->created_at->format('d/m/Y') }}</td>
                    <td>{{ $deces->created_at->format('H:i') }}</td>
                    <td>
                      <form action="{{ route('deces.traiter', $deces->id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('POST')
                        <button type="submit" class="btn-action">
                          <i class="fas fa-download me-1"></i>Récupérer
                        </button>
                      </form>
                    </td>
                  </tr>
                @empty
                  <tr>
                    <td colspan="5" class="empty-state">
                      <i class="fas fa-cross"></i>
                      <h5>Aucun décès récent</h5>
                    </td>
                  </tr>
                @endforelse

                @forelse ($recentDecesdeja as $decesdeja)
                  <tr class="text-center">
                    <td><span class="badge-type badge-deces">Décès</span></td>
                    <td>{{ $decesdeja->created_at->format('d/m/Y') }}</td>
                    <td>{{ $decesdeja->created_at->format('H:i') }}</td>
                    <td>
                      <form action="{{ route('deces.traiter', $decesdeja->id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('POST')
                        <button type="submit" class="btn-action">
                          <i class="fas fa-download me-1"></i>Récupérer
                        </button>
                      </form>
                    </td>
                  </tr>
                @empty
                  <tr>
                    <td colspan="5" class="empty-state">
                      <i class="fas fa-cross"></i>
                      <h5>Aucun décès existant</h5>
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

  <!-- Mariages -->
  <div class="row">
    <div class="col-12">
      <div class="dashboard-card">
        <div class="card-header">
          <h5><i class="fas fa-ring me-2"></i>Extraits de mariage</h5>
        </div>
        <div class="card-body">
          <div class="table-responsive">
            <table class="table">
              <thead>
                <tr class="text-center">
                  <th>Type</th>
                  <th>Date</th>
                  <th>Heure</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
                @forelse ($recentMariages as $mariage)
                  <tr class="text-center">
                    <td><span class="badge-type badge-mariage">Mariage</span></td>
                    <td>{{ $mariage->created_at->format('d/m/Y') }}</td>
                    <td>{{ $mariage->created_at->format('H:i') }}</td>
                    <td>
                      <form action="{{ route('mariage.traiter', $mariage->id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('POST')
                        <button type="submit" class="btn-action">
                          <i class="fas fa-download me-1"></i>Récupérer
                        </button>
                      </form>
                    </td>
                  </tr>
                @empty
                  <tr>
                    <td colspan="5" class="empty-state">
                      <i class="fas fa-ring"></i>
                      <h5>Aucun mariage récent</h5>
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
</div>

<script>
  $(document).ready(function() {
    // Recherche dans le tableau des décès
    $('#searchDeces').on('keyup', function() {
      const value = $(this).val().toLowerCase();
      $('#decesTableBody tr').filter(function() {
        $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1);
      });
    });

    // Adaptation pour mobile
    function adaptForMobile() {
      if (window.innerWidth <= 768px) {
        // Ajout des data-labels pour l'affichage mobile
        $('table thead th').each(function() {
          const headerText = $(this).text();
          const columnIndex = $(this).index();
          $('table tbody tr td:nth-child(' + (columnIndex + 1) + ')').attr('data-label', headerText);
        });
      }
    }

    // Exécuter au chargement et lors du redimensionnement
    adaptForMobile();
    $(window).resize(adaptForMobile);
  });
</script>
@endsection