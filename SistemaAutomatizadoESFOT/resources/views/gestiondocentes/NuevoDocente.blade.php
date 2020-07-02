@extends('layouts.administrador')
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header" align="center" style="font-size: xx-large">NUEVO DOCENTE</div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                            <form  action="/NuevoDocente"  method="post">
                                {{csrf_field()}}
                                <div class="form-group">
                                    <label for="id_biometrico">ID-Biométrico:</label>
                                    <input id="id_biometrico" name="id_biometrico" class="form-control" type="text" placeholder="id-biométrico" value="{{ old('id_biometrico') }}">
                                    {!! $errors->first('id_biometrico','<small style="color:Red;">:message</small>')!!}
                                </div>
                                <div class="form-group">
                                    <label for="name">Nombres:</label>
                                    <input id="name" name="name" class="form-control" type="text" placeholder="nombre docente" value="{{ old('name') }}" >
                                    {!! $errors->first('name','<small style="color:Red;">:message</small>')!!}
                                </div>
                                <div class="form-group">
                                    <label for="email">Correo Electrónico:</label>
                                    <input type="email" class="form-control" id="email" name="email" aria-describedby="emailHelp" placeholder="correo electrónico" value="{{ old('email') }}">
                                    {!! $errors->first('email','<small style="color:Red;">:message</small>')!!}
                                </div>
                                <div class="form-group">
                                    <label for="password">Contraseña:</label>
                                    <input type="password" id="password" name="password" class="form-control" placeholder="Contraseña">
                                    {!! $errors->first('password','<small style="color:Red;">:message</small>')!!}
                                </div>
                                <div class="form-group">
                                    <label for="password">Tipo usuario:</label>
                                    <select name="tipo_rol" id="tipo_rol" class="form-control" value="{{old('tipo_rol')}}" >
                                        <option value="">-----Seleccione rol-----</option>
                                        @foreach($roles as $rol)
                                            <option  value="{{$rol->id_rol}}" {{ (old('tipo_rol') ==$rol->id_rol ? 'selected="selected"' : "") }}>{{$rol->rol}}</option>
                                        @endforeach
                                    </select>
                                    {!! $errors->first('tipo_rol','<small style="color:Red;">:message</small>')!!}
                                </div>
                            <!--    <div class="form-group">
                                    <label for="Huella">Huella Digital:</label>
                                    <input class="form-control" type="text" placeholder="">
                                </div>-->
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

