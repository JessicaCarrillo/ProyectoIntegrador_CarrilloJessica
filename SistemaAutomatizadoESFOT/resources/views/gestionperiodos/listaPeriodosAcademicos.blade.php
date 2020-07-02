@extends('layouts.administrador')
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card">
                    <div class="card-header" align="center" style="font-size: xx-large">GESTIÓN PERÍODOS</div>

                    <div class="card-body">
                    <!--if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        endif-->
                        @if(session()->has('success'))
                            <div class="alert alert-success" role="alert">
                                <button type="button" class="close" data-dismiss="alert">&times;</button>
                                {{Session::get('success')}}</div>

                        @endif
                        @if($periodos->isEmpty())
                            <center><h3>No existen periodos registrados!!!</h3></center>
                            <div align="right">
                                <a type="button" class="btn btn-success btn-sm" href="{{url('/NuevoPeriodo')}}">Nuevo</a>
                            </div>
                        @else
                            <div class="table-responsive">
                                <div align="right">
                                    <a  class="btn btn-success btn-sm" href="{{url('/NuevoPeriodo')}}">Nuevo</a>
                                </div>
                                <br>

                                <table class="table" id="tbl_docentes">
                                    <thead class="thead-light">
                                    <tr>
                                        <th>#</th>
                                        <th>Período</th>
                                        <th>Fecha Inicio</th>
                                        <th>Fecha Fin</th>
                                        <th class="text-center">Editar</th>
                                        <th class="text-center">Eliminar</th>

                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($periodos as $periodo)
                                        <tr>
                                        <th>{{$periodo->id_periodo}}</th>
                                        <td>{{$periodo->periodo}}</td>
                                        <td>{{$periodo->fecha_inicio}}</td>
                                        <td>{{$periodo->fecha_fin}}</td>
                                        <td class="text-center"><a class="btn btn-primary btn-sm" href="/EditarPeriodo/{{$periodo->id_periodo}}/edit"><i class="fas fa-edit"></i></a></td>
                                        <td class="text-center">
                                            <form action="/Eliminar/{{$periodo->id_periodo}}" method="POST">
                                                {{csrf_field()}}
                                                <input name="_method" type="hidden" value="DELETE">
                                                <button class="btn btn-danger btn-sm" type="submit" onclick="return confirm('Estás seguro que deseas eliminar?');"><i class="fas fa-trash-alt"></i></button>
                                            </form>
                                        </td>
                                        </tr>
                                        @endforeach

                                    </tbody>
                                </table>

                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

