<ul class="nav">
          <li class="nav-item nav-profile border-bottom">
            <a href="{{route('mairie.dashboard')}}" class="nav-link flex-column">
              <div class="nav-profile-image">
                <img src="{{asset('assets/assets/img/logo plateau.png')}}" alt="profile" />
                <!--change to offline or busy as needed-->
              </div>
              <div class="nav-profile-text d-flex ml-0 mb-3 flex-column">
                <span class="font-weight-semibold mb-1 mt-2 text-center text-white">Mairie du plateau</span>
              </div>
            </a>
          </li>
          <li class="pt-2 pb-1">
            <span class="nav-item-head text-white">Administrateur</span>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="{{route('mairie.dashboard')}}">
              <i class="mdi mdi-compass-outline menu-icon text-white"></i>
              <span class="menu-title text-white">Tableau de bord</span>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#ui-basic" aria-expanded="false" aria-controls="ui-basic">
              <i class="mdi mdi-crosshairs-gps menu-icon text-white"></i>
              <span class="menu-title text-white">Naissance</span>
              <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="ui-basic">
              <ul class="nav flex-column sub-menu text-white">
                <li class="nav-item text-white" >
                  <a class="nav-link text-white" href="{{route('mairie.declaration.naissance.index')}}">Déclaration</a>
                </li>
                <li class="nav-item ">
                  <a class="nav-link text-white" href="{{route('mairie.demandes.naissance.index')}}">Demande extrait</a>
                </li>
              </ul>
            </div>
          </li>
          <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#ui-deces" aria-expanded="false" aria-controls="ui-deces">
              <i class="mdi mdi-crosshairs-gps menu-icon text-white"></i>
              <span class="menu-title text-white">Décès</span>
              <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="ui-deces">
              <ul class="nav flex-column sub-menu text-white">
                <li class="nav-item text-white" >
                  <a class="nav-link text-white" href="{{route('mairie.declaration.deces.index')}}">Déclaration</a>
                </li>
                <li class="nav-item ">
                  <a class="nav-link text-white" href="{{route('mairie.demandes.deces.index')}}">Demande extrait</a>
                </li>
              </ul>
            </div>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="{{route('mairie.demandes.wedding.index')}}">
              <i class="mdi mdi-contacts menu-icon text-white"></i>
              <span class="menu-title text-white">Mariage</span>
            </a>
          </li>
           <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#ui-agent" aria-expanded="false" aria-controls="ui-agent">
              <i class="mdi mdi-crosshairs-gps menu-icon text-white"></i>
              <span class="menu-title text-white">Agent d'état civil</span>
              <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="ui-agent">
              <ul class="nav flex-column sub-menu text-white">
                <li class="nav-item text-white" >
                  <a class="nav-link text-white" href="{{route('agent.create')}}">Ajout d'un agent</a>
                </li>
                <li class="nav-item ">
                  <a class="nav-link text-white" href="{{route('agent.index')}}">Listes des agents</a>
                </li>
              </ul>
            </div>
          </li>
           <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#ui-Hôpital" aria-expanded="false" aria-controls="ui-Hôpital">
              <i class="mdi mdi-crosshairs-gps menu-icon text-white"></i>
              <span class="menu-title text-white">Hôpital</span>
              <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="ui-Hôpital">
              <ul class="nav flex-column sub-menu text-white">
                <li class="nav-item text-white" >
                  <a class="nav-link text-white" href="{{route('hopital.create')}}">Ajout d'un Hôpital</a>
                </li>
                <li class="nav-item ">
                  <a class="nav-link text-white" href="{{route('hopital.index')}}">Listes des Hôpitaux</a>
                </li>
              </ul>
            </div>
          </li>
           <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#ui-Caissier" aria-expanded="false" aria-controls="ui-Caissier">
              <i class="mdi mdi-crosshairs-gps menu-icon text-white"></i>
              <span class="menu-title text-white">Caissier</span>
              <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="ui-Caissier">
              <ul class="nav flex-column sub-menu text-white">
                <li class="nav-item text-white" >
                  <a class="nav-link text-white" href="pages/ui-features/buttons.html">Ajout d'un Caissier</a>
                </li>
                <li class="nav-item ">
                  <a class="nav-link text-white" href="pages/ui-features/dropdowns.html">Listes des Caissiers</a>
                </li>
              </ul>
            </div>
          </li>
           <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#ui-Livreur" aria-expanded="false" aria-controls="ui-Livreur">
              <i class="mdi mdi-crosshairs-gps menu-icon text-white"></i>
              <span class="menu-title text-white">Livreur</span>
              <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="ui-Livreur">
              <ul class="nav flex-column sub-menu text-white">
                <li class="nav-item text-white" >
                  <a class="nav-link text-white" href="pages/ui-features/buttons.html">Ajout d'un Livreur</a>
                </li>
                <li class="nav-item ">
                  <a class="nav-link text-white" href="pages/ui-features/dropdowns.html">Listes des Livreurs</a>
                </li>
              </ul>
            </div>
          </li>
           <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#ui-Historique" aria-expanded="false" aria-controls="ui-Historique">
              <i class="mdi mdi-crosshairs-gps menu-icon text-white"></i>
              <span class="menu-title text-white">Historique</span>
              <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="ui-Historique">
              <ul class="nav flex-column sub-menu text-white">
                <li class="nav-item text-white" >
                  <a class="nav-link text-white" href="pages/ui-features/buttons.html">Naissance</a>
                </li>
                <li class="nav-item ">
                  <a class="nav-link text-white" href="pages/ui-features/dropdowns.html">Décès</a>
                </li>
                <li class="nav-item ">
                  <a class="nav-link text-white" href="pages/ui-features/dropdowns.html">Mariage</a>
                </li>
              </ul>
            </div>
          </li>

        </ul>