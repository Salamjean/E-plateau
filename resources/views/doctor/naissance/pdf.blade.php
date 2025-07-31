<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        body {
            position: relative;
            margin: 0;
            height: 100vh;
        }
        body::before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-image: url(assets/assets/img/femme.png);
            background-size: cover;
            background-position: center;
            opacity: 0.3;
            z-index: -1;
        }
        .logo1 {
            position: absolute;
            margin-left: 75%;
            margin-top: 2;
            height: 110px;
            left: 40px;
        }
        .logo2 {
            height: 130px;
            position: absolute;
            left: -50px;
            margin-left: 0;
            margin-top: 0;
        }
        .logo {
            display: flex;
            justify-content: space-between;
        }
        .tete {
            text-align: center;
            font-family: calisto MT;
            font-size: 25px;
            color: #006;
            font-weight: bold;
        }
        .signature {
            position: absolute;
            bottom: 100px;
            right: 25px;
            font-size: 15px;
            font-weight: bold;
        }
        hr {
            position: absolute;
            bottom: 85px;
            width: 90%;
            border: 1px solid black;
            margin-left: 20px;
        }
        footer {
            position: absolute;
            bottom: 10px;
        }
    </style>
</head>
<body>
    <header>
        <div class="logo_g">
            <div class="logo">
                <img src="assets/assets/img/sante.jpg" class="logo2" alt="Logo">
                <img src="assets/assets/img/gouv_ci.png" class="logo1" alt="Logo">
            </div>
        </div>
        <br><br><br><br><br><br><br><br>
        <h1 class="tete">CERTIFICAT MÉDICAL DE NAISSANCE</h1>
    </header>
    <main>
        <div class="InfoNor">
            <p><strong>Sanitaire :</strong> {{ $doctor->nomHop }}</p>
            <p><strong>Ville/Commune de Naissance :</strong> {{ $declaration->commune }}</p>
            <p><strong>Date et Heure de Déclaration :</strong> {{ $declaration->created_at }}</p>
            <p><strong>Numéro de Déclaration :</strong> {{ $declaration->codeCMN }}</p>
        </div>

        <div class="InfoImp">
            <p>Je soussigné(e) : Dr {{ $doctor->name }} {{ $doctor->prenom }},</p>
            <p>Certifie que Mme : {{ $declaration->NomM }} {{ $declaration->PrM }},</p>
            <p>a bien accouché dans notre établissement sanitaire le : @if ($declaration->enfants->isNotEmpty())
                                            {{ $declaration->enfants->first()->date_naissance }}  {{-- Get nombreEnf from the *first* child --}}
                                        @else
                                            Aucun enfant enregistré
                                        @endif
                                    </p>
                <p>De @if ($declaration->enfants->isNotEmpty())
                        {{ $declaration->enfants->first()->nombreEnf }}  {{-- Get nombreEnf from the *first* child --}}
                    @else
                        Aucun enfant enregistré
                    @endif
                    enfant(s) vivant(s), de sexe(s) respectivement  @if ($declaration->enfants->isNotEmpty())
                    <ul class="text-center">
                        @foreach ($declaration->enfants as $enfant)
                            <li>
                                Enfant {{ $loop->iteration }}: Né(e) le : {{ $enfant->date_naissance }} de sexe : {{ $enfant->sexe }}
                            </li>
                        @endforeach
                    </ul>
                @else
                    Aucun enfant enregistré
                @endif
            </p>
                <p>
                           
        </div>
       
        <div class="signature">
            <p>Fait à Abobo. Le {{ $declaration->created_at }}</p>
            <p>Le Médecin :</p>
            <p>{{ $doctor->name }} {{ $doctor->prenom }}</p>
            <p>
                <img src="{{ $doctor->signature ? public_path('storage/' . $doctor->signature) : 'signature' }}" 
                     style="margin-left:150px; max-width: 250px; max-height: 100px;" 
                     alt="Signature"/>
            </p>
        </div>
         <!-- Afficher le QR code -->
         <div style=" margin:70px 0 0 10px">
            <img src="{{ public_path('storage/declarations/naissances/qrcode_' . $declaration->id . '.png') }}" alt="QR Code" style="width: 150px; height: auto;">
        </div>
    </main>
    <hr>
    <footer>
        134. Cet article stipule qu'une personne est coupable d'infractions en rapport avec la falsification,<br> 
        la reproduction ou l'usage de faux documents dans des contextes où ces actes sont destinés à induire en erreur l'autorité publique ou des tiers.<br>
        Est puni de deux (02) à dix (10) ans et une amende de 200 000 à 2 000 000 de franc CFA.
    </footer>
</body>
</html>

