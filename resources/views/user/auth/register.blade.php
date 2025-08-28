<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="shortcut icon" href="{{asset('assets/assets/img/logo pla.jpeg')}}" />
    <title>User register</title>
    <style>
        :root {
            --primary-color: #1977cc;
            --secondary-color: #1977cc;
            --accent-color: #4895ef;
            --error-color: #f72585;
            --success-color: #4cc9f0;
            --light-color: #f8f9fa;
            --dark-color: #212529;
            --transition-speed: 0.3s;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        body {
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            margin: 0;
            background: 
                linear-gradient(rgba(0, 0, 0, 0.2), rgba(0, 0, 0, 0.7)),
                url('{{ asset('assets/assets/img/bavk.jpg') }}');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            background-attachment: fixed;
            padding: 20px;
        }

        .register-container {
            display: flex;
            width: 100%;
            max-width: 900px;
            background-color: rgba(255, 255, 255, 0.95);
            border-radius: 16px;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
            overflow: hidden;
        }

        .left-column {
            flex: 1;
            padding: 40px;
            background: linear-gradient(to bottom right, var(--primary-color), var(--secondary-color));
            color: white;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .right-column {
            flex: 1;
            padding: 40px;
        }

        .form-header {
            text-align: center;
            margin-bottom: 30px;
        }

        .title {
            font-size: 2rem;
            font-weight: 700;
            color: white;
            margin-bottom: 10px;
        }

        .subtitle {
            color: rgba(255, 255, 255, 0.8);
            font-size: 0.9rem;
        }

        .welcome-message {
            margin-top: 30px;
            text-align: center;
        }

        .welcome-message h2 {
            font-size: 1.8rem;
            margin-bottom: 15px;
        }

        .welcome-message p {
            font-size: 1rem;
            line-height: 1.6;
            margin-bottom: 20px;
        }

        .login-btn {
            display: inline-block;
            margin-top: 20px;
            padding: 12px 30px;
            background: transparent;
            border: 2px solid white;
            color: white;
            font-size: 1rem;
            font-weight: 600;
            border-radius: 30px;
            cursor: pointer;
            transition: all var(--transition-speed) ease;
            text-align: center;
            text-decoration: none;
        }

        .login-btn:hover {
            background: white;
            color: var(--primary-color);
        }

        .input-group {
            position: relative;
            width: 100%;
            margin-bottom: 20px;
        }

        .input-icon {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: #adb5bd;
            transition: all var(--transition-speed) ease;
            z-index: 2;
        }

        .input-field {
            width: 100%;
            outline: none;
            border-radius: 10px;
            height: 50px;
            border: 2px solid #e9ecef;
            background: transparent;
            padding-left: 45px;
            padding-right: 15px;
            font-size: 1rem;
            transition: all var(--transition-speed) ease;
            color: var(--dark-color);
        }

        .input-field:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(67, 97, 238, 0.2);
        }

        .input-field:focus ~ .input-icon {
            color: var(--primary-color);
        }

        .input-label {
            position: absolute;
            top: 15px;
            left: 45px;
            color: #adb5bd;
            transition: all var(--transition-speed) ease;
            pointer-events: none;
            background-color: transparent;
            padding: 0 5px;
            z-index: 1;
        }

        .input-field:focus ~ .input-label,
        .input-field:not(:placeholder-shown) ~ .input-label {
            top: -10px;
            left: 35px;
            font-size: 0.8rem;
            color: var(--primary-color);
            background-color: white;
            z-index: 3;
        }

        .password-toggle {
            position: absolute;
            right: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: #adb5bd;
            cursor: pointer;
            transition: all var(--transition-speed) ease;
            z-index: 2;
        }

        .password-toggle:hover {
            color: var(--primary-color);
        }

        .submit-btn {
            margin-top: 20px;
            height: 55px;
            background: linear-gradient(to right, var(--primary-color), var(--secondary-color));
            border: none;
            outline: none;
            color: white;
            font-size: 1.1rem;
            font-weight: 600;
            border-radius: 12px;
            cursor: pointer;
            transition: all var(--transition-speed) ease;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            position: relative;
            overflow: hidden;
            width: 100%;
        }

        .submit-btn::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(to right, transparent, rgba(255, 255, 255, 0.2), transparent);
            transition: all 0.6s ease;
        }

        .submit-btn:hover {
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15);
            transform: translateY(-2px);
        }

        .submit-btn:hover::before {
            left: 100%;
        }

        .submit-btn:active {
            transform: translateY(0);
        }

        .error-message {
            color: var(--error-color);
            font-size: 0.85rem;
            margin-top: 5px;
            display: flex;
            align-items: center;
            gap: 5px;
            animation: fadeIn var(--transition-speed) ease;
        }

        .success-message {
            color: var(--success-color);
            text-align: center;
            margin-bottom: 15px;
            font-weight: 500;
            animation: fadeIn var(--transition-speed) ease;
        }

        .form-row {
            display: flex;
            gap: 15px;
        }

        .form-row .input-group {
            flex: 1;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-5px); }
            to { opacity: 1; transform: translateY(0); }
        }

        @media (max-width: 768px) {
            .register-container {
                flex-direction: column;
            }
            
            .left-column, .right-column {
                padding: 30px;
            }
            
            .left-column {
                order: 2;
                background: linear-gradient(to right, var(--primary-color), var(--secondary-color));
            }
            
            .right-column {
                order: 1;
            }
        }

        @media (max-width: 576px) {
            .form-row {
                flex-direction: column;
                gap: 0;
            }
            
            .title {
                font-size: 1.5rem;
            }
        }
    </style>
</head>
<body>
    <div class="register-container animate__animated animate__fadeIn">
        <!-- Colonne de gauche - Informations -->
        <div class="left-column">
            <div class="form-header">
                <img src="{{asset('assets/assets/img/logo plateau.png')}}" style="height: 80px; width:auto" alt="">
                <h1 class="title">Inscription</h1>
                <p class="subtitle">Créez votre compte pour accéder à la plateforme</p>
            </div>
            
            <div class="welcome-message">
                <h2>Bienvenue !</h2>
                <p>Rejoignez notre communauté et bénéficiez de tous nos services en créant un compte personnel.</p>
                <p>Déjà inscrit ? Connectez-vous pour accéder à votre espace.</p>
                <a href="{{route('login')}}" class="login-btn animate__animated animate__pulse animate__infinite animate__slower">
                    <i class="fas fa-sign-in-alt"></i> Se connecter
                </a>
            </div>
        </div>

        <!-- Colonne de droite - Formulaire -->
        <div class="right-column">
            <form method="POST" action="{{route('user.handleRegister')}}" enctype="multipart/form-data">
                @csrf

                @if (Session::get('success'))
                    <div class="success-message animate__animated animate__bounceIn">
                        <i class="fas fa-check-circle"></i> {{ Session::get('success') }}
                    </div>
                @endif

                @if (Session::get('error'))
                    <div class="error-message animate__animated animate__shakeX">
                        <i class="fas fa-exclamation-circle"></i> {{ Session::get('error') }}
                    </div>
                @endif

                <!-- Informations personnelles -->
                <h3 style="color: var(--primary-color); margin-bottom: 20px; border-bottom: 2px solid var(--primary-color); padding-bottom: 5px;">
                    <i class="fas fa-user-circle"></i> Informations personnelles
                </h3>
                
                <div class="form-row">
                    <div class="input-group">
                        <i class="fas fa-user input-icon"></i>
                        <input class="input-field" type="text" name="name" placeholder=" " value="{{ old('name') }}" />
                        <label class="input-label" for="name">Nom</label>
                        @error('name')
                            <div class="error-message">
                                <i class="fas fa-exclamation-circle"></i> {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="input-group">
                        <i class="fas fa-user input-icon"></i>
                        <input class="input-field" type="text" name="prenom" placeholder=" " value="{{ old('prenom') }}" />
                        <label class="input-label" for="prenom"> Prénom</label>
                        @error('prenom')
                            <div class="error-message">
                                <i class="fas fa-exclamation-circle"></i> {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>

                <!-- Informations de connexion -->
                <h3 style="color: var(--primary-color); margin: 30px 0 20px 0; border-bottom: 2px solid var(--primary-color); padding-bottom: 5px;">
                    <i class="fas fa-key"></i> Informations de connexion
                </h3>

                <div class="input-group">
                    <i class="fas fa-envelope input-icon"></i>
                    <input class="input-field" type="email" name="email" placeholder=" " value="{{ old('email') }}" />
                    <label class="input-label" for="email">Adresse Email</label>
                    @error('email')
                        <div class="error-message">
                            <i class="fas fa-exclamation-circle"></i> {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="form-row">
                    <div class="input-group">
                        <i class="fas fa-key input-icon"></i>
                        <input class="input-field" type="password" name="password" id="password" placeholder=" " />
                        <label class="input-label" for="password">Mot de passe</label>
                        <i class="fas fa-eye password-toggle" id="togglePassword"></i>
                        @error('password')
                            <div class="error-message">
                                <i class="fas fa-exclamation-circle"></i> {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="input-group">
                        <i class="fas fa-key input-icon"></i>
                        <input class="input-field" type="password" name="password_confirmation" id="password_confirmation" placeholder=" " />
                        <label class="input-label" for="password_confirmation">Confirmation</label>
                    </div>
                </div>

                <!-- Informations supplémentaires -->
                <h3 style="color: var(--primary-color); margin: 30px 0 20px 0; border-bottom: 2px solid var(--primary-color); padding-bottom: 5px;">
                    <i class="fas fa-info-circle"></i> Informations supplémentaires
                </h3>
                <div class="form-row">
                    <div class="input-group">
                        <i class="fas fa-phone input-icon"></i>
                        <input class="input-field" type="tel" name="contact" placeholder=" " value="{{ old('contact') }}" />
                        <label class="input-label" for="contact">Téléphone</label>
                        @error('contact')
                            <div class="error-message">
                                <i class="fas fa-exclamation-circle"></i> {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="input-group">
                        <i class="fas fa-map-marker-alt input-icon"></i>
                        <input class="input-field" type="text" name="CMU" placeholder=" " value="{{ old('CMU') }}" />
                        <label class="input-label" for="CMU">N°CMU</label>
                        @error('CMU')
                            <div class="error-message">
                                <i class="fas fa-exclamation-circle"></i> {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>

                <div class="input-group">
                    <i class="fas fa-user input-icon"></i>
                    <input class="input-field" type="file" name="profile_picture" placeholder=" " value="{{ old('profile_picture') }}" accept="image/jpeg, image/png, image/jpg, image/gif" />
                    <label class="input-label" for="profile_picture">Photo de profil</label>
                    @error('profile_picture')
                        <div class="error-message">
                            <i class="fas fa-exclamation-circle"></i> {{ $message }}
                        </div>
                    @enderror
                </div>

                <button type="submit" class="submit-btn animate__animated animate__pulse animate__infinite animate__slower">
                    <i class="fas fa-user-plus"></i> S'inscrire
                </button>
            </form>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Password toggle functionality
            const togglePassword = document.querySelector('#togglePassword');
            const password = document.querySelector('#password');
            const passwordConfirmation = document.querySelector('#password_confirmation');

            togglePassword.addEventListener('click', function() {
                const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
                password.setAttribute('type', type);
                passwordConfirmation.setAttribute('type', type);
                this.classList.toggle('fa-eye-slash');
            });

            // SweetAlert notifications
            @if (Session::has('success'))
                Swal.fire({
                    icon: 'success',
                    title: 'Succès',
                    text: '{{ Session::get('success') }}',
                    confirmButtonText: 'OK',
                    background: 'var(--light-color)',
                });
            @endif

            @if (Session::has('error'))
                Swal.fire({
                    icon: 'error',
                    title: 'Erreur',
                    text: '{{ Session::get('error') }}',
                    confirmButtonText: 'OK',
                    background: 'var(--light-color)',
                });
            @endif
        });
    </script>
</body>
</html>