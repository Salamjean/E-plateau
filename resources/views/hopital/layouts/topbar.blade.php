<nav class="navbar ms-navbar">
  <div class="ms-aside-toggler ms-toggler pl-0" data-target="#ms-side-nav" data-toggle="slideLeft">
      <span class="ms-toggler-bar bg-white"></span>
      <span class="ms-toggler-bar bg-white"></span>
      <span class="ms-toggler-bar bg-white"></span>
  </div>

  {{-- Ajoute un logo ici centré --}}
  {{-- <div class="text-center my-2">
      <img src="{{ asset('assets4/img/logoo.png') }}" alt="Logo" style="width: 100px; height: auto;">
  </div> --}}
  {{-- Fin de l'ajout du logo --}}

      <li class="ms-nav-item ms-nav-user dropdown">
        <a href="#" id="userDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <img class="ms-user-img ms-img-round float-right" 
                 style="width: 50px; height: 40px; border-radius: 50%; object-fit: cover;" 
                 src="{{ Auth::guard('hopital')->user()->profile_picture ? asset('storage/' . Auth::guard('hopital')->user()->profile_picture) : asset('assets/assets/img/plateau.jpeg') }}" 
                 alt="Profile Picture">
            </a>
          <ul class="dropdown-menu dropdown-menu-right user-dropdown" aria-labelledby="userDropdown">
              <li class="dropdown-menu-header">
                  <h6 class="dropdown-header ms-inline m-0"><span class="text-disabled">Bienvenue, {{ Auth::guard('hopital')->user()->name ?? 'Alain' }}</span></h6>
              </li>
              <li class="dropdown-divider"></li>
              <li class="ms-dropdown-list">
                  <a class="media fs-14 p-2" href="pages/prebuilt-pages/user-profile.html"> <span><i class="flaticon-user mr-2"></i> Profil</span> </a>
              </li>
              <li class="dropdown-menu-footer">
                  <a class="media fs-14 p-2" href="{{ route('hopital.logout') }}"> <span><i class="flaticon-shut-down mr-2"></i> Déconnexion</span> </a>
              </li>
          </ul>
      </li>
  </ul>
  <div class="ms-toggler ms-d-block-sm pr-0 ms-nav-toggler" data-toggle="slideDown" data-target="#ms-nav-options">
      <span class="ms-toggler-bar bg-white"></span>
      <span class="ms-toggler-bar bg-white"></span>
      <span class="ms-toggler-bar bg-white"></span>
  </div>
</nav>