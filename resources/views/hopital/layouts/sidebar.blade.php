<aside id="ms-side-nav" class="side-nav fixed ms-aside-scrollable ms-aside-left">
    <!-- Logo -->
    <div class="logo-sn ms-d-block-lg">
      <div style="background-color:azure; margin-top:10px"><a class="pl-0 ml-0 text-center" href="{{ route('hopital.dashboard') }}"> {{ Auth::guard('hopital')->user()->nomHop }} </a></div><br>
      <a href="{{ route('hopital.dashboard') }}" class="text-center ms-logo-img-link"> <img class="ms-user-img ms-img-round" style=" width: 70px; /* Taille du cercle */
        height: 70px; /* Taille du cercle */
        border-radius: 55%; /* Cela rend l'image ronde */
        object-fit: cover;" src="{{ Auth::guard('hopital')->user()->profile_picture ? asset('storage/' . Auth::guard('hopital')->user()->profile_picture) : asset('assets/assets/img/plateau.jpeg') }}" alt="Profile Picture"></a>
      <h5 class="text-center text-white mt-2">{{ Auth::guard('hopital')->user()->name ?? 'Alain'  }}</h5>
      
    </div>
    <!-- Navigation -->
    <ul class="accordion ms-main-aside fs-14" id="side-nav-accordion">
      <!-- Dashboard -->
      <li class="menu-item">
        <a href="#" class="has-chevron" data-toggle="collapse" data-target="#dashboard" aria-expanded="false" aria-controls="dashboard">
          <span><i class="material-icons fs-16">dashboard</i>Tableau de bord </span>
        </a>
        <ul id="dashboard" class="collapse" aria-labelledby="dashboard" data-parent="#side-nav-accordion">
          <li> <a href="{{ route('hopital.dashboard') }}">Tableau de bord </a> </li>
        </ul>
      </li>
      <!-- /Dashboard -->
      <!-- hopital -->
      <li class="menu-item">
        <a href="#" class="has-chevron" data-toggle="collapse" data-target="#hopital" aria-expanded="false" aria-controls="hopital">
          <span><i class="fas fa-stethoscope"></i>Personnel</span>
        </a>
        <ul id="hopital" class="collapse" aria-labelledby="hopital" data-parent="#side-nav-accordion">
          <li> <a href="{{ route('doctor.create') }}">Ajouter Personnel</a> </li>
          <li> <a href="{{ route('doctor.index') }}">Liste Personnel</a> </li>
        </ul>
      </li>
      <li class="menu-item">
        <a href="#" class="has-chevron" data-toggle="collapse" data-target="#sanitary" aria-expanded="false" aria-controls="sanitary">
          <span><i class="fas fa-stethoscope"></i>Centre de santé</span>
        </a>
        <ul id="sanitary" class="collapse" aria-labelledby="sanitary" data-parent="#side-nav-accordion">
          <li> <a href="{{ route('sanitary.create') }}">Ajout centre de santé</a> </li>
          <li> <a href="{{ route('sanitary.index') }}">Liste centre de santé</a> </li>
        </ul>
      </li>
      <!-- hopital -->
      <li class="menu-item">
        <a href="#" class="has-chevron" data-toggle="collapse" data-target="#schedule" aria-expanded="false" aria-controls="schedule">
          <span><i class="fas fa-list-alt"></i>Directeur</span>
        </a>
        <ul id="schedule" class="collapse" aria-labelledby="schedule" data-parent="#side-nav-accordion">
          <li> <a href="{{ route('directeur.create') }}">Ajouter Directeur</a> </li>
          
        </ul>
      </li><br><br>
      <!-- /Schedule -->
      <!-- Appointment -->
      <li class="menu-item">
        <a href="#" class="has-chevron" data-toggle="collapse" data-target="#appointment" aria-expanded="false" aria-controls="appointment">
          <span><i class="far fa-check-square"></i>Statistique</span>
        </a>
        <ul id="appointment" class="collapse" aria-labelledby="appointment" data-parent="#side-nav-accordion">
          <li> <a href="{{route('hopital.stat')}}">Statistique</a> </li>
        </ul>
      </li>
      <!-- /Appointment -->
  </aside>
  <!-- Main Content -->
  <main class="body-content">