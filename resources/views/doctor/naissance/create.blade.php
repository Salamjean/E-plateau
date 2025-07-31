@extends('doctor.layouts.template')

@section('content')

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Multi-step Form</title>
  <link rel="stylesheet" href="{{ asset('assets/hopitalCss/style_naisshop.css') }}">
</head>
<body>
  <form id="msform" action="{{ route('statement.store') }}" method="POST" enctype="multipart/form-data" > 
    @csrf
    <ul id="progressbar">
      <li class="active">Informations
        <br>sur la mère</li>
      <li>Informations
        <br>sur l'accompagnateur</li>
      <li>Informations du nouveau-né</li>
    </ul>

    <fieldset >
      <h2 class="fs-title">Déclaration de naissance</h2>
      <h3 class="fs-subtitle">Informations sur la mère</h3>
      <div class="form-group">
        <input type="text" name="NomM" placeholder="Entrez le nom de la mère" />
        @error('NomM')
        <div class="error-message">{{ $message }}</div>
        @enderror

        <input type="text" name="PrM" placeholder="Entrez le prénom de la mère" />
        @error('PrM')
        <div class="error-message">{{ $message }}</div>
        @enderror
      </div>
      <div style="display: flex; justify-content: space-around;">
        <label>Entrez la date de naissance de la mère</label>
        <label>Joindre copie CNI/passeport/extrait de la mère</label>
      </div>
      <div class="form-group">
        <input type="date" name="dateM" />
        @error('dateM')
        <div class="text-danger text-center">{{ $message }}</div>
        @enderror


        <input type="file" name="CNI_mere" />
        @error('CNI_mere')
        <div class="text-danger text-center">{{ $message }}</div>
        @enderror
      </div>
      <div class="form-group">
        <input type="text" name="contM" placeholder="Entrez le numéro de téléphone de la mère" ><br>
        @error('contM')
        <div class="text-danger text-center">{{ $message }}</div>
        @enderror
        <input type="text" name="codeCMU" placeholder="Entrez le numéro CMU de la mère" ><br>
        @error('CMU')
        <div class="text-danger text-center">{{ $message }}</div>
        @enderror
      </div>
      <input type="button" class="next action-button" value="Suivant" />
    </fieldset>

    <fieldset>
      <h2 class="fs-title">Déclaration de naissance</h2>
      <h3 class="fs-subtitle">Informations sur l'accompagnateur</h3>
      <div class="form-group">
        <input type="text" name="NomP" placeholder="Entrez le nom de l'accompagnateur" />
        @error('NomP')
        <div class="text-danger text-center">{{ $message }}</div>
        @enderror
        <input type="text" name="PrP" placeholder="Entrez le prénom l'accompagnateur" />
        @error('PrP')
        <div class="text-danger text-center">{{ $message }}</div>
        @enderror
      </div>
      <div class="form-group">
        <input type="text" name="contP" placeholder="Entrez le numéro l'accompagnateur"><br>
        @error('contP')
        <div class="text-danger text-center">{{ $message }}</div>
        @enderror
        <input type="text" name="CNI_Pere" placeholder="Entrez le numéro CNI/CMU/Passsport" />
        @error('CNI_Pere')
        <div class="text-danger text-center">{{ $message }}</div>
        @enderror
      </div>
      <input type="text" name="lien" placeholder="Entrez le lien parental" />
      @error('lien')
      <div class="text-danger text-center">{{ $message }}</div>
      @enderror
      <input type="button" class="previous action-button" value="Retour" />
      <input type="button" class="next action-button" value="Suivant" />
    </fieldset>

    <fieldset >
      <h2 class="fs-title">Informations du nouveau-né</h2>
      <h3 class="fs-subtitle">Complétez les informations du bébé</h3>
      <input type="text" class="text-center" style="background-color:#e8e8e8" name="NomEnf" value="{{ Auth::guard('doctor')->user()->nomHop }}" readonly/>
      <input type="text" class="text-center" style="background-color:#e8e8e8" name="commune" value="{{ Auth::guard('doctor')->user()->commune }}" readonly/>

      <label for="nombre_enfants">Nombre d'enfant(s) né(s) :</label>
      <div class="form-group">
        <select name="nombreEnf" id="nombre_enfants" class="text-center">
          <option value="1">1</option>
          <option value="2">2</option>
          <option value="3">3</option>
          <option value="4">4</option>
        </select>
        @error('nombreEnf')
            <div class="text-danger text-center">{{ $message }}</div>
        @enderror
      </div>

      <div id="champs_enfants">
          </div>

      <input type="button"  class="previous action-button" value="Retour" />
      <input type="submit" class="next action-button" value="Valider" />
    </fieldset>
  </form>

  <script>
    document.addEventListener('DOMContentLoaded', function () {
      const nombreEnfantsSelect = document.getElementById('nombre_enfants');
      const champsEnfantsDiv = document.getElementById('champs_enfants');

      function genererChampsEnfants(nombre) {
        champsEnfantsDiv.innerHTML = ''; // Effacer les champs précédents
        for (let i = 1; i <= nombre; i++) {
          const enfantDiv = document.createElement('div');
          enfantDiv.classList.add('enfant-info'); // Classe pour styliser si besoin
          enfantDiv.innerHTML = `
            <h3>Enfant ${i}</h3>
            <div class="form-group">
              <input type="date" class="text-center" name="DateNaissance_enfant_${i}" />
              @error('DateNaissance_enfant_${i}')
                  <div class="text-danger text-center">{{ $message }}</div>
              @enderror
            </div>
            <div class="form-group">
              <select class="text-center" name="sexe_enfant_${i}">
                <option value="" disabled selected>Choisissez le sexe</option>
                <option value="masculin">Masculin</option>
                <option value="feminin">Féminin</option>
              </select>
              @error('sexe_enfant_${i}')
                  <div class="text-danger text-center">{{ $message }}</div>
              @enderror
            </div>
          `;
          champsEnfantsDiv.appendChild(enfantDiv);
        }
      }

      // Générer les champs initialement pour 1 enfant (par défaut)
      genererChampsEnfants(1);

      nombreEnfantsSelect.addEventListener('change', function () {
        genererChampsEnfants(parseInt(nombreEnfantsSelect.value));
      });
    });
  </script>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script>
    $(document).ready(function () {
      // Navigation entre les étapes
      $(".next").click(function () {
        var current = $(this).parent();
        var next = $(this).parent().next();
        if (next.length) {
          current.fadeOut(500, function () {
            next.fadeIn(500);
          });
          $("#progressbar li").eq($("fieldset").index(next)).addClass("active");
        }
      });

      $(".previous").click(function () {
        var current = $(this).parent();
        var previous = $(this).parent().prev();
        if (previous.length) {
          current.fadeOut(500, function () {
            previous.fadeIn(500);
          });
          $("#progressbar li").eq($("fieldset").index(current)).removeClass("active");
        }
      });
    });
  </script>
</body>
</html>
@endsection
