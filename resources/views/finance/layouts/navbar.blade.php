<nav class="navbar default-layout-navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
          <div class="navbar-menu-wrapper d-flex align-items-stretch">
            <button class="navbar-toggler navbar-toggler align-self-center" type="button" data-toggle="minimize" style="background-color: white">
              <span class="mdi mdi-chevron-double-left" style="color:black"></span>
            </button>
            <div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-center">
              <a class="navbar-brand brand-logo-mini" href="{{route('finance.dashboard')}}"><img src="{{asset('assets/assets/img/logo plateau.png')}}" alt="logo" width="50px" /></a>
            </div>
            <ul class="navbar-nav navbar-nav-right">
              
              <li class="nav-item nav-logout d-none d-lg-block">
                <a class="nav-link" href="{{route('finance.logout')}}">
                  <i class="mdi mdi-home-circle"></i> Déconnexion
                </a>
              </li>
            </ul>
            <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button" data-toggle="offcanvas">
              <span class="mdi mdi-menu"></span>
            </button>
          </div>
        </nav>