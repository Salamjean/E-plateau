@extends('doctor.layouts.template') 

@section('content')
    <div class="container">
        <h1 class="text-xs text-center mt-2 mb-3">Entrez votre signature</h1>

        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="card" >
            <div class="card-body">
                <div style="display: flex; justify-content:space-between">
                    <h5 class="card-title">Votre Signature Actuelle</h5>
                    <h5 style="margin-top:50px ">Avez-vous une signature électronique ?<br>Si non <a href="https://createmysignature.com/fr" target="_blank">cliquez ici pour en crée</a></h5>
                </div>
               

                @if($sousAdmin->signature)
                    <img src="{{ Storage::url($sousAdmin->signature) }}" alt="Signature de {{ $sousAdmin->name }} {{ $sousAdmin->prenom }}" style="max-width: 200px; max-height: 100px;">
                @else
                    <p>Aucune signature enregistrée.</p>
                @endif

                <hr>

                <h5 class="card-title">Mettre à Jour votre Signature</h5>
                <form action="{{ route('doctor.signature.update') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('POST') {{-- Assurez-vous que la route accepte POST pour la mise à jour --}}

                    <div class="mb-3">
                        <label for="signature" class="form-label">Choisir une nouvelle signature (Image)</label>
                        <input class="form-control" type="file" id="signature" name="signature">
                        <div class="form-text">Formats autorisés: jpeg, png, jpg, gif, svg. Taille max: 2Mo.</div>
                    </div>

                    <button type="submit" class="btn btn-primary">Mettre à Jour la Signature</button>
                </form>
            </div>
        </div>
    </div>
@endsection