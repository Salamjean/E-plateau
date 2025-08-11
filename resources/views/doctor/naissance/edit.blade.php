@extends('doctor.layouts.template')

@section('content')
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Modification déclaration de naissance</title>
  <link rel="stylesheet" href="{{ asset('assets/hopitalCss/style_naisshop.css') }}">
</head>
<body>
  <form id="msform" action="{{ route('statement.edit', $naisshop->id) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    <ul id="progressbar">
      <li class="active">Informations sur la mère</li>
      <li>Informations sur l'accompagnateur</li>
      <li>Informations du nouveau-né</li>
    </ul>

    <!-- Étape 1: Informations sur la mère -->
    <fieldset>
      <h2 class="fs-title">Modification déclaration</h2>
      <h3 class="fs-subtitle">Informations sur la mère</h3>
      
      <div class="form-group">
        <input type="text" name="NomM" placeholder="Nom de la mère" value="{{ old('NomM', $naisshop->NomM) }}" />
        @error('NomM')<div class="error-message">{{ $message }}</div>@enderror
        <input type="text" name="PrM" placeholder="Prénom de la mère" value="{{ old('PrM', $naisshop->PrM) }}" />
        @error('PrM')<div class="error-message">{{ $message }}</div>@enderror
      </div>
      
      <div style="display: flex; justify-content: space-around;">
        <label>Date de naissance de la mère</label>
        <label>CNI/passeport/extrait de la mère</label>
      </div>
      
      <div class="form-group">
        <input type="date" name="dateM" value="{{ old('dateM', $naisshop->dateM) }}" />
        @error('dateM')<div class="text-danger text-center">{{ $message }}</div>@enderror
        
        <input type="file" name="CNI_mere" />
        @error('CNI_mere')<div class="text-danger text-center">{{ $message }}</div>@enderror
      </div>
      
      <div class="form-group">
        <input type="text" name="contM" placeholder="Téléphone de la mère" value="{{ old('contM', $naisshop->contM) }}">
        @error('contM')<div class="text-danger text-center">{{ $message }}</div>@enderror
        
        <input type="text" name="codeCMU" placeholder="Numéro CMU de la mère" value="{{ old('codeCMU', $naisshop->codeCMU) }}">
        @error('codeCMU')<div class="text-danger text-center">{{ $message }}</div>@enderror
      </div>
      
      <input type="button" class="next action-button" value="Suivant" />
    </fieldset>

    <!-- Étape 2: Informations sur l'accompagnateur -->
    <fieldset>
      <h2 class="fs-title">Modification déclaration</h2>
      <h3 class="fs-subtitle">Informations sur l'accompagnateur</h3>
      
      <div class="form-group"> 
        <input type="text" name="NomP" placeholder="Nom de l'accompagnateur" value="{{ old('NomP', $naisshop->NomP) }}"/>
        @error('NomP')<div class="text-danger text-center">{{ $message }}</div>@enderror
        
        <input type="text" name="PrP" placeholder="Prénom de l'accompagnateur" value="{{ old('PrP', $naisshop->PrP) }}"/>
        @error('PrP')<div class="text-danger text-center">{{ $message }}</div>@enderror
      </div>
      
      <div class="form-group">
        <input type="text" name="contP" placeholder="Téléphone de l'accompagnateur" value="{{ old('contP', $naisshop->contP) }}">
        @error('contP')<div class="text-danger text-center">{{ $message }}</div>@enderror
        
        <input type="text" name="CNI_Pere" placeholder="CNI/CMU/Passport" value="{{ old('CNI_Pere', $naisshop->CNI_Pere) }}" />
        @error('CNI_Pere')<div class="text-danger text-center">{{ $message }}</div>@enderror
      </div>
      
      <input type="text" name="lien" placeholder="Lien parental" value="{{ old('lien', $naisshop->lien) }}"/>
      @error('lien')<div class="text-danger text-center">{{ $message }}</div>@enderror
      
      <input type="button" class="previous action-button" value="Retour" />
      <input type="button" class="next action-button" value="Suivant" />
    </fieldset>

    <!-- Étape 3: Informations des enfants -->
    <fieldset>
      <h2 class="fs-title">Informations du nouveau-né</h2>
      <h3 class="fs-subtitle">Complétez les informations</h3>
      
      <input type="text" class="text-center" style="background-color:#e8e8e8" name="NomEnf" value="{{ Auth::guard('doctor')->user()->nomHop }}" readonly/>
      <input type="text" class="text-center" style="background-color:#e8e8e8" name="commune" value="{{ Auth::guard('doctor')->user()->commune }}" readonly/>
      
      <!-- Liste déroulante pour le nombre d'enfants -->
      <label for="nombre_enfants">Nombre d'enfant(s) né(s) :</label>
      <select name="nombreEnf" id="nombreEnf" class="form-control" required>
        <option value="" disabled selected>Sélectionnez le nombre d'enfants</option>
        @for($i = 1; $i <= 4; $i++)
          <option style="text-align:center" value="{{ $i }}" {{ $naisshop->enfants->count() == $i ? 'selected' : '' }}>{{ $i }}</option>
        @endfor
      </select>
      
      <!-- Conteneur pour les informations des enfants -->
      <div id="enfants-container">
        @foreach($naisshop->enfants as $index => $enfant)
        <div class="enfant-container" data-index="{{ $index + 1 }}">
          <div class="enfant-title">Enfant {{ $index + 1 }}</div>
          <input style="text-align:center" type="hidden" name="enfant_ids[]" value="{{ $enfant->id }}">
          
          <label>Date de naissance</label>
          <input style="text-align:center" type="date" class="form-control" name="DateNaissance_enfant_{{ $index + 1 }}" 
                 value="{{ $enfant->date_naissance }}" required>
          
          <label>Sexe</label>
          <select name="sexe_enfant_{{ $index + 1 }}" class="form-control" required>
            <option style="text-align:center" value="masculin" {{ $enfant->sexe == 'masculin' ? 'selected' : '' }}>Masculin</option>
            <option style="text-align:center" value="feminin" {{ $enfant->sexe == 'feminin' ? 'selected' : '' }}>Féminin</option>
          </select>
        </div>
        @endforeach
      </div>
      
      <input type="button" class="previous action-button" value="Retour" />
      <input type="submit" class="next action-button" value="Valider" />
    </fieldset>
  </form>

  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script>
    $(document).ready(function() {
      // Navigation entre les étapes
      $(".next").click(function() {
        var current = $(this).parent();
        var next = $(this).parent().next();
        if (next.length) {
          current.fadeOut(500, function() {
            next.fadeIn(500);
          });
          $("#progressbar li").eq($("fieldset").index(next)).addClass("active");
        }
      });

      $(".previous").click(function() {
        var current = $(this).parent();
        var previous = $(this).parent().prev();
        if (previous.length) {
          current.fadeOut(500, function() {
            previous.fadeIn(500);
          });
          $("#progressbar li").eq($("fieldset").index(current)).removeClass("active");
        }
      });

      // Gestion dynamique du nombre d'enfants
      $('#nombreEnf').on('change', function() {
        const nombreEnfants = parseInt($(this).val());
        const container = $('#enfants-container');
        const currentCount = container.children().length;
        
        if (nombreEnfants > currentCount) {
          // Ajouter des champs enfants
          for (let i = currentCount + 1; i <= nombreEnfants; i++) {
            container.append(`
              <div class="enfant-container" data-index="${i}">
                <div class="enfant-title">Enfant ${i}</div>
                <input type="hidden" name="enfant_ids[]" value="">
                
                <label>Date de naissance</label>
                <input type="date" class="form-control" name="DateNaissance_enfant_${i}" required>
                
                <label>Sexe</label>
                <select name="sexe_enfant_${i}" class="form-control" required>
                  <option value="masculin">Masculin</option>
                  <option value="feminin">Féminin</option>
                </select>
              </div>
            `);
          }
        } else if (nombreEnfants < currentCount) {
          // Supprimer des champs enfants
          container.children().slice(nombreEnfants).remove();
        }
      });
    });
  </script>
</body>
</html>
@endsection