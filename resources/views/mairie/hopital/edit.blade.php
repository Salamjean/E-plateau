@extends('mairie.layouts.template')
@section('content')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12 col-lg-12">
            <div class="card shadow-sm border-0 rounded-lg">
                <div class="card-header  text-white py-3" style="background-color: #0033c4">
                    <h4 class="m-0 text-center">
                        <i class="fas fa-edit mr-2"></i>Modifier l'Établissement de Santé
                    </h4>
                </div>
                <div class="card-body p-4">
                    <form method="POST" action="{{ route('hopital.update', $hopital->id) }}" enctype="multipart/form-data" class="needs-validation" novalidate>
                        @csrf
                        @method('PUT')

                        <div class="row">
                            <!-- Nom de l'hôpital -->
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="nomHop" class="form-label small font-weight-bold">Nom de l'établissement <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light"><i class="fas fa-hospital text-primary"></i></span>
                                        <input type="text" class="form-control form-control-sm @error('nomHop') is-invalid @enderror" 
                                            id="nomHop" name="nomHop" value="{{ old('nomHop', $hopital->nomHop) }}" 
                                            placeholder="Ex: Hôpital Général de Plateau" required>
                                    </div>
                                    @error('nomHop')
                                        <div class="text-danger small mt-1">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Type d'établissement -->
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="type" class="form-label small font-weight-bold">Type <span class="text-danger">*</span></label><br>
                                    <select class="form-select form-select-sm @error('type') is-invalid @enderror" 
                                            id="type" name="type" required>
                                        <option value="" disabled>Choisir...</option>
                                        <option value="hôpital-general" {{ old('type', $hopital->type) == 'hôpital-general' ? 'selected' : '' }}>Hôpital Général</option>
                                        <option value="clinique" {{ old('type', $hopital->type) == 'clinique' ? 'selected' : '' }}>Clinique</option>
                                        <option value="pmi" {{ old('type', $hopital->type) == 'pmi' ? 'selected' : '' }}>PMI</option>
                                        <option value="chu" {{ old('type', $hopital->type) == 'chu' ? 'selected' : '' }}>CHU</option>
                                        <option value="fsu" {{ old('type', $hopital->type) == 'fsu' ? 'selected' : '' }}>FSU</option>
                                    </select>
                                    @error('type')
                                        <div class="text-danger small mt-1">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <!-- Responsable -->
                                <div class="form-group mb-3">
                                    <label for="name" class="form-label small font-weight-bold">Responsable <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light"><i class="fas fa-user text-primary"></i></span>
                                        <input type="text" class="form-control form-control-sm @error('name') is-invalid @enderror" 
                                               id="name" name="name" value="{{ old('name', $hopital->name) }}" 
                                               placeholder="Nom complet" required>
                                    </div>
                                    @error('name')
                                        <div class="text-danger small mt-1">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <!-- Contact -->
                                <div class="form-group mb-3">
                                    <label for="contact" class="form-label small font-weight-bold">Contact <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light"><i class="fas fa-phone text-primary"></i></span>
                                        <input type="tel" class="form-control form-control-sm @error('contact') is-invalid @enderror" 
                                               id="contact" name="contact" value="{{ old('contact', $hopital->contact) }}" 
                                               placeholder="XX XX XX XX XX" required>
                                    </div>
                                    @error('contact')
                                        <div class="text-danger small mt-1">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Email -->
                        <div class="form-group mb-3">
                            <label for="email" class="form-label small font-weight-bold">Email <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text bg-light"><i class="fas fa-envelope text-primary"></i></span>
                                <input type="email" class="form-control form-control-sm @error('email') is-invalid @enderror" 
                                       id="email" name="email" value="{{ old('email', $hopital->email) }}" 
                                       placeholder="contact@exemple.ci" required>
                            </div>
                            @error('email')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Commune -->
                        <div class="form-group mb-4">
                            <label for="commune" class="form-label small font-weight-bold">Commune</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light"><i class="fas fa-map-marker-alt text-primary"></i></span>
                                <input type="text" class="form-control form-control-sm bg-light" 
                                       id="commune" name="commune" value="{{ old('commune', $hopital->commune) }}" readonly>
                            </div>
                        </div>

                        <!-- Photo -->
                        <div class="form-group mb-4">
                            <label for="profile_picture" class="form-label small font-weight-bold">Photo de profil (optionnelle)</label>
                            <input type="file" class="form-control form-control-sm @error('profile_picture') is-invalid @enderror" 
                                   id="profile_picture" name="profile_picture">
                            @if($hopital->profile_picture)
                                <div class="mt-2">
                                    <img src="{{ asset('storage/' . $hopital->profile_picture) }}" alt="Profil" width="120" class="img-thumbnail">
                                </div>
                            @endif
                            @error('profile_picture')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Boutons -->
                        <div class="d-grid gap-2 d-md-flex justify-content-md-center mt-4">
                            <button type="submit" class="btn btn-sm px-4 rounded-pill text-white" style="background-color: #0033c4">
                                <i class="fas fa-save mr-2"></i> Mettre à jour
                            </button>
                            <a href="{{ route('hopital.index') }}" class="btn btn-outline-secondary btn-sm px-4 rounded-pill">
                                <i class="fas fa-times mr-2"></i> Annuler
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .card {
        margin-top: 100px;
        border: none;
        box-shadow: 0 0.25rem 0.75rem rgba(0, 0, 0, 0.05);
    }
    .card-header {
        border-radius: 0.3rem 0.3rem 0 0 !important;
    }
    .form-control-sm {
        padding: 0.25rem 0.5rem;
        font-size: 0.875rem;
        height: calc(50px + 2px);
    }
    .form-select-sm {
        padding: 0.25rem 0.5rem;
        width: 515px;
        font-size: 0.875rem;
        height: calc(50px + 2px);
    }
    .input-group-text {
        padding: 0.25rem 0.5rem;
        font-size: 0.875rem;
    }
    .form-label {
        margin-bottom: 0.25rem;
    }
    .btn-sm {
        padding: 0.25rem 0.8rem;
        font-size: 0.875rem;
    }
    .rounded-lg {
        border-radius: 0.5rem !important;
    }
</style>

<script>
// Validation Bootstrap
(function() {
    'use strict';
    window.addEventListener('load', function() {
        var forms = document.getElementsByClassName('needs-validation');
        Array.prototype.filter.call(forms, function(form) {
            form.addEventListener('submit', function(event) {
                if (form.checkValidity() === false) {
                    event.preventDefault();
                    event.stopPropagation();
                }
                form.classList.add('was-validated');
            }, false);
        });
    }, false);
})();

// Formatage du numéro de téléphone
document.getElementById('contact').addEventListener('input', function(e) {
    var x = e.target.value.replace(/\D/g, '').match(/(\d{0,2})(\d{0,2})(\d{0,2})(\d{0,2})(\d{0,2})/);
    e.target.value = !x[2] ? x[1] : x[1] + ' ' + x[2] + (x[3] ? ' ' + x[3] : '') + (x[4] ? ' ' + x[4] : '') + (x[5] ? ' ' + x[5] : '');
});
</script>
@endsection
