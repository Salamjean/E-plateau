@extends('hopital.layouts.template')

@section('content')

<div class="ms-content-wrapper">
    <div class="row">
        <div class="col-md-12">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb pl-0">
                    <li class="breadcrumb-item">
                        <a href="#">
                            <i class="material-icons">home</i> Tableau de bord
                        </a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">Ajout d'un centre de santé</li>
                </ol>
            </nav>
        </div>

        <div class="col-xl-12 col-md-12">
            <div class="ms-panel">
                
                <div class="ms-panel-body">
                    <form class="needs-validation" method="POST" enctype="multipart/form-data" action="{{ route('sanitary.store') }}" novalidate>
                        @csrf
                        @method('POST')

                        <!-- Nom et Prénom -->
                        <div class="form-row">
                            <div class="col-md-6 mb-3">
                                <label for="validationCustom001">Nom du centre de santé </label>
                                <div class="input-group">
                                    <input type="text" class="form-control" name="name_hospial" id="validationCustom001" placeholder="Entre son nom" required>
                                    <div class="valid-feedback">Correct</div>
                                </div>
                                @error('name_hospial')
                                    <div class="text-danger text-center">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="fonctionSelect">Type de centre de santé</label>
                                <div class="input-group">
                                    <select class="form-control" name="type" id="fonctionSelect" required>
                                        <option value="" disabled selected>Sélectionnez un type</option>
                                        <option value="hôpital-general" {{ old('type') == 'hôpital-general' ? 'selected' : '' }}>Hôpital Général</option>
                                        <option value="clinique" {{ old('type') == 'clinique' ? 'selected' : '' }}>Clinique</option>
                                        <option value="pmi" {{ old('type') == 'pmi' ? 'selected' : '' }}>PMI</option>
                                        <option value="chu" {{ old('type') == 'chu' ? 'selected' : '' }}>CHU</option>
                                        <option value="fsu" {{ old('type') == 'fsu' ? 'selected' : '' }}>FSU</option>
                                    </select>
                                    <div class="valid-feedback">Correct</div>
                                </div>
                                @error('type')
                                    <div class="text-danger text-center">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Bouton de soumission -->
                        <div class="text-center mt-4">
                            <button class="btn btn-primary w-25" type="submit">Enregistrer</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection