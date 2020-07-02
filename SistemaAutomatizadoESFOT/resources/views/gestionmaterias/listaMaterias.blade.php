@extends('layouts.administrador')

@section('estilo')
    <style>
        .estado[data-estado='0'] {
            opacity: 0.6 !important; /* Fade effect */
            cursor: not-allowed;
            pointer-events: none;

        }
    </style>
@endsection
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header" align="center" style="font-size: xx-large">GESTIÓN MATERIAS</div>

                    <div class="card-body">
                        @if(session()->has('success'))
                            <div class="alert alert-success" role="alert">
                                <button type="button" class="close" data-dismiss="alert">&times;</button>
                                {{Session::get('success')}}</div>

                        @endif
                        @if($materias->isEmpty())
                            <center><h3>No existen materias registradas!!!</h3></center>
                            <div align="right">
                                <a role="button" class="btn btn-success" href="{{url('/NuevaMateria')}}">Nuevo</a>
                            </div>
                        @else
                            <div class="table-responsive">
                                <div align="right">
                                    <a  role="button"  class="btn btn-success btn-sm" href="{{url('/NuevaMateria')}}">Nuevo</a>

                                </div>
                                <br>

                                <table class="table" id="tbl_docentes">
                                    <thead class="thead-light">
                                    <tr>
                                        <th>#</th>
                                        <th>Materia</th>
                                        <th>Carrera</th>
                                        <th class="text-center">Estado</th>
                                        <th class="text-center">Editar</th>
                                        <th class="text-center">Eliminar</th>

                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($materias as $materia)
                                        <tr>
                                            <th scope="row">{{$materia->id_materia}}</th>
                                            <td>{{$materia->materia}}</td>
                                            <td>{{$materia->materias->carrera}}</td>
                                            <td class="text-center">
                                                <input  data-id="{{$materia->id_materia}}"  id="check" class="toggle-class" type="checkbox" data-onstyle="outline-success"  data-toggle="toggle"
                                                        data-width="95" data-height="10" data-on="Activo" data-off="Inactivo" {{$materia->estado ? 'checked':''}}   >
                                            </td>
                                            <td class="text-center"><a class="btn btn-primary btn-sm" href="/EditarMateria/{{$materia->id_materia}}/edit"><i class="fas fa-edit"></i></a></td>

                                            <td class="text-center">
                                                <form action="/EliminarMateria/{{$materia->id_materia}}" method="POST">
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
@section('javascript')
    <link href="{{ asset('Toastr/toastr.min.css')}}" rel="stylesheet">
    <script src="{{ asset('Toastr/toastr.min.js') }}" ></script>


    <script type="text/javascript">
        $(function() {
            $('.toggle-class').on('change.bootstrapSwitch',function(event) {
                var estado = $(this).prop('checked') === true ? 1 : 0;
                var id= $(this).data('id');
                console.log(id);
                console.log(estado);
                if ($(this).is(':checked')) {
                    console.log("power on");
                    Cambio_estado_materia(estado,id);

                } else {

                    if (!confirm("Esta seguro de Inactivar la materia?")) {
                        event.preventDefault();
                        location.reload();
                    }else{
                        Cambio_estado_materia(estado,id);
                    }
                }
                //location.reload();
            })

        })
        function Cambio_estado_materia(estado,id) {
            $.ajax({
                type: "GET",
                dataType: "json",
                url: '/CambioEstadoMateria',
                data: {'estado': estado, 'id': id},
                success: function(data){
                    toastr.options.closeButton = true;
                    toastr.options.closeMethod = 'fadeOut';
                    toastr.options.closeDuration = 100;
                    toastr.success(data.message);
                }
            });

        }
    </script>
@endsection
