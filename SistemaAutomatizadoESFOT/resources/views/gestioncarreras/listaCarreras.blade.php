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
                    <div class="card-header" align="center" style="font-size: xx-large">GESTIÓN CARRERAS</div>

                    <div class="card-body">
                        @if(session()->has('success'))
                            <div class="alert alert-success" role="alert">
                                <button type="button" class="close" data-dismiss="alert">&times;</button>
                                {{Session::get('success')}}</div>

                        @endif
                        @if($carreras->isEmpty())
                            <center><h3>No existen carreras registradas!!!</h3></center>
                            <div align="right">
                                <a role="button" class="btn btn-success" href="{{url('/NuevaCarrera')}}">Nuevo</a>
                            </div>
                        @else
                            <div class="table-responsive">
                                <div align="right">
                                    <a  role="button"  class="btn btn-success btn-sm" href="{{url('/NuevaCarrera')}}">Nuevo</a>

                                </div>
                                <br>

                                <table class="table" id="tbl_docentes">
                                    <thead class="thead-light">
                                    <tr>
                                        <th>#</th>
                                        <th>Carrera</th>
                                        <th class="text-center">Estado</th>
                                        <th class="text-center">Editar</th>
                                        <th class="text-center">Eliminar</th>

                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($carreras as $carrera)
                                        <tr>
                                            <th scope="row">{{$carrera->id_carrera}}</th>
                                            <td>{{$carrera->carrera}}</td>
                                            <td class="text-center">
                                                <input  data-id="{{$carrera->id_carrera}}"  id="check" class="toggle-class" type="checkbox" data-onstyle="outline-success"  data-toggle="toggle"
                                                        data-width="95" data-height="10" data-on="Activo" data-off="Inactivo" {{$carrera->estado ? 'checked':''}}   >
                                            </td>
                                            <td class="text-center"><a class="btn btn-primary btn-sm" href="/EditarCarrera/{{$carrera->id_carrera}}/edit"><i class="fas fa-edit"></i></a></td>

                                            <td class="text-center">
                                                <form action="/EliminarCarrera/{{$carrera->id_carrera}}" method="POST">
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
                    Cambio_estado_carrera(estado,id);

                } else {

                    if (!confirm("Esta seguro de Inactivar la carrera?")) {
                        event.preventDefault();
                        location.reload();
                    }else{
                        Cambio_estado_carrera(estado,id);
                    }
                }
                //location.reload();
            })

        })
        function Cambio_estado_carrera(estado,id) {
            $.ajax({
                type: "GET",
                dataType: "json",
                url: '/CambioEstadoCarrera',
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
