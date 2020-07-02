@extends('layouts.usuario')
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div >
                <div class="card">
                    <div class="card-header" align="center" style="font-size: xx-large">GESTIÓN PROYECTORES</div>
                    <div class="card-body">
                        @if(session()->has('success'))
                            <div class="alert alert-success" role="alert">
                                <button type="button" class="close" data-dismiss="alert">&times;</button>
                                {{Session::get('success')}}</div>

                        @endif
                        @if($proyectores->isEmpty())
                            <center><h3>No existen proyectores registrados!!!</h3></center>
                            <div align="right">
                                <a role="button" class="btn btn-success" href="{{url('/NuevoProyector')}}">Nuevo</a>
                            </div>
                        @else
                                <div class="table-responsive">
                                <table class="table" id="tbl_proyectores">
                                    <thead class="thead-light">
                                    <tr>
                                        <th>#</th>
                                        <th class="text-center">Proyector</th>
                                        <th class="text-center">Serie</th>
                                        <th class="text-center">Componentes</th>
                                        <th class="text-center">Descripción</th>
                                        <th class="text-center">Editar</th>
                                        <th class="text-center">Estado</th>
                                        <th class="text-center">Acción</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($proyectores as $proyector)
                                        <tr>
                                            <th scope="row" style="font-size: small">{{$proyector->id_proyector}}</th>
                                            <td  class="text-center"  style="font-size: small" >{{$proyector->proyector}}</td>
                                            <td class="text-center"  style="font-size: small" >{{$proyector->serie}}</td>
                                            <td  style="font-size: small" >{{$proyector->componentes}}</td>
                                            <td   style="font-size: small" >{{$proyector->estado_dev->descripcion}}</td>
                                            <td class="text-center"><a class="btn btn-primary btn-sm" href="/EditarProyectorAdministrador/{{$proyector->id_proyector }}/edit"><i class="fas fa-edit"></i></a></td>
                                            <td class="text-center"><!--<input id="toggle-event" type="checkbox"  data-on="Activo" data-off="Inactivo" data-onstyle="outline-dark" data-width="100" value="{{$proyector->estado}}" data-offstyle="outline-info" checked data-toggle="toggle">-->
                                                <input data-id="{{$proyector->id_proyector}}" class="toggle-class" type="checkbox" data-onstyle="outline-success" data-offstyle="outline-dark"  data-width="85" data-height="10" data-toggle="toggle" data-on="Bueno" data-off="Dañado" {{$proyector->estado_activo ? 'checked':''}}>
                                            </td>
                                            <td class="text-center"><form action="/AbrirAdministrador" method="post">
                                                    {{csrf_field()}}
                                                    <input type="hidden" id="id_proyector" name="id_proyector" value="{{$proyector->id_proyector }}">
                                                    <button class="btn btn-secondary btn-sm" type="submit" onclick="remover()">Abrir</button>
                                                </form></td>
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
    <link href="{{asset('Bootstrap4Toogle/css/bootstrap4-toggle.css')}}" rel="stylesheet">
    <script src="{{asset('Bootstrap4Toogle/js/bootstrap4-toggle.js')}}"></script>
   <!-- <script type="text/javascript" charset="utf8" src="{{asset('/DataTables/datatables.js')}}"></script>-->
    <script type="text/javascript">
      /*  $(document).ready( function () {


            $('#tbl_proyectores').DataTable({
                destroy: true,
                searching: true,
                ordering:  true,
                stateSave: true,
                "language": {
                    "lengthMenu": "Mostrar _MENU_ entradas",
                    "zeroRecords": "No se ha encontrado resultados",
                    "info": "Mostrándo página _PAGE_ de _PAGES_",
                    "sInfo":  "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
                    "infoEmpty": "No hay registros disponibles",
                    "infoFiltered": "(filtered from _MAX_ total records)",
                    "search": "Buscar:",
                    "paginate": {
                        "first":      "Primero",
                        "last":       "Último",
                        "next":       "Siguiente",
                        "previous":   "Anterior"

                    }
                }
            });

        } );
*/

        $(function() {
            $('.toggle-class').change(function(event) {
                var estado_activo = $(this).prop('checked') == true ? 1 : 0;
                var id_proyector = $(this).data('id');
                if ($(this).is(':checked')) {
                    console.log("power on");
                    Cambio_poryector(estado_activo,id_proyector);

                } else {

                    if (!confirm("Esta seguro de Inhabilitar el proyector?")) {
                        event.preventDefault();
                        location.reload();
                    }else{
                        Cambio_poryector(estado_activo,id_proyector);
                    }
                }

            })
        })
        function Cambio_poryector(estado_activo,id_proyector) {
            $.ajax({
                type: "GET",
                dataType: "json",
                url: '/CambioEstadoAdministrador',
                data: {'estado_activo': estado_activo, 'id_proyector': id_proyector},
                success: function(data){
                    toastr.options.closeButton = true;
                    toastr.options.closeMethod = 'fadeOut';
                    toastr.options.closeDuration = 100;
                    toastr.success(data.message);
                }
            });

        }
        function remover() {
            if(!confirm("Esta seguro!!"))
                event.preventDefault();
        };

    </script>
@endsection



