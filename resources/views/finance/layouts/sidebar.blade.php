<ul class="nav">
          <li class="nav-item nav-profile border-bottom">
            <a href="{{route('finance.dashboard')}}" class="nav-link flex-column">
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
            <span class="nav-item-head text-white" style="text-align: center">Financier : {{Auth::user()->prenom}} </span>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="{{route('finance.dashboard')}}">
              <i class="mdi mdi-cash menu-icon text-white"></i>
              <span class="menu-title text-white">Tableau de bord</span>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="{{route('timbre.create')}}">
              <i class="mdi mdi-cash menu-icon text-white"></i>
              <span class="menu-title text-white">Vente de timbre</span>
            </a>
          </li>
          {{-- <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#ui-deces" aria-expanded="false" aria-controls="ui-deces">
              <i class="mdi mdi-crosshairs-gps menu-icon text-white"></i>
              <span class="menu-title text-white">Historique Timbre</span>
              <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="ui-deces">
              <ul class="nav flex-column sub-menu text-white">
                <li class="nav-item text-white" >
                  <a class="nav-link text-white" href="">Déclaration</a>
                </li>
                <li class="nav-item ">
                  <a class="nav-link text-white" href="">Demande extrait</a>
                </li>
              </ul>
            </div>
          </li> --}}
          <li class="nav-item">
            <a class="nav-link" href="{{route('finance.timbre.history')}}">
              <i class="mdi mdi-contacts menu-icon text-white"></i>
              <span class="menu-title text-white">Historique Timbre</span>
            </a>
          </li>
           
           {{-- <li class="nav-item">
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
          </li> --}}
           {{-- <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#ui-Historique" aria-expanded="false" aria-controls="ui-Historique">
              <i class="mdi mdi-crosshairs-gps menu-icon text-white"></i>
              <span class="menu-title text-white">Historique</span>
              <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="ui-Historique">
              <ul class="nav flex-column sub-menu text-white">
                <li class="nav-item text-white" >
                  <a class="nav-link text-white" href="">Naissance</a>
                </li>
                <li class="nav-item ">
                  <a class="nav-link text-white" href="">Décès</a>
                </li>
                <li class="nav-item ">
                  <a class="nav-link text-white" href="">Mariage</a>
                </li>
              </ul>
            </div>
          </li> --}}

        </ul>