    <header class="navbar navbar-dark sticky-top bg-dark flex-md-nowrap p-0 shadow">
        <a class="navbar-brand col-md-3 col-lg-2 me-0 px-3"
            href="https://queeserp.tk/lista/{{ $usuario->empresas[0]->nombre }}">{{ $usuario->empresas[0]->nombre }}</a>
        <button class="navbar-toggler position-absolute d-md-none collapsed" type="button" data-bs-toggle="collapse"
            data-bs-target="#sidebarMenu" aria-controls="sidebarMenu" aria-expanded="false"
            aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="dropdown pe-4">
            <button class="btn btn-dark dropdown-toggle" type="button" id="dropdownMenuButton2" data-bs-toggle="dropdown"
                aria-expanded="false">
                Configuración {{ $usuario->nombre }}
            </button>
            <ul class="dropdown-menu dropdown-menu-dark me-5" aria-labelledby="dropdownMenuButton2">
                <li><a class="nav-link text-light" href="https://queeserp.tk/lista">Cambiar de Empresa</a></li>
                <li>
                    <hr class="dropdown-divider">
                </li>
                <li><a class="nav-link text-light" href="https://queeserp.tk/logout">Cerrar sesión</a></li>
            </ul>
        </div>
    </header>
    <div class="container-fluid">
        <div class="row">
            <nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block bg-light sidebar collapse">
                <div class="position-sticky pt-3">
                    <ul class="nav flex-column">
                        <li class="nav-item pt-5">
                            <h6 class="ms-3" aria-current="page" href="#">
                                <span data-feather="layers"></span>
                                Contabilidad
                            </h6>
                        </li>
                        <hr>
                        <li class="nav-item">
                            <a class=" nav-link" id="gestiones_enlace"
                                href="{{ route('lista-gestiones', $usuario->empresas[0]->nombre) }}">
                                <span data-feather="file"></span>
                                Gestión
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class=" nav-link" id="cuentas_enlace" href="{{-- route('lista-cuentas',$usuario->empresas[0]->nombre) --}}">
                                <span data-feather="file"></span>
                                Cuentas
                            </a>
                        </li>
                    </ul>
                </div>
            </nav>
        </div>
    </div>

    <style>
        body {
            font-size: .875rem;
        }

        .feather {
            width: 16px;
            height: 16px;
            vertical-align: text-bottom;
        }

        .sidebar {
            position: fixed;
            top: 0;
            bottom: 0;
            left: 0;
            z-index: 100;
            /* Behind the navbar */
            padding: 0;
            box-shadow: inset -1px 0 0 rgba(0, 0, 0, .1);
        }

        .sidebar-sticky {
            position: -webkit-sticky;
            position: sticky;
            top: 48px;
            /* Height of navbar */
            height: calc(100vh - 48px);
            padding-top: .5rem;
            overflow-x: hidden;
            overflow-y: auto;
            /* Scrollable contents if viewport is shorter than content. */
        }

        .sidebar .nav-link {
            font-weight: 500;
            color: #333;
        }

        .sidebar .nav-link .feather {
            margin-right: 4px;
            color: #999;
        }

        .sidebar .nav-link.active {
            color: #007bff;
        }

        .sidebar .nav-link:hover .feather,
        .sidebar .nav-link.active .feather {
            color: inherit;
        }

        .sidebar-heading {
            font-size: .75rem;
            text-transform: uppercase;
        }

        .navbar-brand {
            padding-top: .75rem;
            padding-bottom: .75rem;
            font-size: 1rem;
            background-color: rgba(0, 0, 0, .25);
            box-shadow: inset -1px 0 0 rgba(0, 0, 0, .25);
        }

        .navbar .form-control {
            padding: .75rem 1rem;
            border-width: 0;
            border-radius: 0;
        }

        .form-control-dark {
            color: #fff;
            background-color: rgba(255, 255, 255, .1);
            border-color: rgba(255, 255, 255, .1);
        }

        .form-control-dark:focus {
            border-color: transparent;
            box-shadow: 0 0 0 3px rgba(255, 255, 255, .25);
        }

        .border-top {
            border-top: 1px solid #e5e5e5;
        }

        .border-bottom {
            border-bottom: 1px solid #e5e5e5;
        }

    </style>
