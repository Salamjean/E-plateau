@extends('user.layouts.template')

@section('content')
    <div class="modern-container">
        <div class="card">
            <!-- Progress Steps -->
            <div class="steps-container">
                <div class="step active" id="step1">
                    <div class="step-number">1</div>
                    <div class="step-title">Vérification CMN</div>
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

            <!-- Step 1: CMN Verification -->
            <div class="step-content active" id="step1-content">
                <h2 class="step-header">Vérification du certificat médical</h2>
                <div class="form-group">
                    <label for="dossierNum">N° Certificat médical de naissance</label>
                    <input type="text" id="dossierNum" name="dossierNum" 
                           class="form-control" 
                           placeholder="Ex: CMN1411782251" required>
                    <div id="dossierNumError" class="error-message"></div>
                </div>
                <button type="button" id="btnVerify" class="btn-primary">
                    <i class="fas fa-search"></i> Vérifier le code
                </button>
            </div>

            <!-- Step 2: Information Form (hidden initially) -->
            <div class="step-content" id="step2-content">
                <h2 class="step-header">Informations requises</h2>
                <form id="naissanceForm" method="POST" action="#" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" id="verifiedCmn" name="verifiedCmn">

                    <!-- Hospital Info -->
                    <div class="info-card">
                        <div class="info-content">
                            <label for="nomHopital">Nom de l'Hôpital</label>
                            <input type="text" id="nomHopital" name="nomHopital" readonly class="form-control info-field">
                        </div>
                    </div>

                    <!-- Mother's Info -->
                    <div class="info-card">
                        <div class="info-content">
                            <label for="nomDefunt">Nom et Prénom de la Mère</label>
                            <input type="text" id="nomDefunt" name="nomDefunt" readonly class="form-control info-field">
                        </div>
                    </div>

                    <!-- Accompagnateur Info -->
                    <div class="info-card">
                        <div class="info-content">
                            <label for="dateNaiss">Nom et Prénom de l'accompagnateur</label>
                            <input type="text" id="dateNaiss" name="dateNaiss" readonly class="form-control info-field">
                        </div>
                    </div>

                    <!-- Child's Info -->
                    <div class="section-title text-center" >
                        <i class="fas fa-baby"></i> Informations concernant l'enfant
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label for="lieuNaiss"><i class="far fa-calendar-alt"></i> Date de Naissance</label>
                            <input type="date" id="lieuNaiss" name="lieuNaiss" required class="form-control">
                            <div id="lieuNaissError" class="error-message"></div>
                        </div>
                        <div class="form-group">
                            <label for="nom"><i class="fas fa-signature"></i> Nom du nouveau né</label>
                            <input type="text" id="nom" name="nom" class="form-control" placeholder="Entrez le nom">
                        </div>
                        <div class="form-group">
                            <label for="prenom"><i class="fas fa-signature"></i> Prénoms du nouveau né</label>
                            <input type="text" id="prenom" name="prenom" class="form-control" placeholder="Entrez les prénoms">
                        </div>
                    </div>

                    <!-- Father's Info -->
                    <div class="section-title">
                        <i class="fas fa-male"></i> Informations concernant le père
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label for="nompere"><i class="fas fa-signature"></i> Nom du père</label>
                            <input type="text" id="nompere" name="nompere" class="form-control" placeholder="Entrez le nom">
                        </div>
                        <div class="form-group">
                            <label for="prenompere"><i class="fas fa-signature"></i> Prénoms du père</label>
                            <input type="text" id="prenompere" name="prenompere" class="form-control" placeholder="Entrez les prénoms">
                        </div>
                        <div class="form-group">
                            <label for="datepere"><i class="far fa-calendar-alt"></i> Date de naissance</label>
                            <input type="date" id="datepere" name="datepere" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="identiteDeclarant"><i class="fas fa-card"></i> Pièce d'Identité</label>
                            <input type="file" id="identiteDeclarant" name="identiteDeclarant" class="form-control" accept=".pdf, .jpg, .jpeg, .png, .gif">
                        </div>
                    </div>

                    <!-- Birth Certificate -->
                    <div class="section-title">
                        <i class="fas fa-id-card"></i> Certificat médical de naissance
                    </div>
                    <div class="form-group">
                        <label for="cdnaiss"><i class="fas fa-file-certificate"></i> Certificat de Naissance</label>
                        <input type="file" id="cdnaiss" name="cdnaiss" class="form-control" accept=".pdf, .jpg, .jpeg, .png, .gif">
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
                        <button type="submit" class="btn-primary" id="submitBtn" style="display:none;">
                            <i class="fas fa-check"></i> Valider
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

        .info-icon {
            font-size: 1.5rem;
            color: var(--primary-color);
            margin-right: 1rem;
            width: 40px;
            text-align: center;
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
    <script src="{{ asset('js/cinetpayN.js') }}"></script>
    <script src="https://cdn.cinetpay.com/seamless/main.js"></script>
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <script>
        $(document).ready(function() {
            let currentStep = 1;
            let expectedDateNaissances = [];
            let formData = {};

            // Initialize steps
            updateSteps();

            // Verify CMN button
            $('#btnVerify').click(validerFormulaire);

            // Next button (step 2 to step 3)
            $('#nextBtn').click(function() {
                if (validateStep2()) {
                    currentStep = 3;
                    updateSteps();
                    showConfirmationDetails();
                }
            });

            // Previous button (step 3 to step 2)
            $('#backToFormBtn').click(function() {
                currentStep = 2;
                updateSteps();
            });

            // Previous button (step 2 to step 1)
            $('#prevBtn').click(function() {
                currentStep = 1;
                updateSteps();
            });

            // Confirm button (submit form)
            $('#confirmBtn').click(function() {
                if ($('input[name="choix_option"]:checked').val() === 'livraison') {
                    showLivraisonPopup();
                } else {
                    $('#naissanceForm').submit();
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
                    $('#submitBtn').hide();
                } else if (currentStep === 2) {
                    $('#prevBtn').show();
                    $('#nextBtn').show();
                    $('#submitBtn').hide();
                } else if (currentStep === 3) {
                    $('#prevBtn').hide();
                    $('#nextBtn').hide();
                    $('#submitBtn').hide();
                }
            }

            // Validate step 2 (information form)
            function validateStep2() {
                let isValid = true;

                // Validate required fields
                const requiredFields = ['lieuNaiss'];
                requiredFields.forEach(field => {
                    if (!$('#' + field).val()) {
                        $('#' + field + 'Error').text('Ce champ est obligatoire').show();
                        isValid = false;
                    } else {
                        $('#' + field + 'Error').hide();
                    }
                });

                // Validate date of birth
                const userDateNaiss = $("#lieuNaiss").val();
                if (userDateNaiss && expectedDateNaissances.length > 0) {
                    const userDate = new Date(userDateNaiss);
                    let dateMatchFound = false;

                    for (let i = 0; i < expectedDateNaissances.length; i++) {
                        const expectedDate = new Date(expectedDateNaissances[i]);
                        if (userDate.getTime() === expectedDate.getTime()) {
                            dateMatchFound = true;
                            break;
                        }
                    }

                    if (!dateMatchFound) {
                        $("#lieuNaissError").text("La date ne correspond pas au dossier médical").show();
                        isValid = false;
                    }
                }

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
                        <strong><i class="fas fa-female"></i> Mère:</strong>
                        <span>${$('#nomDefunt').val() || 'Non spécifié'}</span>
                    </div>
                    <div class="detail-row">
                        <strong><i class="fas fa-user-friends"></i> Accompagnateur:</strong>
                        <span>${$('#dateNaiss').val() || 'Non spécifié'}</span>
                    </div>
                    <div class="detail-row">
                        <strong><i class="fas fa-baby"></i> Enfant:</strong>
                        <span>${$('#nom').val() || 'Non spécifié'} ${$('#prenom').val() || ''}, né le ${$('#lieuNaiss').val() || 'Non spécifié'}</span>
                    </div>
                    <div class="detail-row">
                        <strong><i class="fas fa-male"></i> Père:</strong>
                        <span>${$('#nompere').val() || 'Non spécifié'} ${$('#prenompere').val() || ''}</span>
                    </div>
                    <div class="detail-row">
                        <strong><i class="fas fa-calendar-alt"></i> Date naissance père:</strong>
                        <span>${$('#datepere').val() || 'Non spécifié'}</span>
                    </div>
                    <div class="detail-row">
                        <strong><i class="fas fa-truck"></i> Mode de retrait:</strong>
                        <span>${$('input[name="choix_option"]:checked').val() === 'livraison' ? 'Livraison à domicile' : 'Retrait sur place'}</span>
                    </div>
                `;
                $('#confirmationDetails').html(details);
            }

            // Verify CMN function
            async function validerFormulaire() {
    const dossierNum = $("#dossierNum").val().trim();
    
    if (!dossierNum) {
        showError('Veuillez entrer un numéro de certificat');
        return;
    }

    try {
        const swalInstance = Swal.fire({
            title: 'Vérification en cours',
            html: 'Veuillez patienter...',
            allowOutsideClick: false,
            didOpen: () => Swal.showLoading()
        });

        const response = await fetch("{{ route('code.verifie.cmn') }}", {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': "{{ csrf_token() }}",
                'Accept': 'application/json'
            },
            body: JSON.stringify({ codeCMN: dossierNum }),
            signal: AbortSignal.timeout(15000) // Annule après 15s
        });

        swalInstance.close();
        
        if (!response.ok) {
            const errorData = await response.json();
            throw new Error(errorData.message || 'Erreur serveur');
        }

        const data = await response.json();
        
        if (data.existe) {
    // Remplir les champs avec les données de la réponse
    $('#nomHopital').val(data.nomHopital);
    $('#nomDefunt').val(data.nomMere);  // Ce champ affiche le nom de la mère
    $('#dateNaiss').val(data.nomPere);  // Ce champ affiche le nom du père
    
    // Stocker les dates de naissance pour validation ultérieure
    expectedDateNaissances = data.dateNaiss;
    
    // Remplir le champ hidden verifiedCmn
    $('#verifiedCmn').val($("#dossierNum").val().trim());
    
    // Passer à l'étape 2
    currentStep = 2;
    updateSteps();
} else {
    throw new Error(data.message || 'Code non trouvé');
}
    } catch (error) {
        Swal.fire({
            icon: 'error',
            title: 'Erreur',
            text: error.message,
            background: 'var(--light-color)',
            color: 'var(--dark-color)'
        });
        console.error("Erreur:", error);
    }
}
            function showLivraisonPopup() {
                Swal.fire({
                    title: 'Informations de Livraison',
                    width: '700px',
                    html: `
                        <div class="swal-grid">
                            <div>
                                <label for="swal-montant_timbre" style="font-weight: bold">Timbre</label>
                                <input id="swal-montant_timbre" class="swal2-input text-center" value="50" readonly>
                                <label for="swal-montant_timbre" style="font-size:13px; color:red">Pour la phase pilote les frais de timbre sont fournir par Kks-technologies</label>
                            </div>
                            <div>
                                <label for="swal-montant_livraison" style="font-weight: bold">Frais Livraison</label>
                                <input id="swal-montant_livraison" class="swal2-input text-center" value="1500" readonly>
                                <label for="swal-montant_livraison" style="font-size:13px; color:red">Pour la phase pilote les frais des livraisons sont fixés à 1500 Fcfa</label>
                            </div>
                            <div><input id="swal-nom_destinataire" class="swal2-input" placeholder="Nom du destinataire"></div>
                            <div><input id="swal-prenom_destinataire" class="swal2-input" placeholder="Prénom du destinataire"></div>
                            <div><input id="swal-email_destinataire" class="swal2-input" placeholder="Email du destinataire"></div>
                            <div><input id="swal-contact_destinataire" class="swal2-input" placeholder="Contact du destinataire"></div>
                            <div><input id="swal-adresse_livraison" class="swal2-input" placeholder="Adresse de livraison"></div>
                            <div><input id="swal-code_postal" class="swal2-input" placeholder="Code postal"></div>
                            <div><input id="swal-ville" class="swal2-input" placeholder="Ville"></div>
                            <div><input id="swal-commune_livraison" class="swal2-input" placeholder="Commune"></div>
                            <div><input id="swal-quartier" class="swal2-input" placeholder="Quartier"></div>
                        </div>`,
                    icon: 'info',
                    showCancelButton: true,
                    confirmButtonText: 'Payer',
                    cancelButtonText: 'Annuler',
                    focusConfirm: false,
                    preConfirm: () => {
                        const fields = [
                            'nom_destinataire', 'prenom_destinataire', 'email_destinataire',
                            'contact_destinataire', 'adresse_livraison', 'code_postal',
                            'ville', 'commune_livraison', 'quartier'
                        ];
                        
                        const values = {};
                        let isValid = true;
                        
                        fields.forEach(field => {
                            const element = document.getElementById(`swal-${field}`);
                            values[field] = element.value.trim();
                            
                            if (!values[field]) {
                                isValid = false;
                                element.style.borderColor = 'red';
                            } else {
                                element.style.borderColor = '';
                            }
                        });
                        
                        values.montant_timbre = document.getElementById('swal-montant_timbre').value;
                        values.montant_livraison = document.getElementById('swal-montant_livraison').value;
                        
                        if (!isValid) {
                            Swal.showValidationMessage("Veuillez remplir tous les champs obligatoires");
                            return false;
                        }
                        
                        // Validation de l'email
                        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                        if (!emailRegex.test(values.email_destinataire)) {
                            document.getElementById('swal-email_destinataire').style.borderColor = 'red';
                            Swal.showValidationMessage("Veuillez entrer une adresse email valide");
                            return false;
                        }
                        
                        // Validation du contact (supposons que c'est un numéro de téléphone)
                        const phoneRegex = /^[0-9]{10,15}$/;
                        if (!phoneRegex.test(values.contact_destinataire)) {
                            document.getElementById('swal-contact_destinataire').style.borderColor = 'red';
                            Swal.showValidationMessage("Veuillez entrer un numéro de téléphone valide");
                            return false;
                        }
                        
                        return values;
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                        const formData = result.value;
                        const form = document.getElementById('naissanceForm');
                        initiateCinetPayPaymentNaissance(formData, form);
                    } else if (result.dismiss === Swal.DismissReason.cancel) {
                        document.getElementById('option1').checked = true;
                    }
                });
            }
        });
    </script>
@endsection
