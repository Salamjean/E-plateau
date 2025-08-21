
@extends('doctor.layouts.template')

@section('content')
<div class="modern-form-container">
  <div class="form-wrapper">
    <form id="msform" action="{{ route('statement.store') }}" method="POST" enctype="multipart/form-data">
      @csrf
      
      <!-- Barre de progression moderne -->
      <div class="progress-container">
        <div class="progress-bar">
          <div class="progress-fill" id="progress-fill"></div>
        </div>
        <div class="progress-steps">
          <div class="step active" data-step="1">
            <div class="step-icon">👩</div>
            <span class="step-label">Mère</span>
          </div>
          <div class="step" data-step="2">
            <div class="step-icon">👨</div>
            <span class="step-label">Accompagnateur</span>
          </div>
          <div class="step" data-step="3">
            <div class="step-icon">👶</div>
            <span class="step-label">Nouveau-né</span>
          </div>
        </div>
      </div>

      <!-- Étape 1: Informations sur la mère -->
      <div class="form-step active" id="step-1">
        <h2 class="form-title">Déclaration de naissance</h2>
        <p class="form-subtitle">Informations sur la mère</p>
        
        <div class="input-grid">
          <div class="input-group">
            <label for="NomM">Nom de la mère  <span style="color:red">*</span></label>
            <input type="text" id="NomM" name="NomM" placeholder="Entrez le nom de la mère" />
            @error('NomM')
            <div class="error-message">{{ $message }}</div>
            @enderror
          </div>
          
          <div class="input-group">
            <label for="PrM">Prénom de la mère <span style="color:red">*</span></label>
            <input type="text" id="PrM" name="PrM" placeholder="Entrez le prénom de la mère" />
            @error('PrM')
            <div class="error-message">{{ $message }}</div>
            @enderror
          </div>
        </div>
        
        <div class="input-grid">
          <div class="input-group">
            <label for="dateM">Date de naissance de la mère <span style="color:red">*</span></label>
            <input type="date" id="dateM" name="dateM" />
            @error('dateM')
            <div class="error-message">{{ $message }}</div>
            @enderror
          </div>
          
          <div class="input-group">
            <label>Joindre copie CNI/passeport/extrait de la mère <span style="color:red">*</span></label>
            <div class="upload-interface">
              <div class="upload-options">
                <button type="button" class="option-button camera-option" id="takePhotoBtn">
                  <i class="icon-camera"></i> Prendre une photo
                </button>
                <button type="button" class="option-button upload-option" id="uploadFileBtn">
                  <i class="icon-upload"></i> Télécharger un fichier
                </button>
              </div>
              
              <div class="camera-container" id="cameraContainer">
                <video id="cameraPreview" autoplay playsinline></video>
                <div class="camera-buttons">
                  <button type="button" class="btn-primary" id="captureBtn">Capturer</button>
                  <button type="button" class="btn-secondary" id="cancelCameraBtn">Annuler</button>
                </div>
              </div>
              
              <input type="file" id="fileInput" name="CNI_mere" accept="image/*,.pdf" style="display: none;" />
              
              <div class="file-preview-container">
                <img id="imagePreview" class="file-preview" alt="Aperçu de l'image">
                <div id="pdfPreview" class="pdf-preview">
                  <i class="icon-pdf"></i>
                  <p>Fichier PDF sélectionné</p>
                </div>
              </div>
            </div>
            @error('CNI_mere')
            <div class="error-message">{{ $message }}</div>
            @enderror
          </div>
        </div>
        
        <div class="input-grid">
          <div class="input-group">
            <label for="contM">Numéro de téléphone de la mère <span style="color:red">*</span></label>
            <input type="text" id="contM" name="contM" placeholder="Entrez le numéro de téléphone" />
            @error('contM')
            <div class="error-message">{{ $message }}</div>
            @enderror
          </div>
          
          <div class="input-group">
            <label for="codeCMU">Numéro CMU de la mère <span style="color:red">*</span></label>
            <input type="text" id="codeCMU" name="codeCMU" placeholder="Entrez le numéro CMU" />
            @error('codeCMU')
            <div class="error-message">{{ $message }}</div>
            @enderror
          </div>
        </div>
        
        <div class="form-navigation">
          <button type="button" class="btn-next" data-next="2">Suivant</button>
        </div>
      </div>

      <!-- Étape 2: Informations sur l'accompagnateur -->
      <div class="form-step" id="step-2">
        <h2 class="form-title">Déclaration de naissance</h2>
        <p class="form-subtitle">Informations sur l'accompagnateur</p>
        
        <div class="input-grid">
          <div class="input-group">
            <label for="NomP">Nom de l'accompagnateur <span style="color:red">*</span></label>
            <input type="text" id="NomP" name="NomP" placeholder="Entrez le nom de l'accompagnateur" />
            @error('NomP')
            <div class="error-message">{{ $message }}</div>
            @enderror
          </div>
          
          <div class="input-group">
            <label for="PrP">Prénom de l'accompagnateur <span style="color:red">*</span></label>
            <input type="text" id="PrP" name="PrP" placeholder="Entrez le prénom de l'accompagnateur" />
            @error('PrP')
            <div class="error-message">{{ $message }}</div>
            @enderror
          </div>
        </div>
        
        <div class="input-grid">
          <div class="input-group">
            <label for="contP">Numéro de téléphone de l'accompagnateur <span style="color:red">*</span></label>
            <input type="text" id="contP" name="contP" placeholder="Entrez le numéro de téléphone" />
            @error('contP')
            <div class="error-message">{{ $message }}</div>
            @enderror
          </div>
          
          <div class="input-group">
            <label for="CNI_Pere">Numéro CNI/CMU/Passeport</label>
            <input type="text" id="CNI_Pere" name="CNI_Pere" placeholder="Entrez le numéro CNI/CMU/Passeport" />
            @error('CNI_Pere')
            <div class="error-message">{{ $message }}</div>
            @enderror
          </div>
        </div>
        
        <div class="input-group">
          <label for="lien">Lien parental <span style="color:red">*</span></label>
          <input type="text" id="lien" name="lien" placeholder="Entrez le lien parental" />
          @error('lien')
          <div class="error-message">{{ $message }}</div>
          @enderror
        </div>
        
        <div class="form-navigation">
          <button type="button" class="btn-prev" data-prev="1">Retour</button>
          <button type="button" class="btn-next" data-next="3">Suivant</button>
        </div>
      </div>

      <!-- Étape 3: Informations du nouveau-né -->
      <div class="form-step" id="step-3">
        <h2 class="form-title">Informations du nouveau-né</h2>
        <p class="form-subtitle">Complétez les informations du bébé</p>
        
        <div class="input-grid">
          <div class="input-group">
            <label for="NomEnf">Nom de l'hôpital</label>
            <input type="text" id="NomEnf" name="NomEnf" value="{{ Auth::guard('doctor')->user()->nomHop }}" readonly />
          </div>
          
          <div class="input-group">
            <label for="commune">Commune</label>
            <input type="text" id="commune" name="commune" value="{{ Auth::guard('doctor')->user()->commune }}" readonly />
          </div>
        </div>
        
        <div class="input-group">
          <label for="nombre_enfants">Nombre d'enfant(s) né(s) <span style="color:red">*</span></label>
          <select name="nombreEnf" id="nombre_enfants" class="styled-select">
            <option value="1">1</option>
            <option value="2">2</option>
            <option value="3">3</option>
            <option value="4">4</option>
          </select>
          @error('nombreEnf')
          <div class="error-message">{{ $message }}</div>
          @enderror
        </div>
        
        <div id="champs_enfants"></div>
        
        <div class="form-navigation">
          <button type="button" class="btn-prev" data-prev="2">Retour</button>
          <button type="submit" class="btn-submit">Valider la déclaration</button>
        </div>
      </div>
    </form>
  </div>
</div>

<style>
  /* Styles modernes pour le formulaire */
  .modern-form-container {
    padding: 2rem;
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    background-color: #f8fafc;
    min-height: 100vh;
  }
  
  .form-wrapper {
    max-width: 80%;
    margin: 0 auto;
    background: white;
    border-radius: 12px;
    box-shadow: 0 10px 25px rgba(0, 0, 0, 0.05);
    padding: 2rem;
  }
  
  /* Barre de progression */
  .progress-container {
    margin-bottom: 2.5rem;
    position: relative;
  }
  
  .progress-bar {
    height: 6px;
    background-color: #e2e8f0;
    border-radius: 3px;
    position: absolute;
    top: 20px;
    left: 0;
    right: 0;
    z-index: 1;
  }
  
  .progress-fill {
    height: 100%;
    background-color: #4299e1;
    border-radius: 3px;
    width: 0%;
    transition: width 0.5s ease;
  }
  
  .progress-steps {
    display: flex;
    justify-content: space-between;
    position: relative;
    z-index: 2;
  }
  
  .step {
    display: flex;
    flex-direction: column;
    align-items: center;
    position: relative;
  }
  
  .step-icon {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    background-color: white;
    border: 3px solid #e2e8f0;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.2rem;
    margin-bottom: 0.5rem;
    transition: all 0.3s ease;
  }
  
  .step.active .step-icon {
    border-color: #4299e1;
    background-color: #4299e1;
    color: white;
  }
  
  .step-label {
    font-size: 0.85rem;
    font-weight: 500;
    color: #718096;
  }
  
  .step.active .step-label {
    color: #2d3748;
  }
  
  /* Étapes du formulaire */
  .form-step {
    display: none;
  }
  
  .form-step.active {
    display: block;
    animation: fadeIn 0.5s ease;
  }
  
  @keyframes fadeIn {
    from { opacity: 0; transform: translateY(10px); }
    to { opacity: 1; transform: translateY(0); }
  }
  
  .form-title {
    font-size: 1.5rem;
    font-weight: 600;
    color: #2d3748;
    margin-bottom: 0.5rem;
    text-align: center;
  }
  
  .form-subtitle {
    color: #718096;
    text-align: center;
    margin-bottom: 2rem;
  }
  
  /* Grille d'entrées */
  .input-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 1.5rem;
    margin-bottom: 1.5rem;
  }
  
  @media (max-width: 768px) {
    .input-grid {
      grid-template-columns: 1fr;
    }
  }
  
  .input-group {
    display: flex;
    flex-direction: column;
  }
  
  label {
    font-weight: 500;
    margin-bottom: 0.5rem;
    color: #4a5568;
  }
  
  input, select {
    padding: 0.75rem 1rem;
    border: 1px solid #e2e8f0;
    border-radius: 6px;
    font-size: 1rem;
    transition: all 0.2s ease;
  }
  
  input:focus, select:focus {
    outline: none;
    border-color: #4299e1;
    box-shadow: 0 0 0 3px rgba(66, 153, 225, 0.2);
  }
  
  input[readonly] {
    background-color: #f7fafc;
    color: #718096;
  }
  
  .styled-select {
    appearance: none;
    background-image: url("{{asset('assets/assets/img/logo pla.jpeg')}}");
    background-repeat: no-repeat;
    background-position: right 1rem center;
    background-size: 1rem;
  }
  
  /* Interface d'upload */
  .upload-options {
    display: flex;
    gap: 1rem;
    margin-bottom: 1rem;
  }
  
  .option-button {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.75rem 1rem;
    border: none;
    border-radius: 6px;
    font-weight: 500;
    cursor: pointer;
    transition: all 0.2s ease;
  }
  
  .camera-option {
    background-color: #48bb78;
    color: white;
  }
  
  .camera-option:hover {
    background-color: #38a169;
  }
  
  .upload-option {
    background-color: #4299e1;
    color: white;
  }
  
  .upload-option:hover {
    background-color: #3182ce;
  }
  
  .camera-container {
    display: none;
    flex-direction: column;
    align-items: center;
    margin: 1rem 0;
    padding: 1rem;
    border: 2px dashed #e2e8f0;
    border-radius: 8px;
  }
  
  #cameraPreview {
    width: 100%;
    max-width: 300px;
    background-color: #f7fafc;
    border-radius: 6px;
  }
  
  .camera-buttons {
    display: flex;
    gap: 1rem;
    margin-top: 1rem;
  }
  
  /* Boutons */
  .btn-primary, .btn-secondary, .btn-next, .btn-prev, .btn-submit {
    padding: 0.75rem 1.5rem;
    border: none;
    border-radius: 6px;
    font-weight: 500;
    cursor: pointer;
    transition: all 0.2s ease;
  }
  
  .btn-primary {
    background-color: #4299e1;
    color: white;
  }
  
  .btn-primary:hover {
    background-color: #3182ce;
  }
  
  .btn-secondary {
    background-color: #e2e8f0;
    color: #4a5568;
  }
  
  .btn-secondary:hover {
    background-color: #cbd5e0;
  }
  
  .btn-next, .btn-submit {
    background-color: #48bb78;
    color: white;
  }
  
  .btn-next:hover, .btn-submit:hover {
    background-color: #38a169;
  }
  
  .btn-prev {
    background-color: #e2e8f0;
    color: #4a5568;
  }
  
  .btn-prev:hover {
    background-color: #cbd5e0;
  }
  
  .form-navigation {
    display: flex;
    justify-content: space-between;
    margin-top: 2rem;
  }
  
  /* Prévisualisation de fichier */
  .file-preview-container {
    margin-top: 1rem;
  }
  
  .file-preview {
    max-width: 100%;
    max-height: 200px;
    display: none;
    border-radius: 6px;
    margin-top: 1rem;
  }
  
  .pdf-preview {
    display: none;
    padding: 1.5rem;
    background-color: #f7fafc;
    border-radius: 8px;
    text-align: center;
    margin-top: 1rem;
  }
  
  .icon-pdf {
    font-size: 2.5rem;
    color: #e53e3e;
    margin-bottom: 0.5rem;
  }
  
  /* Messages d'erreur */
  .error-message {
    color: #e53e3e;
    font-size: 0.875rem;
    margin-top: 0.5rem;
  }
  
  /* Icônes */
  .icon-camera:before {
    content: "📷";
  }
  
  .icon-upload:before {
    content: "📤";
  }
  
  .icon-pdf:before {
    content: "📄";
  }
</style>

<script>
  document.addEventListener('DOMContentLoaded', function() {
    // Gestion de la navigation entre les étapes
    const steps = document.querySelectorAll('.form-step');
    const progressFill = document.getElementById('progress-fill');
    let currentStep = 1;
    
    // Initialisation de la progression
    updateProgress();
    
    // Navigation suivante
    document.querySelectorAll('.btn-next').forEach(button => {
      button.addEventListener('click', function() {
        const nextStep = parseInt(this.getAttribute('data-next'));
        goToStep(nextStep);
      });
    });
    
    // Navigation précédente
    document.querySelectorAll('.btn-prev').forEach(button => {
      button.addEventListener('click', function() {
        const prevStep = parseInt(this.getAttribute('data-prev'));
        goToStep(prevStep);
      });
    });
    
    function goToStep(step) {
      // Masquer l'étape actuelle
      document.getElementById(`step-${currentStep}`).classList.remove('active');
      document.querySelector(`.step[data-step="${currentStep}"]`).classList.remove('active');
      
      // Afficher la nouvelle étape
      document.getElementById(`step-${step}`).classList.add('active');
      document.querySelector(`.step[data-step="${step}"]`).classList.add('active');
      
      currentStep = step;
      updateProgress();
    }
    
    function updateProgress() {
      const progress = ((currentStep - 1) / (steps.length - 1)) * 100;
      progressFill.style.width = `${progress}%`;
    }
    
    // Gestion de la caméra et de l'upload de fichiers
    const takePhotoBtn = document.getElementById('takePhotoBtn');
    const uploadFileBtn = document.getElementById('uploadFileBtn');
    const cameraContainer = document.getElementById('cameraContainer');
    const cameraPreview = document.getElementById('cameraPreview');
    const captureBtn = document.getElementById('captureBtn');
    const cancelCameraBtn = document.getElementById('cancelCameraBtn');
    const fileInput = document.getElementById('fileInput');
    const imagePreview = document.getElementById('imagePreview');
    const pdfPreview = document.getElementById('pdfPreview');
    
    let stream = null;
    
    // Prendre une photo
    takePhotoBtn.addEventListener('click', function() {
      if (!navigator.mediaDevices || !navigator.mediaDevices.getUserMedia) {
        alert("Votre navigateur ne supporte pas l'accès à la caméra.");
        return;
      }
      
      cameraContainer.style.display = 'flex';
      uploadFileBtn.style.display = 'none';
      takePhotoBtn.style.display = 'none';
      
      navigator.mediaDevices.getUserMedia({ video: true, audio: false })
        .then(function(mediaStream) {
          stream = mediaStream;
          cameraPreview.srcObject = mediaStream;
        })
        .catch(function(error) {
          console.error("Erreur d'accès à la caméra:", error);
          alert("Impossible d'accéder à la caméra: " + error.message);
          resetCameraUI();
        });
    });
    
    // Capturer une photo
    captureBtn.addEventListener('click', function() {
      const canvas = document.createElement('canvas');
      canvas.width = cameraPreview.videoWidth;
      canvas.height = cameraPreview.videoHeight;
      const context = canvas.getContext('2d');
      context.drawImage(cameraPreview, 0, 0, canvas.width, canvas.height);
      
      // Convertir l'image en blob
      canvas.toBlob(function(blob) {
        // Créer un fichier à partir du blob
        const file = new File([blob], 'cni_photo.jpg', { type: 'image/jpeg' });
        
        // Créer un DataTransfer pour définir le fichier sur l'input
        const dataTransfer = new DataTransfer();
        dataTransfer.items.add(file);
        fileInput.files = dataTransfer.files;
        
        // Afficher l'aperçu
        imagePreview.src = URL.createObjectURL(blob);
        imagePreview.style.display = 'block';
        pdfPreview.style.display = 'none';
        
        // Fermer la caméra
        closeCamera();
        resetCameraUI();
      }, 'image/jpeg', 0.8);
    });
    
    // Annuler la capture photo
    cancelCameraBtn.addEventListener('click', function() {
      closeCamera();
      resetCameraUI();
    });
    
    function closeCamera() {
      if (stream) {
        stream.getTracks().forEach(track => track.stop());
        stream = null;
      }
      cameraContainer.style.display = 'none';
    }
    
    function resetCameraUI() {
      uploadFileBtn.style.display = 'block';
      takePhotoBtn.style.display = 'block';
      cameraContainer.style.display = 'none';
    }
    
    // Télécharger un fichier
    uploadFileBtn.addEventListener('click', function() {
      fileInput.click();
    });
    
    // Aperçu du fichier sélectionné
    fileInput.addEventListener('change', function() {
      if (this.files && this.files[0]) {
        const file = this.files[0];
        
        if (file.type === 'application/pdf') {
          // Fichier PDF
          pdfPreview.style.display = 'block';
          imagePreview.style.display = 'none';
        } else if (file.type.startsWith('image/')) {
          // Fichier image
          const reader = new FileReader();
          reader.onload = function(e) {
            imagePreview.src = e.target.result;
            imagePreview.style.display = 'block';
            pdfPreview.style.display = 'none';
          };
          reader.readAsDataURL(file);
        }
      }
    });
    
    // Gestion des champs pour les enfants
    const nombreEnfantsSelect = document.getElementById('nombre_enfants');
    const champsEnfantsDiv = document.getElementById('champs_enfants');
    
    function genererChampsEnfants(nombre) {
      champsEnfantsDiv.innerHTML = ''; // Effacer les champs précédents
      
      for (let i = 1; i <= nombre; i++) {
        const enfantDiv = document.createElement('div');
        enfantDiv.classList.add('enfant-section');
        enfantDiv.innerHTML = `
          <h3 class="enfant-title">Enfant ${i}</h3>
          <div class="input-grid">
            <div class="input-group">
              <label for="DateNaissance_enfant_${i}">Date de naissance <span style="color:red">*</span></label>
              <input type="date" id="DateNaissance_enfant_${i}" name="DateNaissance_enfant_${i}" />
            </div>
            <div class="input-group">
              <label for="sexe_enfant_${i}">Sexe <span style="color:red">*</span></label>
              <select id="sexe_enfant_${i}" name="sexe_enfant_${i}" class="styled-select">
                <option value="" disabled selected>Choisissez le sexe</option>
                <option value="masculin">Masculin</option>
                <option value="feminin">Féminin</option>
              </select>
            </div>
          </div>
        `;
        champsEnfantsDiv.appendChild(enfantDiv);
      }
    }
    
    // Générer les champs initialement pour 1 enfant (par défaut)
    genererChampsEnfants(1);
    
    nombreEnfantsSelect.addEventListener('change', function() {
      genererChampsEnfants(parseInt(nombreEnfantsSelect.value));
    });
  });
</script>
@endsection
