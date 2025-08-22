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
                <div class="ms-panel-header ms-panel-custome">
                    <h6 class="text-white">Ajout d'un centre de santé</h6>
                </div>
                
                <div class="ms-panel-body">
                    <form class="needs-validation modern-form" method="POST" enctype="multipart/form-data" action="{{ route('sanitary.store') }}" novalidate>
                        @csrf
                        @method('POST')

                        <!-- Nom et Type -->
                        <div class="form-row">
                            <div class="col-md-6 mb-3">
                                <label for="validationCustom001">Nom du centre de santé</label>
                                <div class="input-group">
                                    <input type="text" class="form-control modern-input" name="name_hospial" id="validationCustom001" placeholder="Entrez le nom du centre" required>
                                    <div class="valid-feedback">Correct</div>
                                </div>
                                @error('name_hospial')
                                    <div class="text-danger text-center error-message">{{ $message }}</div>
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
                                    <div class="text-danger text-center error-message">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Bouton de soumission -->
                        <div class="text-center mt-4">
                            <button class="btn modern-btn w-25" type="submit">Enregistrer</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    :root {
        --primary-color: #009efb;
        --primary-hover: #0088e0;
        --light-bg: #f8f9fa;
        --border-radius: 10px;
        --box-shadow: 0 5px 15px rgba(0, 158, 251, 0.1);
    }
    
    .ms-panel {
        border-radius: var(--border-radius);
        box-shadow: var(--box-shadow);
        border: none;
        overflow: hidden;
    }
    
    .ms-panel-header {
        background: var(--primary-color);
        color: white;
        padding: 20px;
        border-radius: var(--border-radius) var(--border-radius) 0 0 !important;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    
    .ms-panel-header h6 {
        margin: 0;
        font-weight: 600;
        font-size: 1.2rem;
    }
    
    .ms-panel-body {
        padding: 30px;
        background-color: white;
    }
    
    .modern-form {
        background-color: white;
        padding: 0;
    }
    
    .modern-input, .modern-select {
        border: 2px solid #e9ecef;
        border-radius: 8px;
        padding: 12px 15px;
        transition: all 0.3s ease;
        font-size: 14px;
    }
    
    .modern-input:focus, .modern-select:focus {
        border-color: var(--primary-color);
        box-shadow: 0 0 0 3px rgba(0, 158, 251, 0.2);
        outline: none;
    }
    
    .modern-input::placeholder {
        color: #adb5bd;
    }
    
    .modern-select {
        appearance: none;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='%23009efb' viewBox='0 0 16 16'%3E%3Cpath d='M8 12L2 6h12L8 12z'/%3E%3C/svg%3E");
        background-repeat: no-repeat;
        background-position: right 15px center;
        background-size: 16px;
    }
    
    .modern-btn {
        background-color: var(--primary-color);
        color: white;
        border: none;
        border-radius: 30px;
        padding: 12px 30px;
        font-weight: 600;
        font-size: 16px;
        transition: all 0.3s ease;
        box-shadow: 0 4px 10px rgba(0, 158, 251, 0.3);
    }
    
    .modern-btn:hover {
        background-color: var(--primary-hover);
        transform: translateY(-2px);
        box-shadow: 0 6px 15px rgba(0, 158, 251, 0.4);
    }
    
    .error-message {
        background-color: #fff5f5;
        color: #e53e3e;
        padding: 8px 12px;
        border-radius: 6px;
        margin-top: 5px;
        font-size: 14px;
        border-left: 3px solid #e53e3e;
    }
    
    .breadcrumb {
        background-color: transparent;
        padding: 0;
        margin-bottom: 20px;
    }
    
    .breadcrumb-item a {
        color: var(--primary-color);
        text-decoration: none;
        transition: color 0.2s;
    }
    
    .breadcrumb-item a:hover {
        color: var(--primary-hover);
        text-decoration: underline;
    }
    
    .breadcrumb-item.active {
        color: #6c757d;
    }
    
    label {
        font-weight: 500;
        margin-bottom: 8px;
        color: #495057;
    }
    
    @media (max-width: 768px) {
        .ms-panel-header {
            flex-direction: column;
            gap: 15px;
            align-items: flex-start;
        }
        
        .modern-btn {
            width: 100% !important;
        }
        
        .form-row {
            flex-direction: column;
        }
        
        .col-md-6 {
            width: 100%;
            margin-bottom: 15px;
        }
    }
</style>

@endsection