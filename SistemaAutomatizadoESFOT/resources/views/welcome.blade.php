<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Sistema-ESFOT</title>
        <script src="{{ asset('Bootstrap/js/bootstrap.js')}}" defer></script>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">


        <!-- Styles -->
        <link rel="stylesheet" href="{{asset('Bootstrap/css/bootstrap.min.css') }}">





        <!--  @font-face {
          font-family: 'Nunito-Light', arial;
          src: url('{asset('/Fonts/nunito-light.ttf')}}');
          }-->
        <style>


            html, body {
                background-color: #fff;
                color: #636b6f;
                font-family: 'Nunito', sans-serif;
                font-weight: 200;
                height: 100vh;
                margin: 0;
            }

            .full-height {
                height: 100vh;
            }

            .flex-center {
                align-items: center;
                display: flex;
                justify-content: center;
            }

            .position-ref {
                position: relative;
            }

            .top-right {
                position: absolute;
                right: 10px;
                top: 18px;
            }

            .content {
                text-align: center;
            }

            .title {
                font-size: 45px;
            }

            .links > a {
                color: #636b6f;
                padding: 0 25px;
                font-size: 15px;
                font-weight: 600;
                letter-spacing: .1rem;
                text-decoration: none;
                text-transform: uppercase;

            }

            .m-b-md {
                margin-bottom: 10px;
            }
            .subtittle{
                font-size: 35px;
                margin-bottom: 50px;

            }
            .btn{
                font-size: 44px;
                padding-top: 30px;
                padding-bottom: 30px;
                margin-right: 20px;



            }

        </style>
    </head>
    <body >
        <div class="flex-center position-ref full-height">
            @if (Route::has('login'))
                <div class="top-right links">
                    @auth
                        <a href="{{ url('/GestionDocentes') }}">Inicio</a>
                    @else
                        <a href="{{ route('login') }}">Login</a>

                       <!--if (Route::has('register'))
                            <a href="{ route('register') }}">Registro</a>
                        endif-->
                    @endauth
                </div>
            @endif

            <div class="content">
                <div class="title m-b-md">
                    <img src="{{ asset('imagenes/escudo.png') }}" alt="EscudoEPN" style="float:left;width:128px;height:128px;">
                    ESCUELA DE FORMACIÓN DE TECNÓLOGOS
                   <!-- <img src={{ asset('imagenes/logo.png') }} alt="Escudo EPN" style="float:right;width:100px;height:128px;">-->
                </div>
                <div class="subtittle">
                    ESCUELA POLITÉCNICA NACIONAL
                </div>
                <div id="Inicio" class="carousel slide" data-ride="carousel">
                    <ol class="carousel-indicators">
                        <li data-target="#Inicio" data-slide-to="0" class="active"></li>
                        <li data-target="#Inicio" data-slide-to="1"></li>
                        <li data-target="#Inicio" data-slide-to="2"></li>
                    </ol>
                    <div class="carousel-inner">
                        <div class="carousel-item active">
                            <img src="{{ asset('imagenes/esfotpanoramica.jpg') }}" class="d-block w-100" alt="...">
                        </div>
                        <div class="carousel-item">
                            <img src="{{ asset('imagenes/ASI.jpg') }}" class="d-block w-100" alt="...">
                        </div>
                        <div class="carousel-item">
                            <img src="{{ asset('imagenes/ET.jpg') }}" class="d-block w-100" alt="...">
                        </div>
                    </div>
                    <a class="carousel-control-prev" href="#Inicio" role="button" data-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="sr-only">Previous</span>
                    </a>
                    <a class="carousel-control-next" href="#Inicio" role="button" data-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="sr-only">Next</span>
                    </a>
                </div>

                </div>
        </div>
        <script src="{{ asset('Jquery/jquery-3.4.1.min.js')}}" ></script>
    </body>
</html>
