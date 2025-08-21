@extends('doctor.layouts.template')

@section('content')
<div class="modern-form-container">
  <div class="form-wrapper">
    <form id="deathDeclarationForm" action="{{ route('statement.store.death') }}" method="POST">
      @csrf
      @method('POST')
      
      <!-- Barre de progression -->
      <div class="progress-container">
        <div class="progress-bar">
          <div class="progress-fill" id="progress-fill"></div>
        </div>
        <div class="progress-steps">
          <div class="step active" data-step="1">
            <div class="step-icon">👤</div>
            <span class="step-label">Défunt</span>
          </div>
          <div class="step" data-step="2">
            <div class="step-icon">📍</div>
            <span class="step-label">Lieu</span>
          </div>
          <div class="step" data-step="3">
            <div class="step-icon">📋</div>
            <span class="step-label">Finalisation</span>
          </div>
        </div>
      </div>

      <!-- Étape 1: Informations sur le défunt -->
      <div class="form-step active" id="step-1">
        <div class="form-header">
          <h2 class="form-title">Déclaration de décès</h2>
          <p class="form-subtitle">Informations sur le défunt</p>
        </div>

        <div class="input-grid">
          <div class="input-group">
            <label for="nomM">Nom du défunt <span class="required">*</span></label>
            <input type="text" id="nomM" name="NomM" placeholder="Entrez le nom du défunt" required />
            @error('NomM')
            <div class="error-message">{{ $message }}</div>
            @enderror
          </div>

          <div class="input-group">
            <label for="prM">Prénom du défunt <span class="required">*</span></label>
            <input type="text" id="prM" name="PrM" placeholder="Entrez le prénom du défunt" required />
            @error('PrM')
            <div class="error-message">{{ $message }}</div>
            @enderror
          </div>
        </div>

        <div class="input-grid">
          <div class="input-group">
            <label for="dateNaissance">Date de naissance <span class="required">*</span></label>
            <input type="date" id="dateNaissance" name="DateNaissance" required />
            @error('DateNaissance')
            <div class="error-message">{{ $message }}</div>
            @enderror
          </div>

          <div class="input-group">
            <label for="dateDeces">Date du décès <span class="required">*</span></label>
            <input type="date" id="dateDeces" name="DateDeces" required />
            @error('DateDeces')
            <div class="error-message">{{ $message }}</div>
            @enderror
          </div>
        </div>

        <div class="form-navigation">
          <div></div> <!-- Empty div for spacing -->
          <button type="button" class="btn-next" data-next="2">
            Suivant
            <span class="icon">→</span>
          </button>
        </div>
      </div>

      <!-- Étape 2: Lieu du décès -->
      <div class="form-step" id="step-2">
        <div class="form-header">
          <h2 class="form-title">Lieu du décès</h2>
          <p class="form-subtitle">Indiquez où le décès a eu lieu</p>
        </div>

        <div class="form-section">
          <h3 class="section-title">
            <span class="icon">📍</span>
            Où le décès a-t-il eu lieu ?
          </h3>
          
          <div class="radio-group">
            <div class="radio-option">
              <input type="radio" id="choixa" name="choix" value="à" checked />
              <label for="choixa">
                <span class="radio-icon">🏥</span>
                <div class="radio-content">
                  <span class="radio-label">À l'hôpital</span>
                  <span class="radio-description">Le décès est survenu dans cet établissement</span>
                </div>
              </label>
            </div>
            
            <div class="radio-option">
              <input type="radio" id="choixhors" name="choix" value="hors" />
              <label for="choixhors">
                <span class="radio-icon">🏠</span>
                <div class="radio-content">
                  <span class="radio-label">Hors de l'hôpital</span>
                  <span class="radio-description">Le décès est survenu en dehors de cet établissement</span>
                </div>
              </label>
            </div>
          </div>
        </div>

        <div class="form-navigation">
          <button type="button" class="btn-prev" data-prev="1">
            <span class="icon">←</span>
            Retour
          </button>
          <button type="button" class="btn-next" data-next="3">
            Suivant
            <span class="icon">→</span>
          </button>
        </div>
      </div>

      <!-- Étape 3: Circonstances et finalisation -->
      <div class="form-step" id="step-3">
        <div class="form-header">
          <h2 class="form-title">Circonstances du décès</h2>
          <p class="form-subtitle">Décrivez les circonstances et finalisez la déclaration</p>
        </div>

        <div class="form-section">
          <h3 class="section-title">
            <span class="icon">📝</span>
            Circonstances du décès
          </h3>
          
          <div class="input-group">
            <label for="remarques">Description des circonstances <span class="required">*</span></label>
            <textarea id="remarques" name="Remarques" rows="4" placeholder="Décrivez brièvement les circonstances du décès..." required></textarea>
            @error('Remarques')
            <div class="error-message">{{ $message }}</div>
            @enderror
          </div>
        </div>

        <div class="form-section">
          <h3 class="section-title">
            <span class="icon">🏥</span>
            Informations de l'établissement
          </h3>
          
          <div class="input-grid">
            <div class="input-group">
              <label for="nomHop">Nom de l'hôpital</label>
              <input type="text" id="nomHop" name="nomHop" value="{{ Auth::guard('doctor')->user()->nomHop }}" readonly />
            </div>

            <div class="input-group">
              <label for="commune">Commune</label>
              <input type="text" id="commune" name="commune" value="{{ Auth::guard('doctor')->user()->commune }}" readonly />
            </div>
          </div>
        </div>

        <div class="summary-card">
          <h3 class="summary-title">Récapitulatif</h3>
          <div class="summary-content">
            <div class="summary-item">
              <span class="summary-label">Défunt:</span>
              <span id="summary-name" class="summary-value">-</span>
            </div>
            <div class="summary-item">
              <span class="summary-label">Date de naissance:</span>
              <span id="summary-birth" class="summary-value">-</span>
            </div>
            <div class="summary-item">
              <span class="summary-label">Date de décès:</span>
              <span id="summary-death" class="summary-value">-</span>
            </div>
            <div class="summary-item">
              <span class="summary-label">Lieu:</span>
              <span id="summary-location" class="summary-value">À l'hôpital</span>
            </div>
          </div>
        </div>

        <div class="form-navigation">
          <button type="button" class="btn-prev" data-prev="2">
            <span class="icon">←</span>
            Retour
          </button>
          <button type="submit" class="btn-submit">
            <span class="icon">✓</span>
            Déclarer le décès
          </button>
        </div>
      </div>
    </form>
  </div>
</div>

<style>
  /* Styles modernes pour le formulaire */
  .modern-form-container {
    padding: 2rem;
    font-family: 'Montserrat', 'Segoe UI', sans-serif;
    background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
    min-height: 100vh;
    display: flex;
    align-items: center;
    justify-content: center;
  }
  
  .form-wrapper {
    width: 100%;
    max-width: 80%;
    background: white;
    border-radius: 16px;
    box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
    padding: 2.5rem;
    margin: 1rem;
  }
  
  /* Barre de progression */
  .progress-container {
    margin-bottom: 2.5rem;
    position: relative;
  }
  
  .progress-bar {
    height: 8px;
    background-color: #e2e8f0;
    border-radius: 4px;
    position: absolute;
    top: 24px;
    left: 0;
    right: 0;
    z-index: 1;
  }
  
  .progress-fill {
    height: 100%;
    background: linear-gradient(90deg, #4299e1 0%, #3182ce 100%);
    border-radius: 4px;
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
    flex: 1;
  }
  
  .step:not(:last-child):after {
    content: '';
    position: absolute;
    top: 20px;
    right: -50%;
    width: 100%;
    height: 2px;
    background-color: #e2e8f0;
    z-index: -1;
  }
  
  .step-icon {
    width: 48px;
    height: 48px;
    border-radius: 50%;
    background-color: white;
    border: 3px solid #e2e8f0;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.2rem;
    margin-bottom: 0.75rem;
    transition: all 0.3s ease;
  }
  
  .step.active .step-icon {
    border-color: #4299e1;
    background-color: #4299e1;
    color: white;
    box-shadow: 0 4px 10px rgba(66, 153, 225, 0.3);
  }
  
  .step-label {
    font-size: 0.9rem;
    font-weight: 600;
    color: #a0aec0;
    text-align: center;
    transition: all 0.3s ease;
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
    from { opacity: 0; transform: translateY(15px); }
    to { opacity: 1; transform: translateY(0); }
  }
  
  /* En-tête du formulaire */
  .form-header {
    text-align: center;
    margin-bottom: 2rem;
  }
  
  .form-title {
    font-size: 1.8rem;
    font-weight: 700;
    color: #2d3748;
    margin-bottom: 0.5rem;
  }
  
  .form-subtitle {
    color: #718096;
    font-size: 1.05rem;
    margin-bottom: 1.5rem;
  }
  
  /* Grille d'entrées */
  .input-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 1.5rem;
    margin-bottom: 1.5rem;
  }
  
  @media (max-width: 640px) {
    .input-grid {
      grid-template-columns: 1fr;
    }
  }
  
  .input-group {
    display: flex;
    flex-direction: column;
  }
  
  label {
    font-weight: 600;
    margin-bottom: 0.5rem;
    color: #4a5568;
    font-size: 0.95rem;
    display: flex;
    align-items: center;
  }
  
  .required {
    color: #e53e3e;
    margin-left: 4px;
  }
  
  input, textarea, select {
    padding: 1rem;
    border: 2px solid #e2e8f0;
    border-radius: 10px;
    font-size: 1rem;
    font-family: 'Montserrat', sans-serif;
    transition: all 0.2s ease;
    background-color: white;
  }
  
  input:focus, textarea:focus, select:focus {
    outline: none;
    border-color: #4299e1;
    box-shadow: 0 0 0 4px rgba(66, 153, 225, 0.2);
  }
  
  input[readonly] {
    background-color: #f7fafc;
    color: #718096;
    cursor: not-allowed;
  }
  
  textarea {
    resize: vertical;
    min-height: 120px;
  }
  
  /* Sections du formulaire */
  .form-section {
    margin-bottom: 2rem;
    padding: 1.75rem;
    background-color: #f8fafc;
    border-radius: 12px;
    border-left: 5px solid #4299e1;
  }
  
  .section-title {
    display: flex;
    align-items: center;
    font-size: 1.25rem;
    font-weight: 600;
    color: #2d3748;
    margin-bottom: 1.5rem;
  }
  
  .section-title .icon {
    margin-right: 0.75rem;
    font-size: 1.5rem;
  }
  
  /* Boutons radio personnalisés */
  .radio-group {
    display: flex;
    flex-direction: column;
    gap: 1rem;
  }
  
  .radio-option {
    display: flex;
    align-items: center;
  }
  
  .radio-option input[type="radio"] {
    opacity: 0;
    position: absolute;
  }
  
  .radio-option label {
    display: flex;
    align-items: center;
    padding: 1.25rem;
    background-color: white;
    border: 2px solid #e2e8f0;
    border-radius: 12px;
    cursor: pointer;
    transition: all 0.2s ease;
    width: 100%;
    margin-bottom: 0;
  }
  
  .radio-option input[type="radio"]:checked + label {
    border-color: #4299e1;
    background-color: rgba(66, 153, 225, 0.05);
    box-shadow: 0 0 0 4px rgba(66, 153, 225, 0.1);
  }
  
  .radio-icon {
    font-size: 2rem;
    margin-right: 1rem;
  }
  
  .radio-content {
    display: flex;
    flex-direction: column;
  }
  
  .radio-label {
    font-weight: 600;
    color: #2d3748;
    font-size: 1.05rem;
    margin-bottom: 0.25rem;
  }
  
  .radio-description {
    color: #718096;
    font-size: 0.9rem;
  }
  
  /* Carte de récapitulatif */
  .summary-card {
    background: linear-gradient(135deg, #f8fafc 0%, #edf2f7 100%);
    border-radius: 12px;
    padding: 1.5rem;
    margin-bottom: 2rem;
    border: 1px solid #e2e8f0;
  }
  
  .summary-title {
    font-size: 1.2rem;
    font-weight: 600;
    color: #2d3748;
    margin-bottom: 1rem;
    padding-bottom: 0.5rem;
    border-bottom: 2px solid #4299e1;
  }
  
  .summary-content {
    display: flex;
    flex-direction: column;
    gap: 0.75rem;
  }
  
  .summary-item {
    display: flex;
    justify-content: space-between;
    align-items: center;
  }
  
  .summary-label {
    font-weight: 600;
    color: #4a5568;
  }
  
  .summary-value {
    color: #2d3748;
    font-weight: 500;
  }
  
  /* Navigation entre les étapes */
  .form-navigation {
    display: flex;
    justify-content: space-between;
    margin-top: 2rem;
  }
  
  .btn-prev, .btn-next, .btn-submit {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    padding: 1rem 1.75rem;
    border: none;
    border-radius: 10px;
    font-size: 1rem;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
    min-width: 140px;
  }
  
  .btn-prev {
    background-color: #f7fafc;
    color: #4a5568;
    border: 2px solid #e2e8f0;
  }
  
  .btn-prev:hover {
    background-color: #edf2f7;
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
  }
  
  .btn-next {
    background: linear-gradient(90deg, #4299e1 0%, #3182ce 100%);
    color: white;
  }
  
  .btn-next:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 16px rgba(66, 153, 225, 0.3);
  }
  
  .btn-submit {
    background: linear-gradient(90deg, #48bb78 0%, #38a169 100%);
    color: white;
  }
  
  .btn-submit:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 16px rgba(72, 187, 120, 0.3);
  }
  
  .icon {
    margin: 0 0.25rem;
    font-weight: bold;
  }
  
  /* Messages d'erreur */
  .error-message {
    color: #e53e3e;
    font-size: 0.875rem;
    margin-top: 0.5rem;
    font-weight: 500;
    display: flex;
    align-items: center;
  }
  
  .error-message:before {
    content: "⚠";
    margin-right: 0.5rem;
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
        // Validation de l'étape actuelle avant de passer à la suivante
        if (validateStep(currentStep)) {
          const nextStep = parseInt(this.getAttribute('data-next'));
          goToStep(nextStep);
          updateSummary(); // Mettre à jour le récapitulatif
        }
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
    
    function validateStep(step) {
      let isValid = true;
      
      if (step === 1) {
        // Validation de l'étape 1
        const requiredFields = document.querySelectorAll('#step-1 [required]');
        
        requiredFields.forEach(field => {
          if (!field.value.trim()) {
            isValid = false;
            field.style.borderColor = '#e53e3e';
            
            // Ajouter un message d'erreur s'il n'existe pas déjà
            if (!field.nextElementSibling || !field.nextElementSibling.classList.contains('error-message')) {
              const errorDiv = document.createElement('div');
              errorDiv.className = 'error-message';
              errorDiv.textContent = 'Ce champ est obligatoire';
              field.parentNode.insertBefore(errorDiv, field.nextSibling);
            }
          } else {
            field.style.borderColor = '#e2e8f0';
            // Supprimer le message d'erreur s'il existe
            if (field.nextElementSibling && field.nextElementSibling.classList.contains('error-message')) {
              field.nextElementSibling.remove();
            }
          }
        });
        
        // Validation des dates
        const birthDate = new Date(document.getElementById('dateNaissance').value);
        const deathDate = new Date(document.getElementById('dateDeces').value);
        const today = new Date();
        
        if (birthDate && deathDate && deathDate < birthDate) {
          isValid = false;
          showNotification('La date de décès ne peut pas être antérieure à la date de naissance.', 'error');
        }
        
        if (deathDate && deathDate > today) {
          isValid = false;
          showNotification('La date de décès ne peut pas être dans le futur.', 'error');
        }
      }
      
      if (step === 3) {
        // Validation de l'étape 3
        const textarea = document.getElementById('remarques');
        if (!textarea.value.trim()) {
          isValid = false;
          textarea.style.borderColor = '#e53e3e';
          
          if (!textarea.nextElementSibling || !textarea.nextElementSibling.classList.contains('error-message')) {
            const errorDiv = document.createElement('div');
            errorDiv.className = 'error-message';
            errorDiv.textContent = 'Veuillez décrire les circonstances du décès';
            textarea.parentNode.insertBefore(errorDiv, textarea.nextSibling);
          }
        } else {
          textarea.style.borderColor = '#e2e8f0';
          if (textarea.nextElementSibling && textarea.nextElementSibling.classList.contains('error-message')) {
            textarea.nextElementSibling.remove();
          }
        }
      }
      
      if (!isValid) {
        // Animer les champs invalides
        const invalidFields = document.querySelectorAll(`#step-${step} [required]:invalid, #step-${step} .error-message`);
        invalidFields.forEach(field => {
          field.style.animation = 'shake 0.5s';
          setTimeout(() => {
            field.style.animation = '';
          }, 500);
        });
      }
      
      return isValid;
    }
    
    function updateSummary() {
      // Mettre à jour le récapitulatif avec les valeurs du formulaire
      document.getElementById('summary-name').textContent = 
        document.getElementById('nomM').value + ' ' + document.getElementById('prM').value;
      
      document.getElementById('summary-birth').textContent = 
        formatDate(document.getElementById('dateNaissance').value);
      
      document.getElementById('summary-death').textContent = 
        formatDate(document.getElementById('dateDeces').value);
      
      const location = document.querySelector('input[name="choix"]:checked').value;
      document.getElementById('summary-location').textContent = 
        location === 'à' ? 'À l\'hôpital' : 'Hors de l\'hôpital';
    }
    
    function formatDate(dateString) {
      if (!dateString) return '-';
      const date = new Date(dateString);
      return date.toLocaleDateString('fr-FR');
    }
    
    function showNotification(message, type) {
      // Créer une notification temporaire
      const notification = document.createElement('div');
      notification.className = `notification ${type}`;
      notification.textContent = message;
      notification.style.cssText = `
        position: fixed;
        top: 20px;
        right: 20px;
        padding: 1rem 1.5rem;
        border-radius: 8px;
        color: white;
        font-weight: 500;
        z-index: 1000;
        animation: slideIn 0.3s ease;
      `;
      
      if (type === 'error') {
        notification.style.backgroundColor = '#e53e3e';
      } else {
        notification.style.backgroundColor = '#48bb78';
      }
      
      document.body.appendChild(notification);
      
      setTimeout(() => {
        notification.style.animation = 'slideOut 0.3s ease';
        setTimeout(() => {
          document.body.removeChild(notification);
        }, 300);
      }, 3000);
    }
    
    // Validation à la soumission du formulaire
    const form = document.getElementById('deathDeclarationForm');
    
    form.addEventListener('submit', function(event) {
      if (!validateStep(1) || !validateStep(2) || !validateStep(3)) {
        event.preventDefault();
        // Aller à la première étape avec des erreurs
        if (!validateStep(1)) goToStep(1);
        else if (!validateStep(2)) goToStep(2);
        else if (!validateStep(3)) goToStep(3);
        
        showNotification('Veuillez corriger les erreurs dans le formulaire avant de soumettre.', 'error');
      }
    });
    
    // Ajouter une animation de secousse pour les champs invalides
    const style = document.createElement('style');
    style.textContent = `
      @keyframes shake {
        0%, 100% { transform: translateX(0); }
        25% { transform: translateX(-5px); }
        75% { transform: translateX(5px); }
      }
      @keyframes slideIn {
        from { transform: translateX(100%); opacity: 0; }
        to { transform: translateX(0); opacity: 1; }
      }
      @keyframes slideOut {
        from { transform: translateX(0); opacity: 1; }
        to { transform: translateX(100%); opacity: 0; }
      }
    `;
    document.head.appendChild(style);
    
    // Mettre à jour le récapitulatif lorsque les valeurs changent
    document.getElementById('nomM').addEventListener('input', updateSummary);
    document.getElementById('prM').addEventListener('input', updateSummary);
    document.getElementById('dateNaissance').addEventListener('change', updateSummary);
    document.getElementById('dateDeces').addEventListener('change', updateSummary);
    document.querySelectorAll('input[name="choix"]').forEach(radio => {
      radio.addEventListener('change', updateSummary);
    });
  });
</script>
@endsection