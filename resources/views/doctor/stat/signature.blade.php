@extends('doctor.layouts.template') 

@section('content')
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion de Signature</title>
    
    <!-- Insertion de SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    
    <style>
        /* Variables de couleurs */
        :root {
            --primary-color: #009efb;
            --primary-dark: #007acd;
            --primary-light: #e6f4ff;
            --success-color: #28a745;
            --danger-color: #dc3545;
            --warning-color: #ffc107;
            --text-color: #2c3e50;
            --light-bg: #f8f9fa;
            --white: #ffffff;
            --border-radius: 10px;
            --box-shadow: 0 5px 15px rgba(0, 158, 251, 0.15);
            --transition: all 0.3s ease;
        }

        /* Styling global */
        body {
            font-family: 'Poppins', 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: var(--light-bg);
            color: var(--text-color);
            line-height: 1.6;
            margin: 0;
            padding: 0;
        }

        .main-container {
            max-width: 900px;
            margin: 30px auto;
            background: var(--white);
            border-radius: var(--border-radius);
            box-shadow: var(--box-shadow);
            overflow: hidden;
            transition: var(--transition);
        }

        .page-header {
            background: linear-gradient(135deg, var(--primary-color), var(--primary-dark));
            color: white;
            padding: 25px 30px;
            text-align: center;
            position: relative;
        }

        .page-header h1 {
            margin: 0;
            font-size: 28px;
            font-weight: 600;
        }

        .page-header:after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            height: 4px;
            background: rgba(255, 255, 255, 0.3);
        }

        .content-container {
            padding: 30px;
        }

        /* Alertes */
        .alert {
            padding: 15px 20px;
            border-radius: var(--border-radius);
            margin-bottom: 25px;
            font-weight: 500;
            display: flex;
            align-items: center;
        }

        .alert-success {
            background-color: #d4edda;
            color: #155724;
            border-left: 4px solid var(--success-color);
        }

        .alert-danger {
            background-color: #f8d7da;
            color: #721c24;
            border-left: 4px solid var(--danger-color);
        }

        .alert i {
            margin-right: 10px;
            font-size: 20px;
        }

        /* Cartes */
        .card {
            background: var(--white);
            border-radius: var(--border-radius);
            padding: 25px;
            box-shadow: 0 3px 10px rgba(0, 0, 0, 0.05);
            margin-bottom: 25px;
            transition: var(--transition);
            border-left: 4px solid var(--primary-color);
        }

        .card:hover {
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }

        .card-title {
            font-weight: 600;
            color: var(--primary-color);
            margin: 0 0 15px 0;
            font-size: 20px;
            display: flex;
            align-items: center;
        }

        .card-title i {
            margin-right: 10px;
            font-size: 24px;
        }

        /* Signature actuelle */
        .signature-preview {
            text-align: center;
            margin: 20px 0;
            padding: 20px;
            background: var(--primary-light);
            border-radius: var(--border-radius);
            border: 2px dashed var(--primary-color);
        }

        .signature-image {
            max-width: 300px;
            max-height: 150px;
            border-radius: 5px;
            box-shadow: 0 3px 10px rgba(0, 0, 0, 0.1);
            transition: var(--transition);
        }

        .signature-image:hover {
            transform: scale(1.03);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
        }

        .no-signature {
            color: var(--danger-color);
            font-style: italic;
            text-align: center;
            padding: 20px;
            background: #fff5f5;
            border-radius: var(--border-radius);
        }

        /* Formulaire */
        .form-label {
            font-weight: 600;
            color: var(--text-color);
            margin-bottom: 8px;
            display: block;
        }

        .form-input {
            width: 100%;
            padding: 12px 15px;
            border: 2px solid #e2e8f0;
            border-radius: var(--border-radius);
            font-size: 16px;
            transition: var(--transition);
            background: var(--light-bg);
        }

        .form-input:focus {
            outline: none;
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(0, 158, 251, 0.2);
            background: var(--white);
        }

        .form-text {
            font-size: 13px;
            color: #718096;
            margin-top: 5px;
        }

        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 12px 25px;
            border-radius: 30px;
            font-weight: 600;
            text-decoration: none;
            transition: var(--transition);
            border: none;
            cursor: pointer;
            font-size: 16px;
        }

        .btn-primary {
            background: linear-gradient(135deg, var(--primary-color), var(--primary-dark));
            color: var(--white);
            box-shadow: 0 4px 8px rgba(0, 158, 251, 0.3);
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 12px rgba(0, 158, 251, 0.4);
        }

        .btn i {
            margin-right: 8px;
        }

        /* Lien de création de signature */
        .signature-help {
            background: #fff9e6;
            border-left: 4px solid var(--warning-color);
            padding: 15px 20px;
            border-radius: var(--border-radius);
            margin: 20px 0;
        }

        .signature-help a {
            color: var(--primary-color);
            font-weight: 600;
            text-decoration: none;
            transition: var(--transition);
        }

        .signature-help a:hover {
            color: var(--primary-dark);
            text-decoration: underline;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .main-container {
                margin: 15px;
                width: auto;
            }
            
            .content-container {
                padding: 20px;
            }
            
            .page-header h1 {
                font-size: 22px;
            }
            
            .flex-container {
                flex-direction: column;
            }
            
            .signature-image {
                max-width: 100%;
            }
        }

        /* Animation pour l'apparition des éléments */
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .card {
            animation: fadeIn 0.5s ease forwards;
        }
    </style>
</head>
<body>
    <div class="main-container">
        <!-- En-tête de page -->
        <div class="page-header">
            <h1 class="text-white"><i class="fas fa-signature text-white"></i> Gestion de votre signature électronique</h1>
        </div>

        <div class="content-container">
            <!-- Messages d'alerte -->
            @if(session('success'))
                <div class="alert alert-success">
                    <i class="fas fa-check-circle"></i>
                    {{ session('success') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="alert alert-danger">
                    <i class="fas fa-exclamation-circle"></i>
                    <div>
                        <strong>Veuillez corriger les erreurs suivantes :</strong>
                        <ul style="margin: 10px 0 0 20px;">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @endif

            <!-- Carte: Signature actuelle -->
            <div class="card">
                <h3 class="card-title"><i class="fas fa-id-card"></i> Votre Signature Actuelle</h3>
                
                @if($sousAdmin->signature)
                    <div class="signature-preview">
                        <img src="{{ Storage::url($sousAdmin->signature) }}" 
                             alt="Signature de {{ $sousAdmin->name }} {{ $sousAdmin->prenom }}" 
                             class="signature-image">
                    </div>
                @else
                    <div class="no-signature">
                        <i class="fas fa-exclamation-triangle" style="font-size: 24px; margin-bottom: 10px;"></i>
                        <p>Aucune signature enregistrée.</p>
                    </div>
                @endif
            </div>

            <!-- Aide pour la signature -->
            <div class="signature-help">
                <h4><i class="fas fa-question-circle"></i> Avez-vous une signature électronique ?</h4>
                <p>Si non, <a href="https://createmysignature.com/fr" target="_blank">cliquez ici pour en créer une gratuitement</a></p>
            </div>

            <!-- Carte: Mise à jour de la signature -->
            <div class="card">
                <h3 class="card-title"><i class="fas fa-sync-alt"></i> Mettre à Jour votre Signature</h3>
                
                <form action="{{ route('doctor.signature.update') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('POST')

                    <div style="margin-bottom: 20px;">
                        <label for="signature" class="form-label">
                            <i class="fas fa-file-image"></i> Choisir une nouvelle signature (Image)
                        </label>
                        <input class="form-input" type="file" id="signature" name="signature" accept=".jpeg,.png,.jpg,.gif,.svg">
                        <div class="form-text">Formats autorisés: jpeg, png, jpg, gif, svg. Taille max: 2Mo.</div>
                    </div>

                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-upload"></i> Mettre à Jour la Signature
                    </button>
                </form>
            </div>
        </div>
    </div>

    <script>
        // Animation pour faire apparaître les éléments progressivement
        document.addEventListener('DOMContentLoaded', function() {
            const cards = document.querySelectorAll('.card');
            cards.forEach(card => {
                card.style.opacity = '0';
            });
        });

        // Confirmation avant soumission du formulaire
        document.querySelector('form').addEventListener('submit', function(e) {
            const fileInput = document.getElementById('signature');
            if (fileInput.files.length > 0) {
                // Vérification de la taille du fichier (2Mo max)
                const fileSize = fileInput.files[0].size / 1024 / 1024; // en MB
                if (fileSize > 2) {
                    e.preventDefault();
                    Swal.fire({
                        icon: 'error',
                        title: 'Fichier trop volumineux',
                        text: 'La taille du fichier ne doit pas dépasser 2Mo.',
                        confirmButtonColor: '#009efb'
                    });
                    return false;
                }
            }
        });
    </script>
</body>
</html>
@endsection