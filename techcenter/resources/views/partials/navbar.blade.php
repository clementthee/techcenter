{{-- Barra de todas las páginas. En el inicio los enlaces bajan a la sección; fuera, vuelven a ella. --}}
@php($enInicio = request()->routeIs('inicio'))
<nav class="navbar navbar-expand-lg navbar-dark bg-dark sticky-top">
    <div class="container">
        <a class="navbar-brand fw-bold" href="{{ route('inicio') }}">TechCenter</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#menu">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="menu">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link" href="{{ $enInicio ? '#inicio' : route('inicio').'#inicio' }}">Inicio</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ $enInicio ? '#servicios' : route('inicio').'#servicios' }}">Servicios</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ $enInicio ? '#empresas' : route('inicio').'#empresas' }}">Empresas</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ $enInicio ? '#nosotros' : route('inicio').'#nosotros' }}">Nosotros</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ $enInicio ? '#recomendaciones' : route('inicio').'#recomendaciones' }}">Recomendaciones</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ $enInicio ? '#galeria' : route('inicio').'#galeria' }}">Galería</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ $enInicio ? '#contacto' : route('inicio').'#contacto' }}">Contacto</a>
                </li>
                @guest
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('login') }}">Ingresar</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('register') }}">Registrarse</a>
                    </li>
                @endguest
                @auth
                    <li class="nav-item">
                        <a class="nav-link" href="{{ auth()->user()->panelRoute() }}">
                            {{ auth()->user()->role === 'admin' ? 'Administración' : 'Mis pedidos' }}
                        </a>
                    </li>
                    <li class="nav-item">
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="nav-link border-0 bg-transparent">Salir</button>
                        </form>
                    </li>
                @endauth
            </ul>
            <button type="button" id="btnModo" class="btn btn-outline-light btn-sm ms-lg-3 btn-modo" aria-pressed="false" aria-label="Modo oscuro">
                <svg class="icono-luna" viewBox="0 0 24 24" aria-hidden="true">
                    <path fill="currentColor" d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79z"></path>
                </svg>
                <svg class="icono-sol" viewBox="0 0 24 24" aria-hidden="true">
                    <circle cx="12" cy="12" r="4" fill="currentColor"></circle>
                    <g stroke="currentColor" stroke-width="2" stroke-linecap="round">
                        <line x1="12" y1="2" x2="12" y2="5"></line>
                        <line x1="12" y1="19" x2="12" y2="22"></line>
                        <line x1="2" y1="12" x2="5" y2="12"></line>
                        <line x1="19" y1="12" x2="22" y2="12"></line>
                        <line x1="4.9" y1="4.9" x2="7" y2="7"></line>
                        <line x1="17" y1="17" x2="19.1" y2="19.1"></line>
                        <line x1="19.1" y1="4.9" x2="17" y2="7"></line>
                        <line x1="7" y1="17" x2="4.9" y2="19.1"></line>
                    </g>
                </svg>
            </button>
        </div>
    </div>
</nav>
