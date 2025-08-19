@extends('poste.layouts.template')

@section('content')
<style>
    :root {
        --primary-color: #06634e;
        --secondary-color: #f9cf03;
        --light-color: #f8f9fa;
        --dark-color: #343a40;
    }
    
    body {
        display: flex;
        flex-direction: column;
        min-height: 100vh;
    }
    
    .center-container {
        display: flex;
        justify-content: center;
        align-items: center;
        flex: 1;
        padding: 2rem 0;
    }
    
    .attribution-card {
        border-radius: 15px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        border: none;
        overflow: hidden;
        width: 100%;
        max-width: 800px;
        margin: auto;
    }
    
    .attribution-header {
        background: linear-gradient(135deg, var(--primary-color), #044a3a);
        color: white;
        padding: 1.5rem;
        font-size: 1.5rem;
        font-weight: 600;
        text-align: center;
        border-bottom: 4px solid var(--secondary-color);
    }
    
    .attribution-body {
        padding: 2.5rem;
        background-color: white;
    }
    
    .form-label {
        color: var(--primary-color);
        font-weight: 500;
        display: block;
        margin-bottom: 0.75rem;
    }
    
    .form-control {
        border-radius: 8px;
        padding: 12px 15px;
        border: 2px solid #e9ecef;
        transition: all 0.3s;
        width: 100%;
    }
    
    .form-control:focus {
        border-color: var(--secondary-color);
        box-shadow: 0 0 0 0.2rem rgba(249, 207, 3, 0.25);
    }
    
    .btn-attribuer {
        background-color: var(--primary-color);
        color: white;
        border: none;
        padding: 12px 30px;
        border-radius: 8px;
        font-weight: 600;
        letter-spacing: 0.5px;
        transition: all 0.3s;
        text-transform: uppercase;
        width: 100%;
        max-width: 300px;
        margin: 0 auto;
        display: block;
    }
    
    .btn-attribuer:hover {
        background-color: #044a3a;
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(6, 99, 78, 0.3);
    }
    
    .search-icon {
        position: absolute;
        right: 15px;
        top: 50%;
        transform: translateY(-50%);
        color: var(--primary-color);
    }
    
    .input-group {
        position: relative;
        margin-bottom: 0.5rem;
    }
    
    .illustration {
        max-width: 180px;
        margin: 0 auto 30px;
        display: block;
    }
    
    .help-link {
        color: var(--primary-color);
        transition: color 0.3s;
    }
    
    .help-link:hover {
        color: #033a2e;
        text-decoration: none;
    }
    
    @media (max-width: 768px) {
        .attribution-body {
            padding: 1.75rem;
        }
        
        .center-container {
            padding: 1rem;
        }
        
        .illustration {
            max-width: 150px;
        }
    }
</style>
<div class="center-container">
    <div class="attribution-card">
        <div class="attribution-header">
            <i class="fas fa-tasks mr-2"></i> Verifier le colis
        </div>
        
        <div class="attribution-body">
            <img src="{{ asset('assets/assets/img/logo plateau.png') }}" alt="Illustration" class="illustration">
            
            <form method="POST" action="{{ route('poste.attribuer-demande') }}">
                @csrf

                <div class="mb-4">
                    <label for="reference" class="form-label">
                        <i class="fas fa-search mr-2"></i> Saisissez la référence ou le code de livraison
                    </label>
                    
                    <div class="input-group">
                        <input id="reference" type="text" 
                               class="form-control @error('reference') is-invalid @enderror" 
                               name="reference" 
                               value="{{ old('reference') }}" 
                               placeholder="Ex: AN0001X2023" 
                               required 
                               autocomplete="off">
                        <i class="fas fa-barcode search-icon"></i>
                        
                        @error('reference')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    
                    <small class="text-muted">
                        Le code de livraison se trouve sur l'enveloppe.
                    </small>
                </div>

                <div class="text-center mt-4">
                    <button type="submit" class="btn btn-attribuer">
                        <i class="fas fa-paper-plane mr-2"></i> Verifier à ma poste
                    </button>
                </div>
            </form>
            
            <div class="text-center mt-4 pt-3">
                <a href="#" class="help-link">
                    <i class="fas fa-question-circle mr-2"></i> Aide sur l'attribution des demandes
                </a>
            </div>
        </div>
    </div>
</div>
<!-- Font Awesome pour les icônes -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
<!-- SweetAlert2 CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const inputRef = document.getElementById('reference');
        const searchIcon = inputRef.parentElement.querySelector('.search-icon');
        
        inputRef.addEventListener('focus', function() {
            searchIcon.style.color = '#f9cf03';
            this.parentElement.style.boxShadow = '0 0 0 2px rgba(249, 207, 3, 0.3)';
        });
        
        inputRef.addEventListener('blur', function() {
            searchIcon.style.color = '#06634e';
            this.parentElement.style.boxShadow = 'none';
        });

        // Afficher les messages SweetAlert2 si nécessaire
        @if(session('success'))
            Swal.fire({
                icon: 'success',
                title: 'Succès',
                text: '{{ session('success') }}',
                confirmButtonColor: '#06634e',
                confirmButtonText: 'OK',
                timer: 3000,
                timerProgressBar: true
            });
        @endif

        @if(session('error'))
            Swal.fire({
                icon: 'error',
                title: 'Erreur',
                text: '{{ session('error') }}',
                confirmButtonColor: '#d33',
                confirmButtonText: 'OK'
            });
        @endif

        @if($errors->any())
            Swal.fire({
                icon: 'error',
                title: 'Erreur',
                html: `@foreach ($errors->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach`,
                confirmButtonColor: '#d33',
                confirmButtonText: 'OK'
            });
        @endif
    });
</script>
@endsection