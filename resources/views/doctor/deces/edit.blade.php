@extends('doctor.layouts.template')

@section('content')
<div class="content-container">
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="{{ asset('assets/hopitalCss/deceshops.css') }}">

<form id="msform" action="{{ route('statement.update.death', $deceshop->id) }}" method="POST">
  @csrf
  @method('PUT')
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
          <input type="text" id="nomM" name="NomM" placeholder="Entrez le nom du défunt" value="{{ $deceshop->NomM }}"  />
        </div>

        <div class="input-group">
          <label for="prM">Prénom du défunt</label>
          <input type="text" id="prM" name="PrM" placeholder="Entrez le prénom du défunt" value="{{ $deceshop->PrM }}"  />
        </div>
      </div>

      <div class="div">
        <div class="input-group">
          <label for="dateNaissance">Date de naissance du défunt</label>
          <input type="date" id="dateNaissance" name="DateNaissance" value="{{ $deceshop->DateNaissance }}"  />
        </div>

        <div class="input-group">
          <label for="dateDeces">Date du décès</label>
          <input type="date" id="dateDeces" name="DateDeces" value="{{ $deceshop->DateDeces }}"  />
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
        <textarea id="remarques" name="Remarques">{{ $deceshop->Remarques }}</textarea>
      </div>
      <div class="div">
          <div class="input-group">
            <input type="text" class="text-center" style="background-color:#e8e8e8" name="nomHop" value="{{ Auth::guard('doctor')->user()->nomHop }}" readonly/>
          </div>
          <div class="input-group">
            <input type="text" class="text-center" style="background-color:#e8e8e8" name="commune" value="{{ Auth::guard('doctor')->user()->commune }}" readonly/>
          </div>
        </div>
     

      <button type="submit" style="align-items:center; width:100%" class="action-button" >Mettre à jour</button>
    </fieldset>
  </form>
</div>
@endsection
