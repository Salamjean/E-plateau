<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="Style.css">
    <link rel="icon" href="{{ asset('assets/images/profiles/E-ci-logo.png') }}">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <title>Hospital login</title>
    <style>
        body {
            background-color: #f4f6f9;
            display: flex;
            align-items: center;
            background-image: url({{ asset('assets/images/profiles/doctorbg.jpg') }});
            justify-content: center;
            background-size: cover;
            height: 100vh;
            margin: 0;
            font-family: Arial, sans-serif;
        }

        .ms-panel {
            background: linear-gradient(145deg, #ffffff, #e6e6e6);
            border-radius: 15px;
            box-shadow: 0px 8px 20px rgba(0, 0, 0, 0.15);
            padding: 40px;
            width: 100%;
            max-width: 400px;
            transition: transform 0.2s;
        }

        .ms-panel:hover {
            transform: translateY(-5px);
        }

        .ms-panel-header h6 {
            text-align: center;
            font-size: 2rem;
            color: #333;
            margin-bottom: 20px;
        }

        .form-control {
            border: 1px solid #ced4da;
            border-radius: 10px;
            padding: 12px;
            width: 90%;
            font-size: 1rem;
            box-shadow: inset 0px 2px 5px rgba(0, 0, 0, 0.05);
            transition: border-color 0.3s, box-shadow 0.3s;
            margin-bottom:20px; 
        }

        .form-control:focus {
            border-color: #007bff;
            box-shadow: 0px 0px 10px rgba(0, 123, 255, 0.2);
            outline: none;
        }

        .input-group {
            position: relative;
        }

        .input-group i {
            position: absolute;
            left: 12px;
            top: 50%;
            transform: translateY(-50%);
            color: #aaa;
        }

        .input-group input {
            padding-left: 40px;
        }

        .btn-primary {
            border-radius: 10px;
            background: linear-gradient(90deg, #007bff, #0056b3);
            border: none;
            padding: 15px;
            width: 100%;
            color: #fff;
            font-size: 1.2rem;
            cursor: pointer;
            transition: background 0.3s, transform 0.2s;
        }

        .btn-primary:hover {
            background: linear-gradient(90deg, #0056b3, #00408a);
            transform: translateY(-3px);
        }

        .text-danger {
            color: red;
            text-align: center;
        }

        .ms-panel-body p {
            text-align: center;
            color: #666;
            margin-top: 15px;
        }

        .ms-panel-body a {
            color: #007bff;
            text-decoration: none;
            font-weight: bold;
        }

        .ms-panel-body a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="col-xl-6 col-md-12">
        <div class="ms-panel ms-panel-fh">
            <div class="ms-panel-header">
                <h6>Connexion - Hôpital</h6>
            </div>
            <div class="ms-panel-body">
                <form class="needs-validation" method="POST" action="{{ route('hopital.handleLogin') }}" novalidate>
                    @csrf
                    @method('post')

                    <div class="row" style="width:100%; justify-content:center">
                      @if (Session::get('success1')) <!-- Pour la suppression -->
                          <script>
                              Swal.fire({
                                  icon: 'success',
                                  title: 'Suppression réussie',
                                  text: '{{ Session::get('success1') }}',
                                  timer: 3000,
                                  showConfirmButton: false,
                                  color: '#b30000' // Texte rouge foncé
                              });
                          </script>
                      @endif
                  
                      @if (Session::get('success')) <!-- Pour la modification -->
                          <script>
                              Swal.fire({
                                  icon: 'success',
                                  title: 'Action réussie',
                                  text: '{{ Session::get('success') }}',
                                  timer: 3000,
                                  showConfirmButton: true,
                                  color: '#006600' // Texte vert foncé
                              });
                          </script>
                      @endif
                  
                      @if (Session::get('error')) <!-- Pour une erreur générale -->
                          <script>
                              Swal.fire({
                                  icon: 'error',
                                  title: 'Erreur',
                                  text: '{{ Session::get('error') }}',
                                  timer: 3000,
                                  showConfirmButton: false,
                                  color: '#ffffff' // Texte blanc
                              });
                          </script>
                      @endif
                  </div>

                    <div class="form-row">
                        <div class="col-md-12 mb-3">
                            <label for="validationCustom008">Email</label>
                            <div class="input-group">
                                <i class="fas fa-envelope"></i>
                                <input type="email" class="form-control" id="validationCustom008" placeholder="Entrez votre adresse mail..." name="email" value="{{ old('email') }}" required>
                            </div>
                            @error('email')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-12 mb-3">
                            <label for="validationCustom009">Mot de passe</label>
                            <div class="input-group">
                                <i class="fas fa-lock"></i>
                                <input type="password" class="form-control" id="validationCustom009" placeholder="Entrez votre mot de passe..." name="password" required>
                            </div>
                            @error('password')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <button class="btn btn-primary mt-4 d-block w-100" type="submit">Connexion</button>
                </form>
            </div>
        </div>
    </div>

    <script src="https://kit.fontawesome.com/a076d05399.js"></script>
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
