@extends('doctor.layouts.template')

@section('content')
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Détails de la déclaration - {{ $naisshop->NomM }}</title>
    
    <!-- Insertion de SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    
    <!-- Lightbox pour l'affichage des images -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.4/css/lightbox.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.4/js/lightbox.min.js"></script>
    
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
            max-width: 1200px;
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

        /* Styles pour les documents */
        .document-preview {
            margin-top: 10px;
            cursor: pointer;
            transition: var(--transition);
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
            max-width: 150px;
        }

        .document-preview:hover {
            transform: scale(1.05);
            box-shadow: 0 8px 15px rgba(0,0,0,0.15);
        }

        /* Styles pour la liste des enfants */
        .children-section {
            background: var(--primary-light);
            padding: 25px;
            border-radius: var(--border-radius);
            margin-top: 30px;
        }

        .children-list {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .child-item {
            background: var(--white);
            border-radius: var(--border-radius);
            padding: 20px;
            margin-bottom: 15px;
            display: flex;
            box-shadow: 0 3px 8px rgba(0,0,0,0.08);
            transition: var(--transition);
        }

        .child-item:hover {
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }

        .child-number {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 35px;
            height: 35px;
            background: var(--primary-color);
            color: var(--white);
            border-radius: 50%;
            font-weight: 600;
            margin-right: 15px;
            flex-shrink: 0;
        }

        .child-info {
            flex: 1;
        }

        .child-info strong {
            color: var(--primary-color);
            font-size: 16px;
        }

        .child-details {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
            gap: 10px;
            margin-top: 10px;
        }

        .child-detail {
            font-size: 14px;
        }

        .child-detail span {
            font-weight: 600;
            color: var(--primary-dark);
        }

        /* Modal pour l'image agrandie */
        .image-modal {
            display: none;
            position: fixed;
            z-index: 1000;
            padding-top: 50px;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.9);
            overflow: auto;
        }

        .modal-content {
            display: block;
            margin: 0 auto;
            max-width: 90%;
            max-height: 80vh;
            border-radius: 8px;
        }

        .close-modal {
            position: absolute;
            top: 15px;
            right: 35px;
            color: #f1f1f1;
            font-size: 40px;
            font-weight: bold;
            cursor: pointer;
            transition: 0.3s;
        }

        .close-modal:hover {
            color: #bbb;
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
            
            .child-item {
                flex-direction: column;
            }
            
            .child-number {
                margin-bottom: 10px;
            }
            
            .child-details {
                grid-template-columns: 1fr;
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
        .detail-card:nth-child(10) { animation-delay: 1.0s; }
        .detail-card:nth-child(11) { animation-delay: 1.1s; }
        .detail-card:nth-child(12) { animation-delay: 1.2s; }
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
            <h1 class="text-white">Détails de la déclaration de naissance</h1>
        </div>

        <div style="text-align: center;">
            <a href="{{ route('statement.index') }}" class="back-button">
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
                        <h3 class="detail-title">Numéro du Certificat Médical</h3>
                    </div>
                    <p class="detail-value highlighted">{{ $naisshop->codeCMN }}</p>
                </div>

                <div class="detail-card">
                    <div class="detail-header">
                        <div class="detail-icon">
                            <i class="fas fa-user"></i>
                        </div>
                        <h3 class="detail-title">Nom de la Mère</h3>
                    </div>
                    <p class="detail-value">{{ $naisshop->NomM }}</p>
                </div>

                <div class="detail-card">
                    <div class="detail-header">
                        <div class="detail-icon">
                            <i class="fas fa-signature"></i>
                        </div>
                        <h3 class="detail-title">Prénom de la Mère</h3>
                    </div>
                    <p class="detail-value">{{ $naisshop->PrM }}</p>
                </div>

                <div class="detail-card">
                    <div class="detail-header">
                        <div class="detail-icon">
                            <i class="fas fa-phone"></i>
                        </div>
                        <h3 class="detail-title">Contact de la Mère</h3>
                    </div>
                    <p class="detail-value">{{ $naisshop->contM }}</p>
                </div>

                <div class="detail-card">
                    <div class="detail-header">
                        <div class="detail-icon">
                            <i class="fas fa-id-card"></i>
                        </div>
                        <h3 class="detail-title">Identité de la Mère (CNI)</h3>
                    </div>
                    <div class="detail-value">
                        @if (pathinfo($naisshop->CNI_mere, PATHINFO_EXTENSION) === 'pdf')
                            <a href="{{ asset('storage/' . $naisshop->CNI_mere) }}" target="_blank" class="document-preview">
                                <img src="{{ asset('assets/assets/img/pdf.jpg') }}" alt="PDF" width="100%" style="border-radius: 8px;">
                                <div style="text-align: center; padding: 5px; font-size: 12px;">Voir le PDF</div>
                            </a>
                        @else
                            <img src="{{ asset('storage/' . $naisshop->CNI_mere) }}" 
                                 alt="Pièce du parent" 
                                 width="150" 
                                 class="document-preview"
                                 onclick="showImageModal(this.src)" 
                                 onerror="this.onerror=null; this.src='{{ asset('assets/images/profiles/bébé.jpg') }}'">
                        @endif
                    </div>
                </div>
            </div>

            <!-- Informations de l'accompagnateur -->
            <h3 class="section-title">Informations de l'accompagnateur</h3>
            <div class="details-grid">
                <div class="detail-card">
                    <div class="detail-header">
                        <div class="detail-icon">
                            <i class="fas fa-user"></i>
                        </div>
                        <h3 class="detail-title">Nom de l'accompagnateur</h3>
                    </div>
                    <p class="detail-value">{{ $naisshop->NomP }}</p>
                </div>

                <div class="detail-card">
                    <div class="detail-header">
                        <div class="detail-icon">
                            <i class="fas fa-signature"></i>
                        </div>
                        <h3 class="detail-title">Prénom de l'accompagnateur</h3>
                    </div>
                    <p class="detail-value">{{ $naisshop->PrP }}</p>
                </div>

                <div class="detail-card">
                    <div class="detail-header">
                        <div class="detail-icon">
                            <i class="fas fa-phone"></i>
                        </div>
                        <h3 class="detail-title">Contact de l'accompagnateur</h3>
                    </div>
                    <p class="detail-value">{{ $naisshop->contP }}</p>
                </div>

                <div class="detail-card">
                    <div class="detail-header">
                        <div class="detail-icon">
                            <i class="fas fa-id-card"></i>
                        </div>
                        <h3 class="detail-title">Identité de l'accompagnateur</h3>
                    </div>
                    <div class="detail-value">
                        @if (pathinfo($naisshop->CNI_Pere, PATHINFO_EXTENSION) === 'pdf')
                            <a href="{{ asset('storage/' . $naisshop->CNI_Pere) }}" target="_blank" class="document-preview">
                                <img src="{{ asset('assets/assets/img/pdf.jpg') }}" alt="PDF" width="100%" style="border-radius: 8px;">
                                <div style="text-align: center; padding: 5px; font-size: 12px;">Voir le PDF</div>
                            </a>
                        @else
                            <img src="{{ asset('storage/' . $naisshop->CNI_Pere) }}" 
                                 alt="Pièce du parent" 
                                 width="150" 
                                 class="document-preview"
                                 onclick="showImageModal(this.src)" 
                                 onerror="this.onerror=null; this.src='{{ asset('assets/images/profiles/bébé.jpg') }}'">
                        @endif
                    </div>
                </div>
            </div>

            <!-- Informations de naissance -->
            <h3 class="section-title">Informations de naissance</h3>
            <div class="details-grid">
                <div class="detail-card">
                    <div class="detail-header">
                        <div class="detail-icon">
                            <i class="fas fa-hospital"></i>
                        </div>
                        <h3 class="detail-title">Hôpital de Naissance</h3>
                    </div>
                    <p class="detail-value">{{ $naisshop->NomEnf }}</p>
                </div>

                <div class="detail-card">
                    <div class="detail-header">
                        <div class="detail-icon">
                            <i class="fas fa-map-marker-alt"></i>
                        </div>
                        <h3 class="detail-title">Commune de Naissance</h3>
                    </div>
                    <p class="detail-value">{{ $naisshop->commune }}</p>
                </div>

                <div class="detail-card">
                    <div class="detail-header">
                        <div class="detail-icon">
                            <i class="fas fa-baby"></i>
                        </div>
                        <h3 class="detail-title">Nombre d'enfant(s)</h3>
                    </div>
                    <p class="detail-value">
                        @if ($naisshop->enfants->isNotEmpty())
                            {{ $naisshop->enfants->first()->nombreEnf }}
                        @else
                            Aucun enfant enregistré
                        @endif
                    </p>
                </div>
            </div>

            <!-- Section enfants -->
            <div class="children-section">
                <h3 class="section-title">Détails des enfants</h3>
                
                @if ($naisshop->enfants->isNotEmpty())
                    <ul class="children-list">
                        @foreach ($naisshop->enfants as $enfant)
                            <li class="child-item">
                                <div class="child-number">{{ $loop->iteration }}</div>
                                <div class="child-info">
                                    <strong>Enfant {{ $loop->iteration }}</strong>
                                    <div class="child-details">
                                        <div class="child-detail">
                                            <span>Date de naissance:</span> {{ \Carbon\Carbon::parse($enfant->date_naissance)->format('d/m/Y') }}
                                        </div>
                                        <div class="child-detail">
                                            <span>Sexe:</span> {{ $enfant->sexe }}
                                        </div>
                                    </div>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                @else
                    <p style="text-align: center; color: var(--text-color);">Aucun enfant enregistré</p>
                @endif
            </div>
        </div>
    </div>

    <!-- Modal pour l'affichage de l'image en grand -->
    <div id="imageModal" class="image-modal">
        <span class="close-modal" onclick="closeImageModal()">&times;</span>
        <img class="modal-content" id="modalImage">
    </div>

    <script>
        // Fonction pour afficher l'image en modal
        function showImageModal(src) {
            document.getElementById('modalImage').src = src;
            document.getElementById('imageModal').style.display = 'block';
        }

        // Fonction pour fermer le modal
        function closeImageModal() {
            document.getElementById('imageModal').style.display = 'none';
        }

        // Fermer le modal en cliquant en dehors de l'image
        window.onclick = function(event) {
            const modal = document.getElementById('imageModal');
            if (event.target === modal) {
                closeImageModal();
            }
        };

        // Fermer le modal avec la touche Échap
        document.addEventListener('keydown', function(event) {
            if (event.key === 'Escape') {
                closeImageModal();
            }
        });

        // Animation pour faire apparaître les éléments progressivement
        document.addEventListener('DOMContentLoaded', function() {
            const detailCards = document.querySelectorAll('.detail-card');
            detailCards.forEach(card => {
                card.style.opacity = '0';
            });
        });
    </script>
</body>
</html>
@endsection