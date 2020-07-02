<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

   <!-- <title>{{ config('app.name', 'Laravel') }}</title>-->
    <title>Sistema-ESFOT</title>

    <!-- Scripts
    <script src="{ asset('js/app.js') }}" defer></script>-->


    <script src="{{ asset('Bootstrap/js/bootstrap.js')}}" defer></script>

    <!-- Fonts
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">-->
    <link href="{{ asset('Glyphicon/css/all.css')}}" rel="stylesheet">


    <!-- Styles -->
   <!-- <link href="{ asset('css/app.css') }}" rel="stylesheet">-->
    <link rel="stylesheet" href="{{asset('Bootstrap/css/bootstrap.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('DataTables/datatables.css')}}">


    <style>
        .content {
            text-align: center;
        }
        .title {
            font-size: 2.5vw;
            height: 70px;
        }
        .subtittle{
            font-size: 1.5vw;

        }
    </style>

    @yield('stilo')

</head>
<body>

<div id="app">
    <nav class="navbar navbar-expand-md navbar-dark bg-dark shadow-sm">
        <div class="container">
            @if(Auth::user()->hasRole('Docente'))
            <a class="navbar-brand" href="{{ url('/docente') }}">
               <!--{ config('app.name', 'ESFOT') }}-->
                ESFOT
            </a>
                @else
                <a class="navbar-brand" href="{{ url('/GestionProyectorAdministrador') }}">
                    ESFOT
                </a>


            @endif
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <!-- Left Side Of Navbar -->

                <!-- Right Side Of Navbar -->

                    <!-- Authentication Links -->
                    @guest
                    <ul class="navbar-nav ml-auto">
                    </ul>
                    <ul class="navbar-nav ml-auto">
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('docente.login') }}">{{ __('Login') }}</a>
                        </li>
                    </ul>

                    @else
                    @if(Auth::user()->hasRole('Administrador'))
                    <ul class="navbar-nav mr-auto">

                        <div class="nav-item dropdown">
                            <a class="nav-link "  href="{{ url('/ListaProyectorAdministrador') }}"><i class="fas fa-video"></i>Lista Proyectores</a>

                        </div>
                    </ul>
                    @endif
                        <ul class="navbar-nav ml-auto">

                        <li class="nav-item dropdown">
                            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                {{ Auth::guard('docente')->user()->name }} <span class="caret"></span>
                            </a>

                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">

                                <a class="dropdown-item" href="{{ route('docente.logout') }}"
                                   onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                    {{ __('Cerrar Sesión') }}
                                </a>

                                <form id="logout-form" action="{{ route('docente.logout') }}" method="POST" style="display: none;">
                                    @csrf
                                </form>
                            </div>
                        </li>
                            <li><a role="button" class="btn btn-danger" style="color: white;font-size: large" href="{{ route('docente.logout') }}"
                                   onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">Cerrar Sesión</a>
                                <form id="logout-form" action="{{ route('docente.logout') }}" method="POST" style="display: none;">
                                    @csrf
                                </form></li>
                        </ul>


            </div>
        </div>
    </nav>
    <div class="content">

        <div class="title m-b-md">
            <img src={{ asset('imagenes/escudo.png') }} alt="EscudoEPN" style="float:center;width:100px;height:100px;margin-top:10px;">
            ESCUELA DE FORMACIÓN DE TECNÓLOGOS
        </div>
        <div class="subtittle">
            ESCUELA POLITÉCNICA NACIONAL
        </div>

    </div>

    <main class="py-4">
        @yield('content')
    </main>
    @endguest

</div>
<script src="{{ asset('Jquery/jquery-3.4.1.min.js')}}" ></script>
<script src={{ asset("Sweetalert/sweetalert/sweetalert.min.js")}}></script>
<link rel="stylesheet" href="{{ asset('JqueyConfirm/jquery-confirm.min.css')}}">
<script src="{{ asset('JqueyConfirm/jquery-confirm.min.js')}}"></script>

@yield('javascript')


</body>

<script>
    var contadorAfk = 0;


    $(document).ready(function(){



        var contadorAfk = setInterval(ctrlTiempo, 3000);
        var modal = setInterval(f, 1000);
        function StopEstado() {
            clearInterval(modal);
        }


        //Si el usuario mueve el ratón cambiamos la variable a 0.
        $(this).mousemove(function (e) {
            contadorAfk = 0;
            console.log("mouse");


        });
        //Si el usuario presiona alguna tecla cambiamos la variable a 0.
        $(this).keypress(function (e) {
            contadorAfk = 0;
            console.log("teclado");

        });

        function f() {
           // var a = localStorage.getItem("alerta");
            var b=document.getElementById("Estado_cierre").value;
            console.log('Inicio Estado Puerta',b);
            //console.log('Abierto',dataFromlocalStorage);
            if(b == 1){
               // console.log('Abierto',b);
                contadorAfk = 0;

            }

        }


        $("body").on({
            'touchstart mousedown': function (e) {
                $(this).on('touchmove mousemove');
                console.log("Touch");
                contadorAfk = 0;

            },
            'touchend mouseup': function (e) {
                $(this).off('touchmove mousemove');
                contadorAfk = 0;
            }




        });





        function ctrlTiempo() {
            //Se aumenta en 1 la variable.
            contadorAfk++;
            //Se comprueba si ha pasado del tiempo que designemos.
            if (contadorAfk > 10) {
                contadorAfk = 0;
                StopEstado();
               // contadorAfk = 0;

                $.confirm({
                    title: 'Alerta!',
                    content: 'La sesión esta por expirar.',
                    autoClose: 'logoutUser|2000',
                    buttons: {
                        logoutUser: {
                            text: 'cerrar sesión',
                            action: function () {

                                //tu codigo AJAX
                                $.ajax({
                                    type: "POST",
                                    url: '{{route('docente.logout')}}',
                                    headers: {
                                        'X-CSRF-Token': '{{ csrf_token() }}',
                                    },
                                    success: function (data) {


                                    }
                                });
                                location.reload();
                            }

                        },
                    }
                });
                //La función o código que necesites para cerrar la sesión del usuario.
            }
        }
    });


</script>





</html>
