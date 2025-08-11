@extends('user.layouts.template')
@section('content')

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdn.cinetpay.com/seamless/main.js"></script>
<script src="{{ asset('js/cinetpay_deces_deja.js') }}"></script>

<style>
    .death-certificate-container {
        background: rgba(255, 255, 255, 0.95);
        border-radius: 16px;
        box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
        backdrop-filter: blur(8px);
        padding: 2.5rem;
        max-width: 1000px;
        margin: 2rem auto;
        animation: fadeIn 0.6s ease-out;
        border: 1px solid rgba(255, 255, 255, 0.2);
    }

    .death-certificate-title {
        text-align: center;
        color: #1977cc;
        margin-bottom: 2rem;
        font-size: 2rem;
        font-weight: 600;
        position: relative;
        padding-bottom: 1rem;
    }

    .death-certificate-title::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 50%;
        transform: translateX(-50%);
        width: 80px;
        height: 4px;
        background-color: #ff7e5f;
        border-radius: 2px;
    }

    .form-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 1.5rem;
        margin-bottom: 1.5rem;
    }

    .form-group {
        margin-bottom: 1.25rem;
    }

    .form-group.full-width {
        grid-column: span 2;
    }

    .form-label {
        display: block;
        margin-bottom: 0.5rem;
        font-weight: 600;
        color: #1977cc;
        font-size: 0.95rem;
    }

    .form-control {
        width: 100%;
        padding: 0.75rem 1rem;
        border: 1px solid #e2e8f0;
        border-radius: 10px;
        background-color: #f8fafc;
        transition: all 0.3s ease;
        font-size: 0.95rem;
    }

    .form-control:focus {
        outline: none;
        border-color: #1977cc;
        box-shadow: 0 0 0 3px rgba(26, 92, 88, 0.1);
        background-color: #fff;
    }

    .radio-group {
        display: flex;
        align-items: center;
        gap: 1rem;
        margin-bottom: 1rem;
    }

    .radio-label {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        cursor: pointer;
        font-weight: 500;
        color: #4a5568;
    }

    .radio-input {
        width: 18px;
        height: 18px;
        accent-color: #1977cc;
    }

    .submit-btn {
        width: 100%;
        padding: 1rem;
        background: linear-gradient(135deg, #1977cc, #1977cc);
        color: white;
        border: none;
        border-radius: 10px;
        font-size: 1rem;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        margin-top: 1rem;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }

    .submit-btn:hover {
        background: linear-gradient(135deg, #1569b2, #1569b2);
        transform: translateY(-2px);
        box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15);
    }

    .submit-btn:active {
        transform: translateY(0);
    }

    .error-message {
        color: #e53e3e;
        font-size: 0.85rem;
        margin-top: 0.25rem;
        display: block;
    }

    .conditional-section {
        background: #f7fafc;
        padding: 1.5rem;
        border-radius: 10px;
        margin: 1rem 0;
        border-left: 4px solid #1977cc;
    }

    .conditional-title {
        font-weight: 600;
        color: #1977cc;
        margin-bottom: 1rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .delivery-options {
        margin-top: 2rem;
        padding-top: 1.5rem;
        border-top: 1px solid #e2e8f0;
    }

    .options-title {
        text-align: center;
        font-weight: 600;
        color: #1977cc;
        margin-bottom: 1.5rem;
        position: relative;
    }

    .options-title::before {
        content: '';
        position: absolute;
        top: -15px;
        left: 50%;
        transform: translateX(-50%);
        width: 50px;
        height: 3px;
        background: linear-gradient(90deg, #1977cc, #3e8e41);
    }

    .options-grid {
        display: flex;
        justify-content: center;
        gap: 2rem;
        margin-bottom: 1.5rem;
    }

    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }

    /* Responsive styles */
    @media (max-width: 768px) {
        .form-grid {
            grid-template-columns: 1fr;
        }

        .form-group.full-width {
            grid-column: span 1;
        }

        .death-certificate-container {
            padding: 1.5rem;
            margin: 1rem;
        }

        .death-certificate-title {
            font-size: 1.5rem;
            margin-bottom: 1.5rem;
        }

        .options-grid {
            flex-direction: column;
            gap: 1rem;
        }
    }

    /* SweetAlert custom styles */
    .swal-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 1rem;
    }

    .swal2-input {
        width: 90% !important;
        margin: 0.5rem auto !important;
    }

    .radio-options {
        display: flex;
        flex-wrap: wrap;
        gap: 1rem;
        margin: 1.5rem 0;
        justify-content: center;
    }

    .radio-card {
        position: relative;
        flex: 1 1 200px;
        max-width: 250px;
    }

    .radio-card input[type="radio"] {
        position: absolute;
        opacity: 0;
    }

    .radio-card label {
        display: block;
        padding: 1.5rem 1rem;
        background: white;
        border: 2px solid #e0e0e0;
        border-radius: 10px;
        text-align: center;
        cursor: pointer;
        transition: var(--transition);
    }

    .radio-card label:hover {
        border-color: var(--secondary-color);
    }

    .radio-card input[type="radio"]:checked + label {
        border-color: var(--primary-color);
        background-color: rgba(44, 120, 115, 0.05);
        box-shadow: 0 0 0 1px var(--primary-color);
    }

    .radio-card .icon {
        font-size: 2rem;
        color: var(--primary-color);
        margin-bottom: 0.5rem;
        display: inline-block;
    }
    .form-control:focus {
        animation: pulse 1.5s infinite;
    }

    /* Style pour la popup de livraison */
    .swal-delivery-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 1rem;
    }

    @media (max-width: 640px) {
        .swal-grid {
            grid-template-columns: 1fr;
        }
    }
</style>

<div class="death-certificate-container">
    <h1 class="death-certificate-title">Demande d'extrait de décès</h1>
    
    <form id="declarationForm" method="POST" enctype="multipart/form-data" action="{{route('user.extrait.deces.store')}}">
        @csrf
        
        <div class="form-grid">
            <div class="form-group">
                <label for="name" class="form-label">Nom et Prénoms du Défunt</label>
                <input type="text" id="name" name="name" class="form-control" value="{{old('name')}}" placeholder="Exemple : Jean Dupont">
                @error('name')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>
            
            <div class="form-group">
                <label for="numberR" class="form-label">Numéro de Registre</label>
                <input type="text" id="numberR" name="numberR" class="form-control" value="{{old('numberR')}}"  placeholder="Exemple : 123456">
                @error('numberR')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>
            
            <div class="form-group">
                <label for="dateR" class="form-label">Date de Registre</label>
                <input type="date" id="dateR" name="dateR" class="form-control" value="{{old('dateR')}}" >
                @error('dateR')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>
            
            <div class="form-group">
                <label for="communeD" class="form-label">Commune</label>
                <input type="text" id="communeD" name="communeD" class="form-control" value="plateau" readonly>
                @error('communeD')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>
            
            <div class="form-group">
                <label for="pActe" class="form-label">Certificat Médical de Décès</label>
                <input type="file" id="pActe" name="pActe" class="form-control" accept=".pdf,.jpg,.png">
                @error('pActe')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>
            
            <div class="form-group">
                <label for="CMU" class="form-label">Numéro CMU du demandeur</label>
                <input type="text" id="CMU" name="CMU" class="form-control" value="{{old('CMU') }}" placeholder="Entrez votre numéro CMU">
                @error('CMU')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>
            
            <div class="form-group">
                <label for="CNIdfnt" class="form-label">CNI/extrait de naissance du défunt(e)</label>
                <input type="file" name="CNIdfnt" id="CNIdfnt" class="form-control">
                @error('CNIdfnt')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>
            
            <div class="form-group">
                <label for="CNIdcl" class="form-label">CNI du déclarant</label>
                <input type="file" name="CNIdcl" id="CNIdcl" class="form-control">
                @error('CNIdcl')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>
        </div>
        
        <!-- Marriage conditional section -->
        <div class="conditional-section">
            <h3 class="conditional-title">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M19 21l-7-5-7 5V5a2 2 0 0 1 2-2h10a2 2 0 0 1 2 2z"></path>
                </svg>
                Le défunt était-il marié ?
            </h3>
            <div class="radio-group">
                <label class="radio-label">
                    <input type="radio" id="oui" name="married" value="oui" class="radio-input">
                    Oui
                </label>
                <label class="radio-label">
                    <input type="radio" id="non" name="married" value="non" checked class="radio-input">
                    Non
                </label>
            </div>
            <div id="married-file-inputs-container"></div>
        </div>
        
        <!-- Death location conditional section -->
        <div class="conditional-section">
            <h3 class="conditional-title">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="12" cy="12" r="10"></circle>
                    <line x1="4.93" y1="4.93" x2="19.07" y2="19.07"></line>
                </svg>
                Le défunt est-il décédé hors d'un centre de santé ?
            </h3>
            <div class="radio-group">
                <label class="radio-label">
                    <input type="radio" id="ouiHorsS" name="DecesHorsS" value="oui" class="radio-input">
                    Oui
                </label>
                <label class="radio-label">
                    <input type="radio" id="nonHorsS" name="DecesHorsS" value="non" checked class="radio-input">
                    Non
                </label>
            </div>
            <div id="deces-file-inputs-container"></div>
        </div>
        
        <!-- Delivery options -->
        <div class="delivery-options" id="optionsSection">
            <h3 class="options-title">Choisissez le mode de retrait</h3>
            <div class="options-grid">
                <label class="radio-label">
                    <input type="radio" id="option1" name="choix_option" value="Retrait sur place" checked class="radio-input">
                    Retrait sur place
                </label>
                <label class="radio-label">
                    <input type="radio" id="option2" name="choix_option" value="livraison" class="radio-input">
                    Livraison
                </label>
            </div>
        </div>

        <div class="delivery-options">
            <p class="form-label text-center" style="margin-bottom: 1rem;">Options de retrait :</p>
            <div class="radio-options">
                <div class="radio-card">
                    <input type="radio" id="option1" name="choix_option" value="Retrait sur place" checked>
                    <label for="option1">
                        <div class="icon">🏢</div>
                        <div>Retrait sur place</div>
                        <small>Gratuit</small>
                    </label>
                </div>
                <div class="radio-card">
                    <input type="radio" id="option2" name="choix_option" value="livraison">
                    <label for="option2">
                        <div class="icon">🚚</div>
                        <div>Livraison à domicile</div>
                        <small>Frais: 1500 FCFA</small>
                    </label>
                </div>
            </div>
        </div>
        
        <button type="submit" class="submit-btn">Valider la demande</button>
    </form>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    let formSubmitted = false;
    let submitAfterPopup = false;

    $(document).ready(function () {
        // Cache la section de retrait au départ
        $("#optionsSection").hide();

        // Vérifie si tous les champs obligatoires sont remplis
        function checkFields() {
    try {
        // Get all required inputs (excluding hidden and disabled fields)
        const requiredInputs = $("#declarationForm").find("input[required]:not(:hidden):not(:disabled)");
        
        let isFilled = true;
        
        requiredInputs.each(function() {
            if ($(this).val().trim() === "") {
                isFilled = false;
                return false; // Break out of the loop early
            }
        });
        
        if (isFilled) {
            $("#optionsSection").fadeIn();
        } else {
            $("#optionsSection").hide();
        }
    } catch (error) {
        console.error("Error in checkFields:", error);
    }
}

        $("#declarationForm input, #declarationForm select").on("input change", checkFields);
        checkFields();

        // ==============================
        // MARIAGE
        // ==============================
        const marriedFileInputsContainer = $("#married-file-inputs-container");
        const marriageFields = `
            <div class="form-group">
                <label for="documentMariage" class="form-label">Photocopie de document de mariage pour le défunt(e)</label>
                <input type="file" id="documentMariage" name="documentMariage" class="form-control" required>
            </div>
        `;

        function toggleMarriedFields() {
            if ($('input[name="married"]:checked').val() === 'oui') {
                marriedFileInputsContainer.html(marriageFields);
            } else {
                marriedFileInputsContainer.empty();
            }
        }

        $(document).on('change', 'input[name="married"]', toggleMarriedFields);
        toggleMarriedFields(); // Vérifie au chargement

        // ==============================
        // DÉCÈS HORS CENTRE
        // ==============================
        const decesFileInputsContainer = $("#deces-file-inputs-container");
        const decesFields = `
            <div class="form-group">
                <label for="RequisPolice" class="form-label">Photocopie de la réquisition de la police</label>
                <input type="file" id="RequisPolice" name="RequisPolice" class="form-control" required>
            </div>
        `;

        function toggleDecesFields() {
            if ($('input[name="DecesHorsS"]:checked').val() === 'oui') {
                decesFileInputsContainer.html(decesFields);
            } else {
                decesFileInputsContainer.empty();
            }
        }

        $(document).on('change', 'input[name="DecesHorsS"]', toggleDecesFields);
        toggleDecesFields(); // Vérifie au chargement

        // ==============================
        // SOUMISSION FORMULAIRE
        // ==============================
        $("#declarationForm").submit(function(event) {
            if (formSubmitted) {
                event.preventDefault();
                return;
            }

            const livraisonCheckbox = $("#option2");
            if (livraisonCheckbox.is(":checked") && !submitAfterPopup) {
                event.preventDefault();
                showLivraisonPopup();
            } else {
                formSubmitted = true;
            }
        });
    });

    // ==============================
    // POPUP LIVRAISON
    // ==============================
    function showLivraisonPopup() {
        Swal.fire({
            title: 'Informations de Livraison',
            width: '700px',
            html: `
                <div class="swal-grid">
                    <div>
                        <label for="swal-montant_timbre" style="font-weight: bold">Timbre</label>
                        <input id="swal-montant_timbre" class="swal2-input text-center" value="50" readonly>
                        <label style="font-size:13px; color:red">Pour la phase pilote les frais de timbre sont fournis par Kks-technologies</label>
                    </div>
                    <div>
                        <label for="swal-montant_livraison" style="font-weight: bold">Frais Livraison</label>
                        <input id="swal-montant_livraison" class="swal2-input text-center" value="1500" readonly>
                        <label style="font-size:13px; color:red">Pour la phase pilote les frais de livraison sont fixés à 1500 Fcfa</label>
                    </div>
                    <div><input id="swal-nom_destinataire" class="swal2-input text-center" placeholder="Nom du destinataire"></div>
                    <div><input id="swal-prenom_destinataire" class="swal2-input text-center" placeholder="Prénom du destinataire"></div>
                    <div><input id="swal-email_destinataire" class="swal2-input text-center" placeholder="Email du destinataire"></div>
                    <div><input id="swal-contact_destinataire" class="swal2-input text-center" placeholder="Contact du destinataire"></div>
                    <div><input id="swal-adresse_livraison" class="swal2-input text-center" placeholder="Adresse de livraison"></div>
                    <div><input id="swal-code_postal" class="swal2-input text-center" placeholder="Code postal"></div>
                    <div><input id="swal-ville" class="swal2-input text-center" placeholder="Ville"></div>
                    <div><input id="swal-commune_livraison" class="swal2-input text-center" placeholder="Commune"></div>
                    <div><input id="swal-quartier" class="swal2-input text-center" placeholder="Quartier"></div>
                </div>`,
            icon: 'info',
            showCancelButton: true,
            confirmButtonText: 'Payer',
            cancelButtonText: 'Annuler',
            focusConfirm: false,
            preConfirm: () => {
                const nom_destinataire = $("#swal-nom_destinataire").val();
                const prenom_destinataire = $("#swal-prenom_destinataire").val();
                const email_destinataire = $("#swal-email_destinataire").val();
                const contact_destinataire = $("#swal-contact_destinataire").val();
                const adresse_livraison = $("#swal-adresse_livraison").val();
                const code_postal = $("#swal-code_postal").val();
                const ville = $("#swal-ville").val();
                const commune_livraison = $("#swal-commune_livraison").val();
                const quartier = $("#swal-quartier").val();
                const montant_timbre = $("#swal-montant_timbre").val();
                const montant_livraison = $("#swal-montant_livraison").val();

                if (!nom_destinataire || !prenom_destinataire || !email_destinataire || 
                    !contact_destinataire || !adresse_livraison || !code_postal || 
                    !ville || !commune_livraison || !quartier) {
                    Swal.showValidationMessage("Veuillez remplir tous les champs pour la livraison.");
                    return false;
                }
                return {
                    nom_destinataire,
                    prenom_destinataire,
                    email_destinataire,
                    contact_destinataire,
                    adresse_livraison,
                    code_postal,
                    ville,
                    commune_livraison,
                    quartier,
                    montant_timbre,
                    montant_livraison,
                };
            }
        }).then((result) => {
            if (result.isConfirmed) {
                const formData = result.value;
                const form = document.getElementById('declarationForm');
                initiateCinetPayPaymentDecesDeja(formData, form);
            } else if (result.dismiss === Swal.DismissReason.cancel) {
                $("#option1").prop("checked", true);
                submitAfterPopup = false;
            }
        });
    }
</script>


@endsection