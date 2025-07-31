<aside id="ms-side-nav" class="side-nav fixed ms-aside-scrollable ms-aside-left">
    <!-- Logo -->
    <div class="logo-sn ms-d-block-lg">
      <div style="background-color:azure; margin-top:10px"><a class="pl-0 ml-0 text-center" href="index.html"> {{ Auth::guard('doctor')->user()->nomHop }} </a></div><br>
      <a href="{{ route('doctor.dashboard') }}" class="text-center ms-logo-img-link"> <img class="ms-user-img ms-img-round" style="
        width: 70px;
        height: 70px;
        border-radius: 55%;
        object-fit: cover;"
        src="
            @if(Auth::guard('doctor')->user()->profile_picture)
                {{ asset('storage/' . Auth::guard('doctor')->user()->profile_picture) }}
            @else
                @if(Auth::guard('doctor')->user()->sexe == 'Homme') 
                    {{ asset('assets/images/profiles/user_homme.png') }}
                @elseif(Auth::guard('doctor')->user()->sexe == 'Femme')
                    {{ asset('assets/images/profiles/user_femme.jpeg') }}
                @else
                    {{ asset('assets/images/profiles/neutre.png') }} 
                @endif
            @endif
        "></a>
      <h5 class="text-center text-white mt-2">{{ Auth::guard('doctor')->user()->fonction }} : {{ Auth::guard('doctor')->user()->name }} </h5>
      
    </div>
    <!-- Navigation -->
    <ul class="accordion ms-main-aside fs-14" id="side-nav-accordion">
      <!-- Dashboard -->
      <li class="menu-item">
        <a href="#" class="has-chevron" data-toggle="collapse" data-target="#dashboard" aria-expanded="false" aria-controls="dashboard">
          <span><i class="material-icons fs-16">dashboard</i>Tableau de board </span>
        </a>
        <ul id="dashboard" class="collapse" aria-labelledby="dashboard" data-parent="#side-nav-accordion">
          <li> <a href="{{ route('doctor.dashboard') }}">E-Côte d'Ivoire</a> </li>
        </ul>
      </li>
      <!-- /Dashboard -->
      <!-- Patient -->
      <li class="menu-item">
        <a href="#" class="has-chevron" data-toggle="collapse" data-target="#patient" aria-expanded="false" aria-controls="patient">
          <span><i class="fas fa-user"></i>Déclaration Naissance</span>
        </a>
        <ul id="patient" class="collapse" aria-labelledby="patient" data-parent="#side-nav-accordion">
          <li> <a href="{{route('statement.create')}}">Faire Déclaration</a> </li>
          <li> <a href="{{route('statement.index')}}">Liste Déclaration</a> </li>
        </ul>
      </li>
      <!-- /Patient -->
      <!-- Department -->
      <li class="menu-item">
        <a href="#" class="has-chevron" data-toggle="collapse" data-target="#department" aria-expanded="false" aria-controls="department">
          <span><i class="fas fa-school"></i>Déclaration Décès</span>
        </a>
        <ul id="department" class="collapse" aria-labelledby="department" data-parent="#side-nav-accordion">
          <li> <a href="#">Faire Déclaration</a> </li>
          <li> <a href="#">Liste Déclaration</a> </li>
        </ul>
      </li>
      <!-- /Department -->
      <!-- Schedule -->
      <li class="menu-item">
        <a href="#" class="has-chevron" data-toggle="collapse" data-target="#schedule" aria-expanded="false" aria-controls="schedule">
          <span><i class="fas fa-list-alt"></i>Statistique</span>
        </a>
        <ul id="schedule" class="collapse" aria-labelledby="schedule" data-parent="#side-nav-accordion">
          <li> <a href="#">Statistique</a> </li>
        </ul>
      </li><br><br>

         <!-- signature -->
         <li class="menu-item">
          <a href="#" class="has-chevron" data-toggle="collapse" data-target="#signature" aria-expanded="false" aria-controls="signature">
            <span><i class="fas fa-list-alt"></i>Signature</span>
          </a>
          <ul id="signature" class="collapse" aria-labelledby="signature" data-parent="#side-nav-accordion">
            <li> <a href="#">Emarger</a> </li>
          </ul>
        </li><br><br>
      <!-- /signature -->
  </aside>
  <!-- Main Content -->
  <main class="body-content">