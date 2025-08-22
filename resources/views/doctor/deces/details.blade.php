@extends('doctor.layouts.template')

@section('content')
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Détails de la déclaration - {{ $deceshop->NomM }}</title>
    
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
            max-width: 1000px;
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

        .back-button {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            background: var(--white);
            color: var(--primary-color);
            padding: 12px 25px;
            border-radius: 30px;
            text-decoration: none;
            font-weight: 600;
            margin: 20px auto;
            transition: var(--transition);
            box-shadow: 0 3px 10px rgba(0, 0, 0, 0.1);
        }

        .back-button i {
            margin-right: 8px;
            transition: var(--transition);
        }

        .back-button:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.15);
            background: var(--primary-light);
        }

        .details-container {
            padding: 30px;
        }

        .details-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }

        .detail-card {
            background: var(--white);
            border-radius: var(--border-radius);
            padding: 20px;
            box-shadow: 0 3px 10px rgba(0, 0, 0, 0.05);
            transition: var(--transition);
            border-left: 4px solid var(--primary-color);
        }

        .detail-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }

        .detail-header {
            display: flex;
            align-items: center;
            margin-bottom: 15px;
        }

        .detail-icon {
            width: 40px;
            height: 40px;
            background: var(--primary-light);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 15px;
            color: var(--primary-color);
            font-size: 18px;
        }

        .detail-title {
            font-weight: 600;
            color: var(--primary-color);
            margin: 0;
            font-size: 16px;
        }

        .detail-value {
            font-size: 18px;
            font-weight: 500;
            color: var(--text-color);
            margin: 0;
            padding-left: 55px;
            word-break: break-word;
        }

        .highlighted {
            background: linear-gradient(135deg, var(--primary-light), #e1f0ff);
            padding: 15px 20px;
            border-radius: var(--border-radius);
            font-weight: 600;
            color: var(--primary-dark);
        }

        .section-title {
            position: relative;
            padding-bottom: 10px;
            margin: 30px 0 20px;
            font-size: 20px;
            color: var(--primary-color);
            font-weight: 600;
        }

        .section-title:after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 50px;
            height: 3px;
            background: var(--primary-color);
            border-radius: 3px;
        }

        /* Responsive adjustments */
        @media (max-width: 768px) {
            .main-container {
                margin: 15px;
                width: auto;
            }
            
            .details-grid {
                grid-template-columns: 1fr;
            }
            
            .page-header h1 {
                font-size: 22px;
            }
            
            .detail-value {
                padding-left: 0;
                margin-top: 10px;
            }
            
            .detail-header {
                flex-direction: column;
                align-items: flex-start;
            }
            
            .detail-icon {
                margin-bottom: 10px;
            }
        }

        /* Animation pour l'apparition des éléments */
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .detail-card {
            animation: fadeIn 0.5s ease forwards;
        }

        .detail-card:nth-child(1) { animation-delay: 0.1s; }
        .detail-card:nth-child(2) { animation-delay: 0.2s; }
        .detail-card:nth-child(3) { animation-delay: 0.3s; }
        .detail-card:nth-child(4) { animation-delay: 0.4s; }
        .detail-card:nth-child(5) { animation-delay: 0.5s; }
        .detail-card:nth-child(6) { animation-delay: 0.6s; }
        .detail-card:nth-child(7) { animation-delay: 0.7s; }
        .detail-card:nth-child(8) { animation-delay: 0.8s; }
        .detail-card:nth-child(9) { animation-delay: 0.9s; }
    </style>
</head>
<body>
    <div class="main-container">
        <!-- Notifications -->
        <div class="alert-container">
            @if (Session::get('success1'))
                <script>
                    Swal.fire({
                        icon: 'success',
                        title: 'Suppression réussie',
                        text: '{{ Session::get('success1') }}',
                        showConfirmButton: true,
                        confirmButtonText: 'OK',
                        confirmButtonColor: '#009efb'
                    });
                </script>
            @endif
        
            @if (Session::get('success'))
                <script>
                    Swal.fire({
                        icon: 'success',
                        title: 'Action réussie',
                        text: '{{ Session::get('success') }}',
                        showConfirmButton: true,
                        confirmButtonText: 'OK',
                        confirmButtonColor: '#009efb'
                    });
                </script>
            @endif
        
            @if (Session::get('error'))
                <script>
                    Swal.fire({
                        icon: 'error',
                        title: 'Erreur',
                        text: '{{ Session::get('error') }}',
                        showConfirmButton: true,
                        confirmButtonText: 'OK',
                        confirmButtonColor: '#e74c3c'
                    });
                </script>
            @endif
        </div>

        <!-- En-tête de page -->
        <div class="page-header">
            <h1 class="text-white">Détails de la déclaration du défunt {{ $deceshop->NomM }}</h1>
        </div>

        <div style="text-align: center;">
            <a href="{{ route('statement.index.death') }}" class="back-button">
                <i class="fas fa-arrow-left"></i> Retour à la liste des déclarations
            </a>
        </div>

        <div class="details-container">
            <!-- Informations principales -->
            <h3 class="section-title">Informations principales</h3>
            <div class="details-grid">
                <div class="detail-card">
                    <div class="detail-header">
                        <div class="detail-icon">
                            <i class="fas fa-barcode"></i>
                        </div>
                        <h3 class="detail-title">N° CMD</h3>
                    </div>
                    <p class="detail-value highlighted">{{ $deceshop->codeCMD }}</p>
                </div>

                <div class="detail-card">
                    <div class="detail-header">
                        <div class="detail-icon">
                            <i class="fas fa-user"></i>
                        </div>
                        <h3 class="detail-title">Nom du défunt</h3>
                    </div>
                    <p class="detail-value">{{ $deceshop->NomM }}</p>
                </div>

                <div class="detail-card">
                    <div class="detail-header">
                        <div class="detail-icon">
                            <i class="fas fa-signature"></i>
                        </div>
                        <h3 class="detail-title">Prénoms du défunt</h3>
                    </div>
                    <p class="detail-value">{{ $deceshop->PrM }}</p>
                </div>
            </div>

            <!-- Dates importantes -->
            <h3 class="section-title">Dates importantes</h3>
            <div class="details-grid">
                <div class="detail-card">
                    <div class="detail-header">
                        <div class="detail-icon">
                            <i class="fas fa-birthday-cake"></i>
                        </div>
                        <h3 class="detail-title">Date de Naissance</h3>
                    </div>
                    <p class="detail-value">{{ $deceshop->DateNaissance }}</p>
                </div>

                <div class="detail-card">
                    <div class="detail-header">
                        <div class="detail-icon">
                            <i class="fas fa-cross"></i>
                        </div>
                        <h3 class="detail-title">Date de Décès</h3>
                    </div>
                    <p class="detail-value">{{ $deceshop->DateDeces }}</p>
                </div>
            </div>

            <!-- Circonstances du décès -->
            <h3 class="section-title">Circonstances du décès</h3>
            <div class="details-grid">
                <div class="detail-card">
                    <div class="detail-header">
                        <div class="detail-icon">
                            <i class="fas fa-stethoscope"></i>
                        </div>
                        <h3 class="detail-title">Causes du Décès</h3>
                    </div>
                    <p class="detail-value">{{ $deceshop->Remarques }}</p>
                </div>

                <div class="detail-card">
                    <div class="detail-header">
                        <div class="detail-icon">
                            <i class="fas fa-map-marker-alt"></i>
                        </div>
                        <h3 class="detail-title">Lieu de décès</h3>
                    </div>
                    <p class="detail-value">{{ $deceshop->choix }} l'hôpital</p>
                </div>

                <div class="detail-card">
                    <div class="detail-header">
                        <div class="detail-icon">
                            <i class="fas fa-city"></i>
                        </div>
                        <h3 class="detail-title">Commune de Décès</h3>
                    </div>
                    <p class="detail-value">{{ $deceshop->commune }}</p>
                </div>

                <div class="detail-card">
                    <div class="detail-header">
                        <div class="detail-icon">
                            <i class="fas fa-hospital"></i>
                        </div>
                        <h3 class="detail-title">Hôpital</h3>
                    </div>
                    <p class="detail-value">{{ $deceshop->nomHop }}</p>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Animation pour faire apparaître les éléments progressivement
        document.addEventListener('DOMContentLoaded', function() {
            const detailCards = document.querySelectorAll('.detail-card');
            detailCards.forEach(card => {
                card.style.opacity = '0';
            });
        });

        // Fonction de confirmation de suppression (si nécessaire)
        function confirmDelete(route) {
            Swal.fire({
                title: 'Êtes-vous sûr?',
                text: "Cette action est irréversible!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#009efb',
                cancelButtonColor: '#7f8c8d',
                confirmButtonText: 'Oui, supprimer!',
                cancelButtonText: 'Annuler',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = route;
                }
            });
        }
    </script>
</body>
</html>
@endsection