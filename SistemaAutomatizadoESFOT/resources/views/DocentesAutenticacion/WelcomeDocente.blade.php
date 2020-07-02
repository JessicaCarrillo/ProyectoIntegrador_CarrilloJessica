@extends('layouts.usuario')
@section('content')

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card">


                    <div class="card-header" align="center" style="font-size: 45px"><u>Bienvenid@: <strong>{{ Auth::guard('docente')->user()->name }} </strong></u>
                    <!--  <div class="card-header" align="center" style="font-size: xx-large"><u>GESTIÓN DE PROYECTORES</u>
                       <h3>Bienvenid@:   { Auth::user()->name }} </h3>-->
                    </div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif
                            @if(Auth::user()->hasRole('Docente'))
                            <div class="button" align="center">
                                <a style="font-size: 30px;padding-top: 30px;border-bottom-width: 20px;padding-bottom: 30px;" type="submit" class="btn btn-danger" href="{{ route('docente.GestionProyector') }}" >Gestión Proyectores</a>
                                <a style="font-size: 30px;padding-top: 30px;border-bottom-width: 20px;padding-bottom: 30px;" type="submit" class="btn btn-primary" href="{{ route('docente.GestionAsistencia') }}">Gestión Asistencia</a>
                                </div>
                        @endif
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection
@section('javascript')
    <link rel="stylesheet" href="{{ asset('JqueyConfirm/jquery-confirm.min.css')}}">
    <script src="{{ asset('JqueyConfirm/jquery-confirm.min.js')}}"></script>

    <script type="text/javascript">

        </script>
@endsection



