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
                    <div class="card-header" align="center" style="font-size: xx-large">GESTIÓN DOCENTES</div>

                    <div class="card-body">
                            @if(session()->has('success'))
                                <div class="alert alert-success" role="alert">
                                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                                    {{Session::get('success')}}</div>

                            @endif
                            @if($usuarios->isEmpty())
                                <center><h3>No existen docentes registrados!!!</h3></center>
                                <div align="right">
                                    <a role="button" class="btn btn-info " href="{{url('/GestionBiometricoUsuarios')}}">Agregar</a>
                                    <a role="button" class="btn btn-success" href="{{url('/NuevoDocente')}}">Nuevo</a>
                                </div>
                            @else
                        <div class="table-responsive">
                            <div align="right">
                                <a role="button"  class="btn btn-primary btn-sm" href="{{url('/GestionBiometricoUsuarios')}}">Agregar</a>
                                <a  role="button"  class="btn btn-success btn-sm" href="{{url('/NuevoDocente')}}">Nuevo</a>

                            </div>
                            <br>

                            <table class="table" id="tbl_docentes">
                                <thead class="thead-light">
                                <tr>
                                    <th>#</th>
                                    <th>Nombre</th>
                                    <th>Correo Electrónico</th>
                                    <th>Id-Biométrico</th>
                                    <th>Tipo</th>
                                    <th>Cronograma</th>
                                    <th>Editar</th>
                                <!--  <th>Eliminar</th>-->
                                    <th>Estado</th>

                                </tr>
                                </thead>
                                <tbody>
                                @foreach($usuarios as $usuario)
                                <tr>
                                    <th scope="row">{{$usuario->id}}</th>
                                    <!--<td>{\App\Http\Controllers\GestionDocentes\GestionDocentesController::EstadoDocente($usuario->estado)}
                                    <a type="text" >{\App\Http\Controllers\GestionDocentes\GestionDocentesController::EstadoDocente($usuario->estado)}</a></td>-->
                                    <td>{{$usuario->name}}</td>
                                    <td>{{$usuario->email}}</td>
                                    <td class="text-center">{{$usuario->id_biometrico}}</td>
                                    <td>{{$usuario->roles_usuarios[0]->rol}}</td>


                                    @if($usuario->tipo_rol==2 )
                                        <td class="text-center"><a class="btn btn-secondary btn-sm estado" data-estado="{{$usuario->estado}}" href="/GestionCronograma/{{$usuario->id}}">Sílabo</a></td>

                                    @else
                                        <td class="text-center"></td>
                                    @endif
                                    <td class="text-center"><a class="btn btn-primary btn-sm" href="/EditarDocente/{{$usuario->id }}/edit"><i class="fas fa-edit"></i></a></td>
                                 <!--    <td class="text-center">
                                        <form action="/EliminarDocente/{{$usuario->id}}" method="post">
                                            {{csrf_field()}}
                                            <button class="btn btn-danger btn-sm" type="submit" onclick="return confirm('Estás seguro que deseas eliminar?');"><i class="fas fa-trash-alt"></i></button>
                                        </form>
                                    </td>-->
                                    <td class="text-center">
                                        <input  data-id="{{$usuario->id}}"  id="check" class="toggle-class" type="checkbox" data-onstyle="outline-success"  data-toggle="toggle"
                                                data-width="85" data-height="10" data-on="Activo" data-off="Inactivo" {{$usuario->estado ? 'checked':''}}   >


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
      /*  $(document).ready(function () {
                    document.getElementById('check').addEventListener('change', function(e) {
                        if (this.checked) {
                            console.log("power on");
                        } else {
                            if (!confirm("This will shutdown power! Are you sure?")) {
                                this.checked = true;
                            }
                        };
                    });

            })*/

       $(function() {
            $('.toggle-class').on('change.bootstrapSwitch',function(event) {
                var estado = $(this).prop('checked') === true ? 1 : 0;
                var id= $(this).data('id');
                console.log(id);
                console.log(estado);
                if ($(this).is(':checked')) {
                    console.log("power on");
                    Cambio_docente(estado,id);

                } else {

                    if (!confirm("Esta seguro de Inactivar al docente?")) {
                        event.preventDefault();
                        location.reload();
                    }else{
                       Cambio_docente(estado,id);
                    }
                }
                                //location.reload();
            })

        })

      function Cambio_docente(estado,id) {
          $.ajax({
              type: "GET",
              dataType: "json",
              url: '/cambio_docente',
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





