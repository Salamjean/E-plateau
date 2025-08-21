<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="Style.css">
    <link rel="icon" href="{{ asset('assets/images/profiles/E-ci-logo.png') }}">
    <title>Define access hospital</title>
</head>
<style>
  body {
      background-color: #f4f6f9;
      display: flex;
      align-items: center;
      justify-content: center;
      background-image: url({{ asset('assets/assets/img/bavk.jpg') }});
      background-size: cover;
      height: 100vh;
      margin: 0;
      font-family: Arial, sans-serif;
  }

  .form {
      background: linear-gradient(145deg, #ffffff, #e6e6e6);
      border-radius: 15px;
      box-shadow: 0px 8px 20px rgba(0, 0, 0, 0.15);
      padding: 10px 40px;
      width: 100%;
      max-width: 400px;
      transition: transform 0.2s;
  }

  .form:hover {
      transform: translateY(-5px);
  }

  h2 {
      text-align: center;
      color: red;
      font-size: 2rem;
      margin-bottom: 20px;
  }

  .inputForm {
      position: relative;
      margin-bottom: 20px;
  }

  .inputForm input {
      border: 1px solid #ced4da;
      border-radius: 10px;
      padding: 12px;
      width: 91%;
      font-size: 1rem;
      box-shadow: inset 0px 2px 5px rgba(0, 0, 0, 0.05);
      transition: border-color 0.3s, box-shadow 0.3s;
  }

  .inputForm input:focus {
      border-color: #007bff;
      box-shadow: 0px 0px 10px rgba(0, 123, 255, 0.2);
      outline: none;
  }

  .inputForm svg {
      position: absolute;
      left: 12px;
      top: 50%;
      transform: translateY(-50%);
      color: #aaa;
  }

  .inputForm input {
      padding-left: 40px;
  }

  .button-submit {
      background: linear-gradient(90deg, #007bff, #0056b3);
      border: none;
      padding: 15px;
      width: 100%;
      color: #fff;
      font-size: 1.2rem;
      cursor: pointer;
      transition: background 0.3s, transform 0.2s;
      border-radius: 10px;
  }

  .button-submit:hover {
      background: linear-gradient(90deg, #0056b3, #00408a);
      transform: translateY(-3px);
  }

  .text-danger {
      color: red;
      text-align: center;
  }

  .flex-column {
      margin-bottom: 10px;
      font-weight: bold;
  }

  .flex-row {
      display: flex;
      justify-content: space-between;
  }



</style>
<body>

   
    
    <form class="form" method="POST" enctype="multipart/form-data" action="{{ route('hopital.validate', $email) }}">
        <h2 style="text-align: center; color:black">Definissez vos access</h2>
        
        @method('post')
        @csrf

        @if (Session::get('success'))
        <div style="background-color:lightgreen; text-align:center ">
            {{ Session::get('success') }}
        </div>
        @endif
        @if (Session::get('error'))
        <div style="background-color:#f86750; text-align:center ">
            {{ Session::get('error') }}
        </div>
        @endif

      <div class="flex-column">
        <label>Email </label>
      </div>
      <div class="inputForm">
        
        <input style="background-color: rgb(233, 228, 228)" placeholder="Email@exemple.com" class="input" type="email" value="{{ $email }}" name="email" readonly/>
      </div>
      @error('email')
            <div class="text-danger" style="color: red; text-align:center">{{ $message }}</div>
        @enderror
      <div class="flex-column">
        <label>Code de validation </label>
      </div>
      <div class="inputForm">
        <input  class="input" type="text" value="{{ old('code') }}" name="code" />
        @error('code')
        <div class="text-danger" style="color: red; text-align:center">{{ $message }}</div>
    @enderror
      </div>
       
   
    
      <div class="flex-column">
        <label>Mot de passe </label>
      </div>
      <div class="inputForm">
       
          <path
            d="m336 512h-288c-26.453125 0-48-21.523438-48-48v-224c0-26.476562 21.546875-48 48-48h288c26.453125 0 48 21.523438 48 48v224c0 26.476562-21.546875 48-48 48zm-288-288c-8.8125 0-16 7.167969-16 16v224c0 8.832031 7.1875 16 16 16h288c8.8125 0 16-7.167969 16-16v-224c0-8.832031-7.1875-16-16-16zm0 0"
          ></path>
          <path
            d="m304 224c-8.832031 0-16-7.167969-16-16v-80c0-52.929688-43.070312-96-96-96s-96 43.070312-96 96v80c0 8.832031-7.167969 16-16 16s-16-7.167969-16-16v-80c0-70.59375 57.40625-128 128-128s128 57.40625 128 128v80c0 8.832031-7.167969 16-16 16zm0 0"
          ></path>
        </svg>
        <input placeholder="Entrez votre mot de passe" class="input" type="password" id="password" name="password" />
        @error('password')
            <div class="text-danger" style="color: red; text-align:center">{{ $message }}</div>
        @enderror
    </div>
      <div class="flex-column">
        <label>Confirmer Mot de passe </label>
      </div>
      <div class="inputForm">
       
          <path
            d="m336 512h-288c-26.453125 0-48-21.523438-48-48v-224c0-26.476562 21.546875-48 48-48h288c26.453125 0 48 21.523438 48 48v224c0 26.476562-21.546875 48-48 48zm-288-288c-8.8125 0-16 7.167969-16 16v224c0 8.832031 7.1875 16 16 16h288c8.8125 0 16-7.167969 16-16v-224c0-8.832031-7.1875-16-16-16zm0 0"
          ></path>
          <path
            d="m304 224c-8.832031 0-16-7.167969-16-16v-80c0-52.929688-43.070312-96-96-96s-96 43.070312-96 96v80c0 8.832031-7.167969 16-16 16s-16-7.167969-16-16v-80c0-70.59375 57.40625-128 128-128s128 57.40625 128 128v80c0 8.832031-7.167969 16-16 16zm0 0"
          ></path>
        </svg>
        <input placeholder="Confirmer votre mot de passe" class="input" type="password" id="password" name="confirme_password" />
        @error('confirme_password')
        <div class="text-danger" style="color: red; text-align:center">{{ $message }}</div>
    @enderror
    </div>
   

        <div class="flex-column">
            <label>Photo de Profil</label>
        
        <div class="inputForm">
            <input type="file" name="profile_picture" accept="image/*" class="input" />
            @error('profile_picture')
            <div class="text-danger" style="color: red; text-align:center">{{ $message }}</div>
            @enderror
        </div>
      </div>
      <button type="submit" class="button-submit" >Valider</button>
    </form>
    
    

</body>
</html>