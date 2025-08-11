@extends('user.layouts.template')

@section('content')

<!-- Inclure SweetAlert2 et CinetPay -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdn.cinetpay.com/seamless/main.js"></script>

<!-- Inclure le fichier JavaScript externe pour CinetPay -->
<script src="{{ asset('js/cinetpay.js') }}"></script>

<style>
    :root {
        --primary-color: #1977cc;
        --secondary-color: #1977cc;
        --accent-color: #ff7e5f;
        --light-color: #f4f9f4;
        --dark-color: #2d3436;
        --shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
        --transition: all 0.3s ease;
    }

    body {
        background: linear-gradient(135deg, #f5f7fa 0%, #e4efe9 100%);
        min-height: 100vh;
        margin: 0;
        padding: 0;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    .form-container {
        background: white;
        padding: 2.5rem;
        border-radius: 16px;
        box-shadow: var(--shadow);
        max-width: 1000px;
        margin: 10rem auto;
        animation: fadeInUp 0.6s ease-out;
        position: relative;
        overflow: hidden;
    }

    .form-container::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 8px;
        height: 100%;
        background: linear-gradient(to bottom, var(--primary-color), var(--secondary-color));
    }

    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    h2.form-title {
        text-align: center;
        color: var(--primary-color);
        margin-bottom: 100px;
        font-size: 2rem;
        font-weight: 700;
        position: relative;
        padding-bottom: 0.5rem;

    }

    h2.form-title::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 50%;
        top: 50px;
        transform: translateX(-50%);
        width: 80px;
        height: 4px;
        background: var(--accent-color);
        border-radius: 2px;
    }

    .form-label {
        font-weight: 600;
        color: var(--dark-color);
        margin-bottom: 0.5rem;
        display: block;
        font-size: 0.95rem;
    }

    .form-control {
        width: 100%;
        padding: 0.5rem 1rem;
        border: 1px solid #e0e0e0;
        border-radius: 8px;
        background: #f9f9f9;
        transition: var(--transition);
        font-size: 0.95rem;
    }

    .form-control:focus {
        outline: none;
        border-color: var(--secondary-color);
        box-shadow: 0 0 0 3px rgba(111, 185, 143, 0.2);
        background: white;
    }

    .form-select {
        appearance: none;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='%232c7873' viewBox='0 0 16 16'%3E%3Cpath d='M7.247 11.14 2.451 5.658C1.885 5.013 2.345 4 3.204 4h9.592a1 1 0 0 1 .753 1.659l-4.796 5.48a1 1 0 0 1-1.506 0z'/%3E%3C/svg%3E");
        background-repeat: no-repeat;
        background-position: right 1rem center;
        background-size: 16px 12px;
    }

    .form-row {
        display: flex;
        flex-wrap: wrap;
        margin: 0 -0.75rem 1.25rem;
    }

    .form-col {
        padding: 0 0.75rem;
        flex: 0 0 100%;
        margin-bottom: 1rem;
    }

    @media (min-width: 768px) {
        .form-col {
            flex: 0 0 50%;
            margin-bottom: 0;
        }
    }

    .btn-submit {
        background: linear-gradient(to right, var(--primary-color), var(--secondary-color));
        color: white;
        border: none;
        padding: 1rem 2rem;
        font-size: 1rem;
        font-weight: 600;
        border-radius: 8px;
        cursor: pointer;
        transition: var(--transition);
        width: 100%;
        margin-top: 1rem;
        box-shadow: 0 4px 15px rgba(44, 120, 115, 0.3);
    }

    .btn-submit:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(44, 120, 115, 0.4);
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

    .error-message {
        color: #e74c3c;
        font-size: 0.85rem;
        margin-top: 0.25rem;
        display: block;
    }

    .file-input-container {
        position: relative;
        overflow: hidden;
    }

    .file-input-label {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 0.8rem 1rem;
        background: #f9f9f9;
        border: 1px solid #e0e0e0;
        border-radius: 8px;
        cursor: pointer;
        transition: var(--transition);
    }

    .file-input-label:hover {
        background: #f0f0f0;
    }

    .file-input-text {
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        color: #666;
    }

    .file-input-button {
        background: var(--primary-color);
        color: white;
        padding: 0.3rem 0.8rem;
        border-radius: 6px;
        font-size: 0.85rem;
        margin-left: 1rem;
    }

    .file-input {
        position: absolute;
        left: 0;
        top: 0;
        opacity: 0;
        width: 100%;
        height: 100%;
        cursor: pointer;
    }

    /* Animation pour les champs */
    @keyframes pulse {
        0% { box-shadow: 0 0 0 0 rgba(111, 185, 143, 0.4); }
        70% { box-shadow: 0 0 0 10px rgba(111, 185, 143, 0); }
        100% { box-shadow: 0 0 0 0 rgba(111, 185, 143, 0); }
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

    @media (max-width: 600px) {
        .swal-delivery-grid {
            grid-template-columns: 1fr;
        }
    }

    .swal2-input {
        border-radius: 6px !important;
        border: 1px solid #e0e0e0 !important;
    }

    .swal2-input:focus {
        box-shadow: 0 0 0 3px rgba(111, 185, 143, 0.2) !important;
        border-color: var(--secondary-color) !important;
    }
</style>

@if (Session::get('success'))
    <script>
        Swal.fire({
            icon: 'success',
            title: 'Succès',
            text: '{{ Session::get('success') }}',
            timer: 3000,
            showConfirmButton: false,
            background: 'white',
            backdrop: `
                rgba(44, 120, 115, 0.4)
                left top
                no-repeat
            `
        });
    </script>
@endif

@if (Session::get('error'))
    <script>
        Swal.fire({
            icon: 'error',
            title: 'Erreur',
            text: '{{ Session::get('error') }}',
            timer: 3000,
            showConfirmButton: false,
            background: 'white'
        });
    </script>
@endif

<div class="form-container">
    <h2 class="form-title">Demande d'Extrait de Naissance</h2>
    
    <form id="naissanceForm" action="{{route('user.extrait.simple.store')}}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="form-row">
            <div class="form-col">
                <label for="pour" class="form-label">Cette demande est pour :</label>
                <select id="pour" name="pour" class="form-control form-select" onchange="updateFields()">
                    <option value="Moi" {{ old('pour') == 'Moi' ? 'selected' : '' }}>Moi-même</option>
                    <option value="une_autre_personne" {{ old('pour') == 'une_autre_personne' ? 'selected' : '' }}>Une autre personne</option>
                </select>
                @error('pour')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>
            
            <div class="form-col">
                <label for="type" class="form-label">Type de document :</label>
                <select id="type" name="type" class="form-control form-select">
                    <option value="simple" {{ old('type') == 'simple' ? 'selected' : '' }}>Extrait simple</option>
                    <option value="extrait_integral" {{ old('type') == 'extrait_integral' ? 'selected' : '' }}>Extrait intégral</option>
                </select>
                @error('type')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>
        </div>
        
        <div class="form-row">
            <div class="form-col">
                <label for="name" class="form-label">Nom :</label>
                <input type="text" id="name" name="name" class="form-control" value="{{ old('name', $userName) }}" >
                @error('name')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>
            
            <div class="form-col">
                <label for="prenom" class="form-label">Prénoms :</label>
                <input type="text" id="prenom" name="prenom" class="form-control" value="{{ old('prenom', $userPrenom) }}" >
                @error('prenom')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <div class="form-row">
            <div class="form-col">
                <label for="number" class="form-label">Numéro de registre :</label>
                <input type="text" id="number" name="number" class="form-control" value="{{ old('number') }}" placeholder="Ex: 2023-1234">
                @error('number')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>
            
            <div class="form-col">
                <label for="DateR" class="form-label">Date de registre :</label>
                <input type="date" id="DateR" name="DateR" class="form-control" value="{{ old('DateR') }}" >
                @error('DateR')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <div class="form-row">
            <div class="form-col">
                <label for="commune" class="form-label">Commune de naissance :</label>
                <input type="text" id="commune" name="commune" class="form-control" value="plateau" readonly>
                @error('commune')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>
            
            <div class="form-col">
                <label for="CNI" class="form-label">Pièce d'identité (CNI/Passeport) :</label>
                <div class="file-input-container">
                    <label class="file-input-label">
                        <span class="file-input-text" id="file-name">Aucun fichier sélectionné</span>
                        <span class="file-input-button">Parcourir</span>
                        <input type="file" id="CNI" name="CNI" class="file-input" onchange="updateFileName(this)">
                    </label>
                </div>
                @error('CNI')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <div class="form-row">
            <div class="form-col">
                <label for="CMU" class="form-label">Numéro CMU (si disponible) :</label>
                <input type="text" id="CMU" name="CMU" class="form-control" value="{{ old('CMU', $userCMU) }}" placeholder="Optionnel">
                @error('CMU')
                    <span class="error-message">{{ $message }}</span>
                @enderror
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

        <button type="submit" id="btnValider" class="btn-submit">Soumettre la demande</button>
    </form>
</div>

<script>
    let formSubmitted = false;

    function updateFields() {
        const pourSelect = document.getElementById('pour');
        const nameInput = document.getElementById('name');
        const prenomInput = document.getElementById('prenom');
        const communeSelect = document.getElementById('commune');
        const CMUInput = document.getElementById('CMU');

        if (pourSelect.value === 'Moi') {
            nameInput.value = '{{ $userName }}';
            prenomInput.value = '{{ $userPrenom }}';
            // Sélectionner l'option correspondant à la commune de l'utilisateur
            const userCommune = '{{ $userCommune }}';
            if (userCommune) {
                for (let i = 0; i < communeSelect.options.length; i++) {
                    if (communeSelect.options[i].value === userCommune) {
                        communeSelect.selectedIndex = i;
                        break;
                    }
                }
            }
            CMUInput.value = '{{ $userCMU }}';
        } else {
            nameInput.value = '';
            prenomInput.value = '';
            communeSelect.selectedIndex = 0; // Réinitialiser à "Sélectionnez une commune"
            CMUInput.value = '';
        }
    }

    function updateFileName(input) {
        const fileName = input.files[0] ? input.files[0].name : 'Aucun fichier sélectionné';
        document.getElementById('file-name').textContent = fileName;
    }

    document.addEventListener('DOMContentLoaded', function() {
        updateFields();
        
        // Animation pour les champs obligatoires
        const requiredFields = document.querySelectorAll('input[required], select[required]');
        requiredFields.forEach(field => {
            field.addEventListener('focus', function() {
                this.style.animation = 'pulse 1.5s infinite';
            });
            field.addEventListener('blur', function() {
                this.style.animation = 'none';
            });
        });
    });

    document.getElementById('naissanceForm').addEventListener('submit', function(event) {
        if (formSubmitted) {
            event.preventDefault();
            return;
        }

        const livraisonCheckbox = document.getElementById('option2');
        if (livraisonCheckbox.checked) {
            event.preventDefault();
            showPaymentPopup();
        } else {
            formSubmitted = true;
            this.submit();
        }
    });

    function showPaymentPopup() {
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
                        <input id="swal-montant_livraison" class="swal2-input text-center" value="1500" readonly>
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
            confirmButtonColor: '#2c7873',
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
</script>
@endsection