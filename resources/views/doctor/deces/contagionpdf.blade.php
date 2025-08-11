<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<style>
    body {
        margin: 0;
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
            bottom: 300px;
            right: 25px;
            font-size: 15px;
            font-weight: bold;
        }
    .header{
        display: flex;
        justify-content: space-around;
        font-size: 10px;
    }
    .content{
        display: flex;
        justify-content: space-around;
        font-size: 10px;
        margin-left: 0;
    }
    .containt{
        text-align: center;
        font-size: 15px;
        font-weight: bold;
        font-family: 'Courier New', Courier, monospace;
    }
    .union{
        margin-top: -155px;
        margin-left: 65%;
        margin-bottom: 150px;
    }
    .fait {
        margin-top: -50px;
        margin-left: 75%;
        margin-bottom: 70px;
    }
</style>
<body>
    <header>
        <div class="logo_g">
            <div class="logo">
                <img src="assets/assets/img/sante.jpg" class="logo2" alt="Logo">
                <img src="assets/assets/img/gouv_ci.png" class="logo1" alt="Logo">
            </div>
        </div>
        <br><br><br><br><br><br><br><br>
       
    </header>
    <div class="content">
        <h2 >{{ strtoupper($sousadmin->nomHop) }}</h2>
        <h2 class="fait">Abidjan le, {{ $sousadmin->created_at->translatedFormat('d M Y') }}</h2>
    </div>
    <h1 style="text-align: center; font-family: algerian; font-size: 30px; "><u>CERTIFICAT DE NON CONTAGION</u></h1>
    <div class="containt">
        <p>Je sousigné monsieur le docteur {{ $sousadmin->name .' '.$sousadmin->prenom  }} Medecin en service à <br>
            {{ strtoupper($sousadmin->nomHop) }}, certifie que M./Mme/Mlle  {{ $decesHop->NomM }} {{ $decesHop->PrM }},<br>
            <br>
        de numéro de certificat de decès {{ $decesHop->codeCMD }} n'est affecté(e) d'aucune maladie contagieuse. </p>
        <p>En foi de quoi, le présent certificat lui est delivré pour servir et valoir ce que de droit</p>
    </div>
    <div>
        <p style="text-align: right;font-size:16px; margin-right: 50px; font-weight: bold;"><u>LE MEDECIN</u></p>
        <p style="text-align: right;font-size:13px; margin-right: 50px; font-weight: bold;"></u>{{ $sousadmin->name .' '.$sousadmin->prenom  }}</p>
        <p>
            <img src="{{ $sousadmin->signature ? public_path('storage/' . $sousadmin->signature) : 'signature' }}" 
                 style="margin-left:550px; max-width: 200px; max-height: 100px;" 
                 alt="Signature"/>
        </p>
</body>
</html>