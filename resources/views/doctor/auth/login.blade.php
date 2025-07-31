<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="Style.css">
    <link rel="icon" href="{{ asset('assets/images/profiles/E-ci-logo.png') }}">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <title>Doctor - login</title>
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
      padding: 10px 40px 50px 40px;
      width: 100%;
      max-width: 400px;
      transition: transform 0.2s;
  }

  .form:hover {
      transform: translateY(-5px);
  }

  h2 {
      text-align: center;
      color: black;
      font-size: 2rem;
      margin-bottom: 20px;
  }

  .inputForm {
      position: relative;
      margin-bottom: 30px;
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

   
    
  <form class="form" method="POST" action="{{ route('doctor.handleLogin') }}">
    <h2>Connexion d'un Docteur</h2>

    @method('post')
    @csrf
    <div class="row" style="width:100%; justify-content:center">
        @if (Session::get('success1'))
            <script>
                Swal.fire({
                    icon: 'success',
                    title: 'Suppression réussie',
                    text: '{{ Session::get('success1') }}',
                    showConfirmButton: true,
                    color: '#b30000'
                });
            </script>
        @endif

        @if (Session::get('success'))
            <script>
                Swal.fire({
                    icon: 'success',
                    title: 'Action réussie',
                    text: '{{ Session::get('success') }}',
                    showConfirmButton: true,
                    color: '#006600'
                });
            </script>
        @endif

        @if (Session::get('error'))
            <script>
                Swal.fire({
                    icon: 'error',
                    title: 'Erreur',
                    text: '{{ Session::get('error') }}',
                    showConfirmButton: true,
                    color: 'red'
                });
            </script>
        @endif
    </div>

    <div class="flex-column">
        <label>Email</label>
    </div>
    <div class="inputForm">
        <svg xmlns="http://www.w3.org/2000/svg" width="20" viewBox="0 0 32 32" height="20">
            <g data-name="Layer 3" id="Layer_3">
                <path
                    d="m30.853 13.87a15 15 0 0 0 -29.729 4.082 15.1 15.1 0 0 0 12.876 12.918 15.6 15.6 0 0 0 2.016.13 14.85 14.85 0 0 0 7.715-2.145 1 1 0 1 0 -1.031-1.711 13.007 13.007 0 1 1 5.458-6.529 2.149 2.149 0 0 1 -4.158-.759v-10.856a1 1 0 0 0 -2 0v1.726a8 8 0 1 0 .2 10.325 4.135 4.135 0 0 0 7.83.274 15.2 15.2 0 0 0 .823-7.455zm-14.853 8.13a6 6 0 1 1 6-6 6.006 6.006 0 0 1 -6 6z"
                ></path>
            </g>
        </svg>
        <input placeholder="Email@exemple.com" class="input" type="email" value="{{ old('email') }}" name="email"/>
        @error('email')
            <div class="text-danger" style="color: red; text-align:center">{{ $message }}</div>
        @enderror
    </div>

    <div class="flex-column">
        <label>Mot de passe</label>
    </div>
    <div class="inputForm">
        <input placeholder="Entrez votre mot de passe" class="input" type="password" id="password" name="password" />
    </div>
    @error('password')
        <div class="text-danger" style="color: red; text-align:center">{{ $message }}</div>
    @enderror

    <button class="button-submit">Se connecter</button>
    
</form>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        @if (Session::get('success'))
            showMessage('{{ Session::get('success') }}', 'lightgreen');
        @endif
        @if (Session::get('success1'))
            showMessage('{{ Session::get('success1') }}', 'lightred');
        @endif

        @if (Session::get('error'))
            showMessage('{{ Session::get('error') }}', '#f86750');
        @endif
    });

    function showMessage(message, backgroundColor) {
        const popup = document.getElementById('popup-message');
        popup.textContent = message;
        popup.style.backgroundColor = backgroundColor;
        popup.style.display = 'block';

        setTimeout(() => {
            popup.style.display = 'none';
        }, 3000); // Masquer après 3 secondes
    }
</script>
</body>
</html>