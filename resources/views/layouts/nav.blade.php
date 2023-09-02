<nav class="navbar navbar-dark bg-dark">
    <div class="container-fluid">
        <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasDarkNavbar" aria-controls="offcanvasDarkNavbar" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
      <a class="navbar-brand mr-auto" href="#"><img src="{{ asset('assets/img/akcize_logo.png') }}" height="60px;"> Akcize Portal</a>

      <div class="offcanvas offcanvas-start text-bg-dark" tabindex="-1" id="offcanvasDarkNavbar" aria-labelledby="offcanvasDarkNavbarLabel">
        <div class="offcanvas-header">
          <h5 class="offcanvas-title" id="offcanvasDarkNavbarLabel">Akcize Portal</h5>
          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">
          <ul class="navbar-nav justify-content-end flex-grow-1 pe-3">
            @guest
                    @if (Route::has('login'))
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                        </li>
                    @endif

                    @if (Route::has('register'))
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                        </li>
                    @endif
                @else

                    <li><a class="nav-link" href="{{ route('klijenti.index') }}"><i class="fas fa-user-tie me-2"></i> Klijenti</a></li>
                    <li><a class="nav-link" href="{{ route('radnalista.index') }}"><i class="fas fa-user-tie me-2"></i> Lista Naloga</a></li>
                    <li class="nav-item dropdown">
                        <a id="podesavanja" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                            <i class="fas fa-tools me-2"></i> Podešavanja
                        </a>
                        <div class="dropdown-menu dropdown-menu-dark" aria-labelledby="podesavanja">
                            <a class="dropdown-item" href="{{ route('knjigovodja.index') }}">Knjigovodja</a>
                            <a class="dropdown-item" href="{{ route('banke.index') }}">Banke</a>
                            <a class="dropdown-item" href="{{ route('poreskafilijala.index') }}">Poreske Filijale</a>
                            <a class="dropdown-item" href="{{ route('gorivo.index') }}">Gorivo</a>
                            <a class="dropdown-item" href="{{ route('dobavljaci.index') }}">Dobavljači</a>
                            <a class="dropdown-item" href="{{ route('kvartali.index') }}">Kvartali</a>
                        </div>
                    </li>
                    <li class="nav-item dropdown">
                        <a id="administracija" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                            <i class="fas fa-user-cog me-2"></i> Administracija
                        </a>
                        <div class="dropdown-menu dropdown-menu-dark" aria-labelledby="administracija">
                            <a class="dropdown-item" href="{{ route('users.index') }}">Korisnici</a>
                            <a class="dropdown-item" href="{{ route('roles.index') }}">Dozvole</a>
                        </div>
                    </li>
                    <li class="nav-item dropdown">
                        <a id="profil" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                            <i class="fas fa-user me-2"></i> {{ Auth::user()->name }}
                        </a>

                        <div class="dropdown-menu dropdown-menu-dark" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="{{ route('profile.edit') }}">{{ __('Profile') }}</a>
                            <a class="dropdown-item" href="{{ route('logout') }}"
                               onclick="event.preventDefault();
                                             document.getElementById('logout-form').submit();">
                                {{ __('Logout') }}
                            </a>

                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        </div>
                    </li>
                @endguest
          </ul>
          <form class="d-flex mt-3" role="search">
            <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
            <button class="btn btn-success" type="submit">Search</button>
          </form>
        </div>
      </div>
    </div>
</nav>