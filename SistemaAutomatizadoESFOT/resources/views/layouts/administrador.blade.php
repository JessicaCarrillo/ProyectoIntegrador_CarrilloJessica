<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!--<title>{ config('app.name', 'Laravel') }}</title>-->
    <title>Sistema-ESFOT</title>

    <!-- Scripts -->
<!--<script src="{ asset('js/app.js') }}" defer></script> -->
    <script src="{{ asset('js/app.js') }}" ></script>


    <!-- Fonts -->
    <link href="{{ asset('Glyphicon/css/all.css')}}" rel="stylesheet">
    <!-- Styles -->
    <link rel="stylesheet" href="{{asset('Bootstrap/css/bootstrap.css') }}">

    <link rel="stylesheet" type="text/css" href="{{ asset('DataTables/datatables.css')}}">
    <link rel="stylesheet" href="{{ asset('Datepicker/bootstrap-datepicker.css')}}">
    <script src="{{ asset('Datepicker/bootstrap-datepicker.js')}}"></script>

    <link href="{{asset('Bootstrap4Toogle/css/bootstrap4-toggle.css')}}" rel="stylesheet">
    <script src="{{asset('Bootstrap4Toogle/js/bootstrap4-toggle.js')}}"></script>

    @yield('estilo')
</head>
<body>
<div id="app">
    <nav class="navbar navbar-expand-md navbar-dark bg-dark shadow-sm">
        <div class="container">
            @guest
                <a class="navbar-brand" href="{{ url('/') }}">
                    <!--{ config('app.name', 'Laravel') }}-->
                    Sistema-ESFOT
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>
            @else
                <a class="navbar-brand" href="{{ url('/GestionDocentes') }}">
                <!--  { config('app.name', 'Laravel') }-->ESFOT
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>
            @endguest
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <!-- Right Side Of Navbar -->
                    <!-- Authentication Links -->
                    @guest
                    <ul class="navbar-nav ml-auto">
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                        </li>
                        @if (Route::has('register') )
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('register') }}">{{ __('Registro') }}</a>
                            </li>
                        @endif
                    </ul>
                    @else
                <!-- Left Side Of Navbar -->
                    @if(Auth::user()->hasRole('Administrador'))
                    <ul class="navbar-nav mr-auto">

                        <div class="nav-item dropdown">
                            <a class="nav-link"  href="/GestionDocentes"><i class="fas fa-user"></i> Docentes</a>



                        </div>
                        <div class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="/GestionCarreras"><i class=" fas fa-book-reader"></i> Carreras</a>
                            <div class="dropdown-menu" aria-labelledby="navbarDropdowngestiónMenuLink">
                                <a class="dropdown-item" href="/GestionCarreras">Gestión Carrera</a>
                                <a class="dropdown-item" href="/GestionPeriodos">Gestión Periodos</a>
                            </div>

                        </div>
                        <div class="nav-item dropdown">
                            <a class="nav-link" href="/GestionMaterias"><i class="fas fa-folder-open"></i> Materias</a>
                        </div>

                        <div class="nav-item dropdown">
                            <a class="nav-link"  href="/Proyectores"><i class="fas fa-video"></i> Proyectores</a>

                        </div>

                        <div class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle"  data-toggle="dropdown" href="/Proyectores"><i class="fas fa-clipboard-list"></i> Reportes</a>
                            <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                                <a class="dropdown-item" href="/ReporteAsistencia">Asistencia</a>
                                <a class="dropdown-item" href="/ReporteProyector">Proyectores</a>
                            </div>
                        </div>



                    </ul>
                @endif

                    <ul class="navbar-nav ml-auto">
                        <li class="nav-item dropdown">
                            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                {{ Auth::user()->name }} <span class="caret"></span>
                            </a>

                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="{{ route('logout') }}"
                                   onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                    {{ __('Cerrar Sesión') }}
                                </a>

                                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                    @csrf
                                </form>
                            </div>
                        </li>
                        @endguest

                </ul>
            </div>
        </div>
    </nav>

    @guest
    <main class="py-4">
        @yield('content-login')
        @yield('content-register')
        @yield('content-email')
        @yield('content-reset')
        @yield('content-verify')

    </main>
    @else
        <main class="py-4">
            @yield('content')
        </main>
    @endguest





</div>

<script src={{ asset("Sweetalert/sweetalert/sweetalert.min.js")}}></script>
@yield('javascript')

</body>


<!--<script
        src="https://code.jquery.com/jquery-3.4.1.min.js"
        integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo="
        crossorigin="anonymous"></script>-->

<script type="text/javascript" charset="utf8" src="/DataTables/datatables.js"></script>
<script>

    $(document).ready( function () {


        $.extend( $.fn.dataTable.defaults, {
            searching: false,
            ordering:  false
        } );
        $('#tbl_docentes').DataTable({
            destroy: true,
            searching: true,
            ordering:  true,
            stateSave: true,
            "language": {
                "lengthMenu": "Mostrar _MENU_ entradas",
                "zeroRecords": "No se ha encontrado resultados",
                "info": "Mostrándo página _PAGE_ de _PAGES_",
                "sInfo":  "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
                "infoEmpty": "No hay registros disponibles",
                "infoFiltered": "(filtered from _MAX_ total records)",
                "search": "Buscar:",
                "paginate": {
                    "first":      "Primero",
                    "last":       "Último",
                    "next":       "Siguiente",
                    "previous":   "Anterior"

                }
            }
        });

    } );

</script>
</html>
