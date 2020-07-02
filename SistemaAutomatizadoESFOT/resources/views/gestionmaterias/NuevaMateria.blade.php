@extends('layouts.administrador')
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header" align="center" style="font-size: xx-large">NUEVA MATERIA</div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                        <form  action="/NuevaMateria"  method="post">
                            {{csrf_field()}}
                            <div class="form-group">
                                <label for="materia">Materia:</label>
                                <input id="materia" name="materia" class="form-control" type="text" placeholder="Nombre de materia" value="{{ old('materia') }}">
                                {!! $errors->first('materia','<small style="color:Red;">:message</small>')!!}

                            </div>
                            <div class="form-group">
                                <label for="materia">Carrera:</label>

                                <select name="id_carrera_fk" id="id_carrera_fk" class="form-control " >
                                    <option value="">--Seleccione carrera--</option>
                                    @foreach($carreras as $carrera)
                                        <option value="{{$carrera->id_carrera}}">{{$carrera->carrera}}</option>
                                    @endforeach
                                </select>
                                {!! $errors->first('id_carrera_fk','<small style="color:Red;">:message</small>')!!}

                            </div>

                            <div class="form-group" align="center">
                                <button type="submit" class="btn btn-primary">Guardar</button>
                            </div>
                        </form>


                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection


