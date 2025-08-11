@extends('doctor.layouts.template')

@section('content')
<div class="content-container">
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="{{ asset('assets/hopitalCss/deceshops.css') }}">
<form id="msform" action="{{ route('statement.store.death') }}" method="POST">
    @csrf
    @method('POST')
    <!-- Form Header -->
    <div class="form-header">
      <h2>Déclaration de décès</h2>
      <p>Veuillez remplir les informations requises</p>
    </div>

    <!-- Input Fields -->
    <fieldset>
      <div class="div">
        <div class="input-group">
          <label for="nomM">Nom du défunt</label>
          <input type="text" id="nomM" name="NomM" placeholder="Entrez le nom du défunt" required />
        </div>

        <div class="input-group">
          <label for="prM">Prénom du défunt</label>
          <input type="text" id="prM" name="PrM" placeholder="Entrez le prénom du défunt" required />
        </div>
      </div>

      <div class="div">
        <div class="input-group">
          <label for="dateNaissance">Date de naissance du défunt</label>
          <input type="date" id="dateNaissance" name="DateNaissance" required />
        </div>

        <div class="input-group">
          <label for="dateDeces">Date du décès</label>
          <input type="date" id="dateDeces" name="DateDeces" id="dateDeces"  required />

        </div>
      </div>
      <div class="div">
        <div class="input-group">
          <label for="choixa" class="text-center mb-3" style="font-size: 15px; font-weight:bold">Décès subvenu à l'hôpital</label>
          <input type="radio" id="choixa" name="choix" value="à" checked style="transform: scale(1.5);"/>
        </div>
        <div class="input-group">
          <label for="choixhors" class="text-center mb-3"  style="font-size: 15px; font-weight:bold">Décès subvenu hors l'hôpital</label>
          <input type="radio" id="choixhors" name="choix" id="dateDeces" value="hors" style="transform: scale(1.5);"  />
        </div>
      </div>
      
        <div class="input-group">
          <label for="remarques">Décrivez les circonstances du décès</label>
          <textarea id="remarques" name="Remarques" required></textarea>
        </div>
        <div class="div">
          <div class="input-group">
            <input type="text" class="text-center" style="background-color:#e8e8e8" name="nomHop" value="{{ Auth::guard('doctor')->user()->nomHop }}" readonly/>
          </div>
          <div class="input-group">
            <input type="text" class="text-center" style="background-color:#e8e8e8" name="commune" value="{{ Auth::guard('doctor')->user()->commune }}" readonly/>
          </div>
        </div>

      <button type="submit" class="action-button" style="align-items:center; width:100%">Déclarer</button>
    </fieldset>
  </form>
</div>
@endsection
