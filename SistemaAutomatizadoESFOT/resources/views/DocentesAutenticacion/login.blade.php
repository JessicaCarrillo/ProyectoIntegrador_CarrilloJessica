<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Sistema-ESFOT</title>
    <script src="{{ asset('Bootstrap/js/bootstrap.js')}}" defer></script>


    <!-- Fonts
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">-->

    <!-- Styles -->
    <link rel="stylesheet" href="{{asset('Bootstrap/css/bootstrap.css') }}">
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
            font-size: 3.5vw;
        }

        .links > a {
            color: #636b6f;
            padding: 0 25px;
            font-size: 13px;
            font-weight: 600;
            letter-spacing: .1rem;
            text-decoration: none;
            text-transform: uppercase;

        }

        .m-b-md {
            margin-bottom: 10px;
        }
        .subtittle{
            font-size: 2.5vw;
            margin-bottom: 25px;

        }


    </style>
</head>
<body>
<div class="flex-center position-ref full-height">
    @if (Route::has('login'))
        <div class="top-right links">
            @auth
                <!--<a href="{ url('/home') }}">Home</a>-->
                <a href="{{ url('/docente.login') }}">Home</a>
           <!-- else
                <a href="{ route('login') }}">Login</a>

                if (Route::has('register'))
                    <a href="{ route('register') }}">Registro</a>
                endif-->
            @endauth
        </div>
    @endif


    <div class="content">
        <div class="title m-b-md">
            <img src={{ asset('imagenes/escudo.png') }}  style="float:left;width:128px;height:128px;">
            ESCUELA DE FORMACIÓN DE TECNÓLOGOS
        <!-- <img src={ asset('imagenes/logo.png') }} alt="Escudo EPN" style="float:right;width:100px;height:128px;">-->
        </div>
        <div class="subtittle">
            ESCUELA POLITÉCNICA NACIONAL
        </div>
        @if($errors->any())
            <div class=" alert alert-danger alert-dismissible "  role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
                <div class="alert-text">
                    @foreach($errors->all() as $error)
                        <span>{{$error}}</span>
                    @endforeach
                </div>
            </div>

        @endif
        <div class="card-body">
            <form method="POST"  action="{{ route('docente.login.submit') }}" name="envia">
                @csrf

                <div class="form-group row">
                  <!-- <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>-->

                    <div class="col-md-12">
                        <img src="{{ asset('imagenes/portada.gif') }}" width="200" height="250" border="0">
                      <!-- <input id="email" type="email" class="form-control error('email') is-invalid enderror"  name="email" value="{ old('email') }}" required autocomplete="email" autofocus>-->
                       <input  type="hidden" class="form-control @error('id_biometrico') is-invalid @enderror"  name="id_biometrico"  id="id_biometrico" value="">

                        @error('id_biometrico')
                        <span class="invalid-feedback" role="alert">
                                        <strong>Estas credenciales no concuerdan</strong>
                                    </span>
                        @enderror
                        <!--!! $errors->first('id_biometrico','<small style="color:Red;">Estas credenciales no concuerdan</small>')!!}-->
                    </div>
                </div>


              <!--  <div class="form-group row">
                    <div class="col-md-6 offset-md-4">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                            <label class="form-check-label" for="remember">
                                {{ __('Remember Me') }}
                            </label>
                        </div>
                    </div>
                </div>-->

                <div class="form-group row mb-0">
                    <div class="col-md-8 offset-md-4">
                    <!--    <button type="submit" class="btn btn-primary">
                            { __('Login') }}
                        </button>-->
                       <!-- <div class="button">

                         <button id="submit" class="btn btn-primary">
                                {{ __('Login') }}
                            </button>
                        </div>-->


                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<script src="{{ asset('Jquery/jquery-3.4.1.min.js')}}" ></script>
<script>
    $(document).ready(function(){


                $.ajax({
                    url: '/GestionBiometricologin/',
                    type: "GET",
                    data : {"_token":"{{ csrf_token() }}"},
                    dataType: "json",
                    success:function(data) {
                        console.log("si");
                        var t=data['id_biometrico'];
                        $("#id_biometrico").val(data['id_biometrico']);
                       /* if( data['id_biometrico']!=0){
                            $("#id_biometrico").val(data['id_biometrico']);
                        }*/


                    }
                });

        function cambio(){
            $.ajax({
                url: '/cambio_login/',
                type: "GET",
                data : {"_token":"{{ csrf_token() }}"},
                dataType: "json",
                success:function(data) {
                    //console.log(data);

                }
            });


        }
        function estados(){
            $.ajax({
                url: '/GestionBiometricologin/',
                type: "GET",
                data : {"_token":"{ csrf_token() }}"},
                dataType: "json",
                success:function(data) {
                    console.log("si");
                    console.log(data);
                     if( data['id_biometrico']!=0){
                         $("#id_biometrico").val(data['id_biometrico']);
                     }


                }
            });
            var x= document.getElementById("id_biometrico").value;
            console.log(x);
            if(x!=0){
                document.envia.submit();
                cambio();
                myStopFunction();


            }else if(x==""){
                swal({
                    title: "No existen registros",
                    text: "Pida registrarse",
                    icon: "warning",
                    dangerMode: true,
                    closeOnClickOutside: false,
                })
                cambio();
            }

        }


    var myVar = setInterval(estados, 1000);
    function myStopFunction() {
        clearInterval(myVar);
    };



    });


   // document.envia.submit()
</script>

</body>
</html>
