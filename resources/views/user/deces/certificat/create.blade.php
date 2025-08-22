@extends('user.layouts.template')

@section('content')
    <div class="modern-container">
        <div class="card">
            <!-- Progress Steps -->
            <div class="steps-container">
                <div class="step active" id="step1">
                    <div class="step-number">1</div>
                    <div class="step-title">Vérification CMD</div>
                </div>
                <div class="step" id="step2">
                    <div class="step-number">2</div>
                    <div class="step-title">Informations</div>
                </div>
                <div class="step" id="step3">
                    <div class="step-number">3</div>
                    <div class="step-title">Validation</div>
                </div>
            </div>

            <!-- Step 1: CMD Verification -->
            <div class="step-content active" id="step1-content">
                <h2 class="step-header">Vérification du certificat médical</h2>
                <div class="form-group">
                    <label for="dossierNum">N° Certificat médical de décès</label>
                    <input type="text" id="dossierNum" name="dossierNum" 
                           class="form-control" 
                           placeholder="Ex: CMD1411782251" required>
                    <div id="dossierNumError" class="error-message"></div>
                </div>
                <button type="button" id="btnVerify" class="btn-primary">
                    <i class="fas fa-search"></i> Vérifier le code
                </button>
            </div>

            <!-- Step 2: Information Form -->
            <div class="step-content" id="step2-content">
                <h2 class="step-header">Informations requises</h2>
                <form id="declarationForm" method="POST" action="{{route('user.extrait.deces.certificat.store')}}" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" id="verifiedCmn" name="verifiedCmn">

                    <!-- Hospital Info -->
                    <div class="info-card">
                        <div class="info-content">
                            <label for="nomHopital">Nom de l'hôpital</label>
                            <input type="text" id="nomHopital" name="nomHopital" readonly class="form-control info-field">
                        </div>
                    </div>

                    <!-- Deceased Info -->
                    <div class="info-card">
                        <div class="info-content">
                            <label for="nomDefunt">Nom du défunt</label>
                            <input type="text" id="nomDefunt" name="nomDefunt" readonly class="form-control info-field">
                        </div>
                    </div>

                    <!-- Birth Info -->
                    <div class="info-card">
                        <div class="info-content">
                            <label for="dateNaiss">Date de naissance</label>
                            <input type="text" id="dateNaiss" name="dateNaiss" readonly class="form-control info-field">
                        </div>
                    </div>

                    <!-- Death Info -->
                    <div class="section-title">
                        <i class="fas fa-calendar-times"></i> Informations sur le décès
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label for="dateDces"><i class="far fa-calendar-alt"></i> Date de décès</label>
                            <input type="text" id="dateDces" name="dateDces" readonly class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="lieuNaiss"><i class="fas fa-map-marker-alt"></i> Lieu de décès</label>
                            <input type="text" id="lieuNaiss" name="lieuNaiss" readonly class="form-control">
                        </div>
                    </div>

                    <!-- Documents -->
                    <div class="section-title">
                        <i class="fas fa-file-upload"></i> Documents requis
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label for="identiteDeclarant"><i class="fas fa-id-card"></i> Pièce d'Identité du défunt</label>
                            <input type="file" id="identiteDeclarant" name="identiteDeclarant" class="form-control" accept=".pdf,.jpg,.jpeg,.png,.gif">
                            <div id="identiteDeclarantError" class="error-message"></div>
                        </div>
                        <div class="form-group">
                            <label for="acteMariage"><i class="fas fa-file-medical"></i> Certificat Médical de décès</label>
                            <input type="file" id="acteMariage" name="acteMariage" class="form-control" accept=".pdf,.jpg,.jpeg,.png,.gif">
                            <div id="acteMariageError" class="error-message"></div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="deParLaLoi"><i class="fas fa-file-signature"></i> De par la loi</label>
                        <input type="file" id="deParLaLoi" name="deParLaLoi" class="form-control" accept=".pdf,.jpg,.jpeg,.png,.gif">
                        <div id="deParLaLoiError" class="error-message"></div>
                    </div>

                    <!-- Delivery Options -->
                    <div class="form-group delivery-options">
                        <div class="section-title">
                            <i class="fas fa-truck"></i> Mode de retrait
                        </div>
                        <div class="radio-options">
                            <div class="radio-option">
                                <input type="radio" id="option1" name="choix_option" value="Retrait sur place" checked required>
                                <label for="option1">
                                    <div class="option-content">
                                        <i class="fas fa-clinic-medical"></i>
                                        <span>Retrait sur place</span>
                                    </div>
                                </label>
                            </div>
                            <div class="radio-option">
                                <input type="radio" id="option2" name="choix_option" value="livraison" required>
                                <label for="option2">
                                    <div class="option-content">
                                        <i class="fas fa-home"></i>
                                        <span>Livraison à domicile</span>
                                    </div>
                                </label>
                            </div>
                        </div>
                    </div>

                    <!-- Navigation Buttons -->
                    <div class="form-navigation">
                        <button type="button" class="btn-secondary" id="prevBtn">
                            <i class="fas fa-arrow-left"></i> Précédent
                        </button>
                        <button type="button" class="btn-primary" id="nextBtn">
                            Suivant <i class="fas fa-arrow-right"></i>
                        </button>
                    </div>
                </form>
            </div>

            <!-- Step 3: Confirmation -->
            <div class="step-content" id="step3-content">
                <h2 class="step-header">Confirmation</h2>
                <div class="confirmation-message">
                    <div class="confirmation-icon">
                        <i class="fas fa-check-circle"></i>
                    </div>
                    <h3>Vérification finale</h3>
                    <p>Veuillez vérifier toutes les informations avant de soumettre votre demande.</p>
                </div>
                <div class="confirmation-details" id="confirmationDetails">
                    <!-- Dynamically filled -->
                </div>
                <div class="form-navigation">
                    <button type="button" class="btn-secondary" id="backToFormBtn">
                        <i class="fas fa-edit"></i> Modifier
                    </button>
                    <button type="button" class="btn-confirm" id="confirmBtn">
                        <i class="fas fa-paper-plane"></i> Confirmer
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Styles -->
    <style>
        :root {
            --primary-color: #1977cc;
            --primary-dark: #1977cc;
            --secondary-color: #6c757d;
            --light-color: #f8f9fa;
            --medium-gray: #e9ecef;
            --dark-gray: #343a40;
            --error-color: #ef233c;
            --success-color: #4cc9f0;
            --warning-color: #f8961e;
            --border-radius: 10px;
            --box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            --transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
        }

        .modern-container {
            max-width: 1500px;
            margin: 2rem auto;
            padding: 0 1rem;
        }

        .card {
            background: white;
            border-radius: var(--border-radius);
            box-shadow: var(--box-shadow);
            overflow: hidden;
            padding: 2rem;
        }

        /* Steps Container */
        .steps-container {
            display: flex;
            justify-content: space-between;
            margin: 2rem 0 3rem;
            position: relative;
        }

        .steps-container::before {
            content: '';
            position: absolute;
            top: 20px;
            left: 0;
            right: 0;
            height: 3px;
            background: var(--medium-gray);
        }

        .step {
            display: flex;
            flex-direction: column;
            align-items: center;
            position: relative;
            z-index: 2;
            flex: 1;
        }

        .step-number {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: var(--medium-gray);
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 0.5rem;
            font-weight: bold;
            transition: var(--transition);
            border: 3px solid white;
        }

        .step.active .step-number {
            background: var(--primary-color);
            color: white;
            transform: scale(1.1);
        }

        .step.completed .step-number {
            background: var(--success-color);
            color: white;
        }

        .step-title {
            color: var(--secondary-color);
            font-size: 0.9rem;
            text-align: center;
            font-weight: 500;
            transition: var(--transition);
        }

        /* Style pour la popup de livraison */
    .swal-delivery-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 1rem;
    }

    @media (max-width: 600px) {
        .swal-delivery-grid {
            grid-template-columns: 1fr;
        }
    }

        .step.active .step-title {
            color: var(--primary-color);
            font-weight: 600;
        }

        /* Step Content */
        .step-content {
            display: none;
            animation: fadeIn 0.5s ease-out;
        }

        .step-content.active {
            display: block;
        }

        .step-header {
            color: var(--primary-color);
            text-align: center;
            margin-bottom: 2rem;
            font-size: 1.75rem;
            font-weight: 600;
            position: relative;
            padding-bottom: 1rem;
        }

        .step-header::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 50%;
            transform: translateX(-50%);
            width: 80px;
            height: 3px;
            background: var(--primary-color);
            border-radius: 3px;
        }

        /* Form Styles */
        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-control {
            width: 100%;
            padding: 0.75rem 1rem;
            border: 1px solid var(--medium-gray);
            border-radius: var(--border-radius);
            transition: var(--transition);
            font-size: 1rem;
        }

        .form-control:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(67, 97, 238, 0.2);
        }

        .form-control[readonly] {
            background-color: #f5f5f5;
            color: #555;
        }

        .info-card {
            display: flex;
            align-items: center;
            background: #f8f9fa;
            border-radius: var(--border-radius);
            padding: 1rem;
            margin-bottom: 1.5rem;
        }

        .info-content {
            flex: 1;
            text-align: center;
        }

        .info-content label {
            font-weight: 500;
            color: var(--dark-gray);
            margin-bottom: 0.25rem;
            text-align: center;
        }

        .info-field {
            background: transparent;
            border: none;
            font-weight: 500;
            text-align: center;
            color: var(--dark-gray);
            padding: 0.5rem 0;
        }

        /* Section Titles */
        .section-title {
            color: var(--primary-color);
            font-size: 1.25rem;
            margin: 2rem 0 1.5rem;
            padding-bottom: 0.5rem;
            border-bottom: 2px solid var(--medium-gray);
            display: flex;
            align-items: center;
        }

        .section-title i {
            margin-right: 0.75rem;
            font-size: 1.1em;
        }

        /* Form Rows */
        .form-row {
            display: flex;
            flex-wrap: wrap;
            gap: 1.5rem;
            margin-bottom: 1.5rem;
        }

        .form-row .form-group {
            flex: 1;
            min-width: 200px;
        }

        /* Delivery Options */
        .delivery-options {
            margin: 2rem 0;
        }

        .radio-options {
            display: flex;
            gap: 1rem;
            margin-top: 1rem;
        }

        .radio-option {
            flex: 1;
        }

        .radio-option input[type="radio"] {
            display: none;
        }

        .radio-option label {
            display: block;
            border: 2px solid var(--medium-gray);
            border-radius: var(--border-radius);
            padding: 1.5rem;
            text-align: center;
            cursor: pointer;
            transition: var(--transition);
        }

        .radio-option input[type="radio"]:checked + label {
            border-color: var(--primary-color);
            background-color: rgba(67, 97, 238, 0.05);
        }

        .option-content {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 0.75rem;
        }

        .option-content i {
            font-size: 1.75rem;
            color: var(--primary-color);
        }

        .option-content span {
            font-weight: 500;
            color: var(--dark-gray);
        }

        /* Buttons */
        .btn-primary {
            background: var(--primary-color);
            color: white;
            border: none;
            padding: 0.875rem 1.5rem;
            border-radius: var(--border-radius);
            font-weight: 500;
            cursor: pointer;
            transition: var(--transition);
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
        }

        .btn-primary:hover {
            background: var(--primary-dark);
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(67, 97, 238, 0.2);
        }

        .btn-secondary {
            background: white;
            color: var(--secondary-color);
            border: 1px solid var(--medium-gray);
            padding: 0.875rem 1.5rem;
            border-radius: var(--border-radius);
            font-weight: 500;
            cursor: pointer;
            transition: var(--transition);
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
        }

        .btn-secondary:hover {
            background: #f8f9fa;
            border-color: var(--secondary-color);
        }

        .btn-confirm {
            background: var(--success-color);
            color: white;
            border: none;
            padding: 0.875rem 1.5rem;
            border-radius: var(--border-radius);
            font-weight: 500;
            cursor: pointer;
            transition: var(--transition);
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
        }

        .btn-confirm:hover {
            background: #3ab7d8;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(76, 201, 240, 0.2);
        }

        .form-navigation {
            display: flex;
            gap: 1rem;
            margin-top: 2.5rem;
        }

        /* Confirmation */
        .confirmation-message {
            text-align: center;
            margin-bottom: 2.5rem;
        }

        .confirmation-icon {
            font-size: 4rem;
            color: var(--success-color);
            margin-bottom: 1.5rem;
        }

        .confirmation-message h3 {
            color: var(--primary-color);
            margin-bottom: 0.5rem;
            font-size: 1.5rem;
        }

        .confirmation-message p {
            color: var(--secondary-color);
            font-size: 1.1rem;
        }

        .confirmation-details {
            background: var(--light-color);
            border-radius: var(--border-radius);
            padding: 2rem;
            margin-bottom: 2rem;
        }

        .detail-row {
            margin-bottom: 1rem;
            padding-bottom: 1rem;
            border-bottom: 1px dashed var(--medium-gray);
            display: flex;
        }

        .detail-row:last-child {
            margin-bottom: 0;
            padding-bottom: 0;
            border-bottom: none;
        }

        .detail-row strong {
            min-width: 150px;
            color: var(--dark-gray);
        }

        .detail-row i {
            margin-right: 0.5rem;
            width: 20px;
            text-align: center;
        }

        /* Error Handling */
        .error-message {
            color: var(--error-color);
            font-size: 0.85rem;
            margin-top: 0.5rem;
            display: none;
        }

        /* Animations */
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        /* Responsive */
        @media (max-width: 768px) {
            .modern-container {
                padding: 0;
            }
            
            .card {
                border-radius: 0;
                box-shadow: none;
                padding: 1.5rem;
            }
            
            .steps-container {
                margin: 1rem 0 2rem;
            }
            
            .step-title {
                font-size: 0.8rem;
            }
            
            .form-row {
                flex-direction: column;
                gap: 1rem;
            }
            
            .radio-options {
                flex-direction: column;
            }
            
            .form-navigation {
                flex-direction: column;
            }
            
            .step-header {
                font-size: 1.5rem;
            }
        }
    </style>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="{{ asset('js/cinetpay_deces.js') }}"></script>
    <script src="https://cdn.cinetpay.com/seamless/main.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <script>
        $(document).ready(function() {
            let currentStep = 1;
            let formSubmitted = false;
            let submitAfterPopup = false;

            // Initialize steps
            updateSteps();

            // Verify CMD button
            $('#btnVerify').click(verifyCMD);

            // Next button (step 2 to step 3)
            $('#nextBtn').click(function() {
                if (validateStep2()) {
                    currentStep = 3;
                    updateSteps();
                    showConfirmationDetails();
                }
            });

            // Previous button (step 2 to step 1)
            $('#prevBtn').click(function() {
                currentStep = 1;
                updateSteps();
            });

            // Back button (step 3 to step 2)
            $('#backToFormBtn').click(function() {
                currentStep = 2;
                updateSteps();
            });

            // Confirm button (submit form)
            $('#confirmBtn').click(function() {
                if ($('input[name="choix_option"]:checked').val() === 'livraison') {
                    showLivraisonPopup();
                } else {
                    submitForm();
                }
            });

            // Update step visualization
            function updateSteps() {
                // Update step indicators
                $('.step').removeClass('active completed');
                for (let i = 1; i <= currentStep; i++) {
                    $('#step' + i).addClass(i === currentStep ? 'active' : 'completed');
                }

                // Update step content
                $('.step-content').removeClass('active');
                $('#step' + currentStep + '-content').addClass('active');

                // Update buttons visibility
                if (currentStep === 1) {
                    $('#prevBtn').hide();
                    $('#nextBtn').hide();
                } else if (currentStep === 2) {
                    $('#prevBtn').show();
                    $('#nextBtn').show();
                } else if (currentStep === 3) {
                    $('#prevBtn').hide();
                    $('#nextBtn').hide();
                }
            }

            // Verify CMD function
            async function verifyCMD() {
                const dossierNum = $("#dossierNum").val().trim();
                
                if (!dossierNum) {
                    showError('dossierNumError', 'Veuillez entrer un numéro de certificat');
                    return;
                }

                try {
                    const swalInstance = Swal.fire({
                        title: 'Vérification en cours',
                        html: 'Veuillez patienter...',
                        allowOutsideClick: false,
                        didOpen: () => Swal.showLoading()
                    });

                    const response = await fetch("{{ route('code.verifie.cmd') }}", {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': "{{ csrf_token() }}",
                            'Accept': 'application/json'
                        },
                        body: JSON.stringify({ codeCMN: dossierNum }),
                        signal: AbortSignal.timeout(15000) // Timeout après 15 secondes
                    });

                    swalInstance.close();
                    
                    if (!response.ok) {
                        const errorData = await response.json();
                        throw new Error(errorData.message || 'Erreur serveur');
                    }

                    const data = await response.json();
                    
                    if (data.existe) {
                        // Remplir les champs avec la réponse
                        $("#nomHopital").val(data.nomHopital);
                        $("#nomDefunt").val(data.nomDefunt);
                        $("#dateNaiss").val(data.dateNaiss);
                        $("#dateDces").val(data.dateDeces);
                        $("#lieuNaiss").val(data.lieuNaiss);
                        $("#verifiedCmn").val(dossierNum);
                        
                        // Passer à l'étape suivante
                        currentStep = 2;
                        updateSteps();
                    } else {
                        throw new Error(data.message || 'Code CMD invalide');
                    }
                } catch (error) {
                    // Gestion spécifique des erreurs de timeout
                    if (error.name === 'TimeoutError') {
                        Swal.fire('Erreur', 'La vérification a pris trop de temps', 'error');
                    } else if (error.name === 'AbortError') {
                        Swal.fire('Erreur', 'Requête annulée', 'error');
                    } else {
                        Swal.fire('Erreur', error.message || 'Erreur lors de la vérification', 'error');
                    }
                    console.error("Erreur vérification CMD:", error);
                }
            }

            // Validate step 2 (information form)
            function validateStep2() {
                let isValid = true;

                // Validate required files
                const requiredFiles = ['identiteDeclarant', 'acteMariage'];
                requiredFiles.forEach(field => {
                    if (!$('#' + field)[0].files.length) {
                        $('#' + field + 'Error').text('Ce fichier est obligatoire').show();
                        isValid = false;
                    } else {
                        $('#' + field + 'Error').hide();
                    }
                });

                return isValid;
            }

            // Show confirmation details
            function showConfirmationDetails() {
                const details = `
                    <h4 class="confirmation-title"><i class="fas fa-file-alt"></i> Récapitulatif de la demande</h4>
                    <div class="detail-row">
                        <strong><i class="fas fa-hospital"></i> Hôpital:</strong>
                        <span>${$('#nomHopital').val() || 'Non spécifié'}</span>
                    </div>
                    <div class="detail-row">
                        <strong><i class="fas fa-user"></i> Défunt:</strong>
                        <span>${$('#nomDefunt').val() || 'Non spécifié'}</span>
                    </div>
                    <div class="detail-row">
                        <strong><i class="fas fa-birthday-cake"></i> Né le:</strong>
                        <span>${$('#dateNaiss').val() || 'Non spécifié'} à ${$('#lieuNaiss').val() || 'Non spécifié'}</span>
                    </div>
                    <div class="detail-row">
                        <strong><i class="fas fa-calendar-times"></i> Décédé le:</strong>
                        <span>${$('#dateDces').val() || 'Non spécifié'}</span>
                    </div>
                    <div class="detail-row">
                        <strong><i class="fas fa-truck"></i> Mode de retrait:</strong>
                        <span>${$('input[name="choix_option"]:checked').val() === 'livraison' ? 'Livraison à domicile' : 'Retrait sur place'}</span>
                    </div>
                `;
                $('#confirmationDetails').html(details);
            }

            // Show delivery popup
            function showLivraisonPopup() {
               Swal.fire({
            title: 'Informations de Livraison',
            width: '700px',
            html: `
                <div class="swal-delivery-grid">
                    <div>
                        <label for="swal-montant_timbre" style="font-weight: bold">Timbre</label>
                        <input id="swal-montant_timbre" class="swal2-input text-center" value="50" readonly>
                        <small style="color:#666">Frais couverts par Kks-technologies</small>
                    </div>
                    <div>
                        <label for="swal-montant_livraison" style="font-weight: bold">Frais Livraison</label>
                        <input id="swal-montant_livraison" class="swal2-input text-center" value="50" readonly>
                        <small style="color:#666">Frais fixes pour la livraison</small>
                    </div>
                    <div>
                        <label for="swal-nom_destinataire" style="font-weight: bold">Nom</label>
                        <input id="swal-nom_destinataire" class="swal2-input" placeholder="Nom du destinataire">
                    </div>
                    <div>
                        <label for="swal-prenom_destinataire" style="font-weight: bold">Prénom</label>
                        <input id="swal-prenom_destinataire" class="swal2-input" placeholder="Prénom du destinataire">
                    </div>
                    <div>
                        <label for="swal-email_destinataire" style="font-weight: bold">Email</label>
                        <input id="swal-email_destinataire" class="swal2-input" placeholder="Email du destinataire" type="email">
                    </div>
                    <div>
                        <label for="swal-contact_destinataire" style="font-weight: bold">Téléphone</label>
                        <input id="swal-contact_destinataire" class="swal2-input" placeholder="Contact du destinataire" type="tel">
                    </div>
                    <div>
                        <label for="swal-adresse_livraison" style="font-weight: bold">Adresse</label>
                        <input id="swal-adresse_livraison" class="swal2-input" placeholder="Adresse complète">
                    </div>
                    <div>
                        <label for="swal-ville" style="font-weight: bold">Ville</label>
                        <input id="swal-ville" class="swal2-input" placeholder="Ville de livraison">
                    </div>
                    <div>
                        <label for="swal-commune_livraison" style="font-weight: bold">Commune</label>
                        <input id="swal-commune_livraison" class="swal2-input" placeholder="Commune">
                    </div>
                    <div>
                        <label for="swal-quartier" style="font-weight: bold">Quartier</label>
                        <input id="swal-quartier" class="swal2-input" placeholder="Quartier">
                    </div>
                </div>`,
            icon: 'info',
            showCancelButton: true,
            confirmButtonText: 'Payer maintenant',
            cancelButtonText: 'Annuler',
            confirmButtonColor: '#1977cc',
            focusConfirm: false,
            preConfirm: () => {
                const nom_destinataire = document.getElementById('swal-nom_destinataire').value;
                const prenom_destinataire = document.getElementById('swal-prenom_destinataire').value;
                const email_destinataire = document.getElementById('swal-email_destinataire').value;
                const contact_destinataire = document.getElementById('swal-contact_destinataire').value;
                const adresse_livraison = document.getElementById('swal-adresse_livraison').value;
                const ville = document.getElementById('swal-ville').value;
                const commune_livraison = document.getElementById('swal-commune_livraison').value;
                const quartier = document.getElementById('swal-quartier').value;
                const montant_timbre = document.getElementById('swal-montant_timbre').value;
                const montant_livraison = document.getElementById('swal-montant_livraison').value;

                if (!nom_destinataire || !prenom_destinataire || !email_destinataire || !contact_destinataire || !adresse_livraison || !ville || !commune_livraison || !quartier || !montant_timbre || !montant_livraison) {
                    Swal.showValidationMessage("Veuillez remplir tous les champs obligatoires");
                    return false;
                }
                return {
                    nom_destinataire: nom_destinataire,
                    prenom_destinataire: prenom_destinataire,
                    email_destinataire: email_destinataire,
                    contact_destinataire: contact_destinataire,
                    adresse_livraison: adresse_livraison,
                    ville: ville,
                    commune_livraison: commune_livraison,
                    quartier: quartier,
                    montant_timbre: parseFloat(montant_timbre),
                    montant_livraison: parseFloat(montant_livraison),
                };
            }
        }).then((result) => {
            if (result.isConfirmed) {
                const formData = result.value;
                initializeCinetPay(formData); // Appel de la fonction CinetPay
            } else if (result.dismiss === Swal.DismissReason.cancel) {
                // Si l'utilisateur clique sur annuler, sélectionner l'option 1
                document.getElementById('option1').checked = true;
            }
        });
    }

    function initializeCinetPay(formData) {
    // Configuration CinetPay
    CinetPay.setConfig({
        apikey: '{{ config("services.cinetpay.api_key") }}',
        site_id: '{{ config("services.cinetpay.site_id") }}',
        mode: 'PRODUCTION'
    });

    // ID de transaction
    const transactionId = 'EXT-' + Date.now();
    
    // Montant total
    const totalAmount = formData.montant_timbre + formData.montant_livraison;

    // Chargement
    Swal.fire({
        title: 'Redirection en cours',
        html: 'Préparation du paiement...',
        allowOutsideClick: true,
        didOpen: () => Swal.showLoading()
    });

    // Données client
    const customer = {
        name: '{{ Auth::user()->name ?? "Client" }}',
        email: '{{ Auth::user()->email ?? "contact@client.com" }}',
        phone: '{{ Auth::user()->telephone ?? "00000000" }}'
    };

    // Paiement
    CinetPay.getCheckout({
        transaction_id: transactionId,
        amount: totalAmount,
        currency: 'XOF',
        channels: 'ALL',
        description: `Paiement pour livraison d'extrait de naissance`,
        customer_name: customer.name,
        customer_email: customer.email,
        customer_phone_number: customer.phone,
        customer_address: formData.adresse_livraison,
        customer_city: formData.ville,
        customer_country: 'CI',
        customer_state: 'CI',
        customer_zip_code: '00225'
    });

    // Gestion réponse
    CinetPay.waitResponse(function(data) {
        Swal.close();
        if (data.status === "ACCEPTED") {
            // Ajouter les données de livraison au formulaire
            const form = document.getElementById('declarationForm');
            
            // Créer des champs cachés pour les données de livraison
            const hiddenFields = [
                { name: 'nom_destinataire', value: formData.nom_destinataire },
                { name: 'prenom_destinataire', value: formData.prenom_destinataire },
                { name: 'email_destinataire', value: formData.email_destinataire },
                { name: 'contact_destinataire', value: formData.contact_destinataire },
                { name: 'adresse_livraison', value: formData.adresse_livraison },
                { name: 'ville', value: formData.ville },
                { name: 'commune_livraison', value: formData.commune_livraison },
                { name: 'quartier', value: formData.quartier },
                { name: 'montant_timbre', value: formData.montant_timbre },
                { name: 'montant_livraison', value: formData.montant_livraison },
                { name: 'transaction_id', value: transactionId }
            ];

            hiddenFields.forEach(field => {
                const input = document.createElement('input');
                input.type = 'hidden';
                input.name = field.name;
                input.value = field.value;
                form.appendChild(input);
            });

            // Soumettre le formulaire
            formSubmitted = true;
            form.submit();
        } else {
            Swal.fire({
                icon: 'error',
                title: 'Échec du paiement',
                text: data.message || 'Erreur lors du traitement'
            });
        }
    });

    // Gestion erreurs
    CinetPay.onError(function(error) {
        Swal.close();
        Swal.fire({
            icon: 'error',
            title: 'Erreur',
            html: `Une erreur est survenue<br><small>${error.message || 'Veuillez réessayer'}</small>`
        });
    });
}

            // Submit form
            function submitForm() {
                if (formSubmitted) return;
                
                formSubmitted = true;
                $('#declarationForm').submit();
            }

            // Show error message
            function showError(elementId, message) {
                $('#' + elementId).text(message).show();
            }
        });
    </script>
@endsection