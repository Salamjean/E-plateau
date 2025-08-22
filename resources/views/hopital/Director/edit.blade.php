@extends('hopital.layouts.template')

@section('content')

<div class="ms-content-wrapper">
    <div class="row">
        <div class="col-md-12">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb pl-0">
                    <li class="breadcrumb-item">
                        <a href="{{ route('doctor.dashboard') }}">
                            <i class="material-icons">home</i> Tableau de bord
                        </a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="{{ route('directeur.create') }}">Liste de directeurs</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">Modifier le directeur</li>
                </ol>
            </nav>
        </div>
        <div class="col-xl-12 col-md-12">
            <div class="ms-panel">
                <div class="ms-panel-header ms-panel-custome">
                    <h6 class="text-white">Modifier ce directeur</h6>
                    <a href="{{ route('directeur.create') }}" class="add-patient">
                        <i class="fas fa-arrow-left"></i> Liste des directeurs
                    </a>
                </div>
                <div class="ms-panel-body">
                    <form class="needs-validation modern-form" method="POST" enctype="multipart/form-data" action="{{ route('directeur.update', $director->id) }}" novalidate>
                        @csrf
                        @method('PUT')

                        <!-- Nom et Prénom -->
                        <div class="form-row">
                            <div class="col-md-6 mb-3">
                                <label for="validationCustom001">Nom</label>
                                <div class="input-group">
                                    <input type="text" class="form-control modern-input" name="name" value="{{ $director->name }}" id="validationCustom001" placeholder="Entrez son nom" required>
                                    <div class="valid-feedback">Correct</div>
                                </div>
                                @error('name')
                                    <div class="text-danger text-center error-message">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="validationCustom002">Prénom</label>
                                <div class="input-group">
                                    <input type="text" class="form-control modern-input" name="prenom" value="{{ $director->prenom }}" id="validationCustom002" placeholder="Entrez son prénom" required>
                                    <div class="valid-feedback">Correct</div>
                                </div>
                                @error('prenom')
                                    <div class="text-danger text-center error-message">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Email et Contact -->
                        <div class="form-row">
                            <div class="col-md-6 mb-2">
                                <label for="validationCustom003">Email</label>
                                <div class="input-group">
                                    <input type="email" class="form-control modern-input" name="email" value="{{ $director->email }}" id="validationCustom003" placeholder="Entrez son email" required>
                                    <div class="valid-feedback">Correct</div>
                                </div>
                                @error('email')
                                    <div class="text-danger text-center error-message">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="validationCustom009">Contact</label>
                                <div class="input-group">
                                    <input type="text" class="form-control modern-input" name="contact" value="{{ $director->contact }}" id="validationCustom009" placeholder="Son numéro" required>
                                    <div class="valid-feedback">Correct</div>
                                </div>
                                @error('contact')
                                    <div class="text-danger text-center error-message">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Bouton de soumission -->
                        <div class="text-center mt-4">
                            <button class="btn modern-btn w-25" type="submit">Appliquer la modification</button>
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
    
    .add-patient {
        background-color: white;
        color: var(--primary-color);
        padding: 10px 20px;
        border-radius: 30px;
        font-size: 14px;
        font-weight: 500;
        text-decoration: none;
        display: flex;
        align-items: center;
        transition: all 0.3s ease;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    }
    
    .add-patient:hover {
        background-color: var(--primary-hover);
        color: white;
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.15);
    }
    
    .ms-panel-body {
        padding: 30px;
        background-color: white;
    }
    
    .modern-form {
        background-color: white;
        padding: 0;
    }
    
    .modern-input {
        border: 2px solid #e9ecef;
        border-radius: 8px;
        padding: 12px 15px;
        transition: all 0.3s ease;
        font-size: 14px;
    }
    
    .modern-input:focus {
        border-color: var(--primary-color);
        box-shadow: 0 0 0 3px rgba(0, 158, 251, 0.2);
        outline: none;
    }
    
    .modern-input::placeholder {
        color: #adb5bd;
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