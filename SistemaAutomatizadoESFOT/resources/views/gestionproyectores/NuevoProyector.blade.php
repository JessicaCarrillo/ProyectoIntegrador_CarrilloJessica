@extends('layouts.administrador')
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header" align="center" style="font-size: xx-large">NUEVO PROYECTOR</div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                        <form  action="/NuevoProyector"  method="post">
                            {{csrf_field()}}
                            <div class="form-group">
                                <label for="proyector">Nombre Proyector:</label>
                                <input id="proyector" name="proyector" class="form-control" type="text" placeholder="Proyector N°">
                                {!! $errors->first('proyector','<small style="color:Red;">:message</small>')!!}

                            </div>
                            <div class="form-group">
                                <label for="name">Descripcion:</label>
                                <select name="id_estado_devolucion" id="id_estado_devolucion" class="form-control"  >
                                    <option value="">--Seleccione el estado--</option>
                                    @foreach($estados_devolucion as $estado_devolucion)
                                        <option value="{{$estado_devolucion['id_estado']}}">{{$estado_devolucion['descripcion']}}</option>
                                    @endforeach
                                </select>
                                {!! $errors->first('id_estado_devolucion','<small style="color:Red;">:message</small>')!!}
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

