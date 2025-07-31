@extends('mairie.layouts.template')
@section('content')
<div class="container-fluid">
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Formulaire d'enregistrement d'hôpital</h6>
        </div>
        <div class="card-body">
            <form method="POST" action="{{route('hopital.store')}}" enctype="multipart/form-data">
                @csrf

                <div class="row">
                    <!-- Colonne de gauche -->
                    <div class="col-md-6">
                        <!-- Nom -->
                        <div class="form-group">
                            <label for="name">Nom du responsable <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}">
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Email -->
                        <div class="form-group">
                            <label for="contact">Contact de l'hôpital <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('contact') is-invalid @enderror" id="contact" name="contact" value="{{ old('contact') }}">
                            @error('contact')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Contact -->
                        <div class="form-group">
                            <label for="type">Type d'établissement <span class="text-danger">*</span></label>
                            <select class="form-control @error('type') is-invalid @enderror" id="type" name="type">
                                <option value="">Sélectionner un type</option>
                                <option value="hôpital-general">Hôpital Général</option>
                                <option value="clinique">Clinique</option>
                                <option value="pmi">PMI</option>
                                <option value="chu">CHU</option>
                                <option value="fsu">FSU</option>
                            </select>
                            @error('type')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Colonne de droite -->
                    <div class="col-md-6">
                        <!-- Profile Picture -->
                        <div class="form-group">
                            <label for="email">Email <span class="text-danger">*</span></label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email') }}">
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Commune -->
                        <div class="form-group">
                            <label for="commune">Commune <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('commune') is-invalid @enderror" id="commune" name="commune" value="Plateau" readonly>
                            @error('commune')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Nom de l'hôpital -->
                        <div class="form-group">
                            <label for="nomHop">Nom de l'hôpital <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('nomHop') is-invalid @enderror" id="nomHop" name="nomHop" value="{{ old('nomHop') }}">
                            @error('nomHop')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="form-group mt-4">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Enregistrer
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Script pour afficher le nom du fichier sélectionné -->
<script>
    document.querySelector('.custom-file-input').addEventListener('change', function(e) {
        var fileName = document.getElementById("profile_picture").files[0].name;
        var nextSibling = e.target.nextElementSibling;
        nextSibling.innerText = fileName;
    });
</script>
@endsection