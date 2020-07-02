@extends('layouts.administrador')
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header" align="center" style="font-size: xx-large">EDITAR CARRERA</div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                        <form  action="/EditarCarrera/{{$carreras->id_carrera}}"  method="post">
                            <input type="hidden" name="_token" value="{{csrf_token()}}">
                            {{ method_field('PUT') }}
                            <div class="form-group">
                                <label for="carrera">Carrera:</label>
                                <input id="carrera" name="carrera" class="form-control" type="text" placeholder="Nombre de carrera" value="{{$carreras->carrera}}">
                                {!! $errors->first('carrera','<small style="color:Red;">:message</small>')!!}


                            </div>

                            <div class="form-group" align="center">
                                <button type="submit" class="btn btn-primary">Actualizar</button>
                            </div>
                        </form>


                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('javascript')

    <script type="text/javascript">


    </script>
@endsection

