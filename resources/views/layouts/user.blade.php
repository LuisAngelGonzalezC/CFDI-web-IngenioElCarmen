<!doctype html>
<html lang="es">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>Ingenio El Carmen</title>
        <link rel="shortcut icon" href="{{ asset('img/logo_icon.jpg') }}"/>
        <link rel="stylesheet" href="{{ asset('css/app.css') }}">
        @yield('links')
    </head>
    <body>
        <header>
            <nav class="navbar-fixed teal dark-4">
                <div class="nav-wrapper">
                    <a href="{{ route('admin.home') }}" class="brand-logo truncate">
                         <img src="{{ asset('img/logo_icon.jpg') }}" width="30px"> Ingenio El Carmen
                    </a>
                    <a href="#" data-activates="mobile-demo" class="button-collapse"><i class="material-icons">menu</i></a>
                        <ul class="right hide-on-med-and-down">
                            <li>
                                <a class="nav-link modal-trigger" href="#email">Correo electrónico</a>
                            </li>
                            <li>
                                <a class="nav-link modal-trigger" href="#salir">Salir</a>
                            </li>                          
                        </ul>

                        <ul class="side-nav" id="mobile-demo">
                            <li>
                                <a class="nav-link modal-trigger" href="#email">Correo electrónico</a>
                            </li>
                            <li>
                                <a class="nav-link modal-trigger" href="#salir">Salir</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>
        </header>
        <main class="container-fluid">         
            <!-- Logout-Modal -->
            <div id="salir" class="modal logout-modal">
                <div class="modal-content center">
                    <h4>¿Seguro que deseas salir?</h4>
                </div>
                <div class="modal-footer">
                    <a class="modal-action btn-flat" href="#" onclick="event.preventDefault();document.getElementById('logout-form').submit();">Salir
                    </a>
                    <a href="#!" class="modal-action modal-close btn-flat">Cancelar</a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        {{ csrf_field() }}
                    </form>
                </div>
            </div>      
            @yield('content')
        </main>
        <footer class="page-footer teal dark-4 center">
                © 2018 Ingenio El Carmen S.A. de C.V. Todos los derechos reservados.
                <br><br>  
        </footer>
        <script src="{{ asset('js/app.js') }}"></script>
        @include('partials.alerts')
        @stack('scripts')
        <script>
            $(document).ready(function(){
                $('.logout-modal').modal();
                $('.button-collapse').sideNav();
            });
        </script>
    </body>
</html>
