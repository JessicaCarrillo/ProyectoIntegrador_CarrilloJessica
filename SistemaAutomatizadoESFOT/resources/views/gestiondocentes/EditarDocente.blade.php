@extends('layouts.administrador')
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header" align="center" style="font-size: xx-large">EDITAR USUARIO</div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                        <form  action="/EditarDocente/{{$docentes->id}}"  method="post">
                            <input type="hidden" name="_token" value="{{csrf_token()}}">
                            {{ method_field('PUT') }}
                            <div class="form-group">
                                <label for="id_biometrico">ID-Biométrico:</label>
                                <input id="id_biometrico" name="id_biometrico" class="form-control" type="text" placeholder="id-biométrico" value="{{$docentes->id_biometrico}}">
                                {!! $errors->first('id_biometrico','<small style="color:Red;">:message</small>')!!}
                            </div>
                            <div class="form-group">
                                <label for="name">Nombres:</label>
                                <input id="name" name="name" class="form-control" type="text" placeholder="nombre docente" value="{{$docentes->name}}">
                                {!! $errors->first('name','<small style="color:Red;">:message</small>')!!}
                            </div>
                            <div class="form-group">
                                <label for="email">Correo Electrónico:</label>
                                <input type="email" class="form-control" id="email" name="email" aria-describedby="emailHelp" placeholder="correo electrónico" value="{{$docentes->email}}">
                                {!! $errors->first('email','<small style="color:Red;">:message</small>')!!}
                            </div>
                            <div class="form-group">
                                <label for="password">Contraseña:</label>
                                <input type="password" id="password" name="password" class="form-control" placeholder="Contraseña" value="">
                                {!! $errors->first('password','<small style="color:Red;">:message</small>')!!}
                            </div>
                            <div class="form-group">
                                <label for="password">Tipo usuario:</label>
                                <select name="tipo_rol" id="tipo_rol" class="form-control" >
                                    <option value="{{$docentes->roles_usuarios[0]->id_rol}}">{{$docentes->roles_usuarios[0]->rol}}</option>
                                    @foreach($roles as $rol)
                                        <option value="{{$rol->id_rol}}">{{$rol->rol}}</option>
                                    @endforeach
                                </select>
                                {!! $errors->first('tipo_rol','<small style="color:Red;">:message</small>')!!}
                            </div>
                         <!--   <div class="form-group">
                                <label for="Huella">Huella Digital:</label>
                                <input class="form-control" type="text" placeholder="">
                            </div>-->
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

