@extends('layouts.usuario')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card" >
                    <div class="card-header" align="center" style="font-size: xx-large"><u>GESTIÓN DE ASISTENCIA</u>
                    </div>

                    <div class="card-body" align="center">
                        @if(session()->has('success'))
                            <div class="alert alert-success" role="alert">
                                <button type="button" class="close" data-dismiss="alert">&times;</button>
                                {{Session::get('success')}}</div>

                        @endif

                            <form  action="/Asistencia"  method="post" novalidate="" id="FormularioAsistencia">
                                {{csrf_field()}}
                                <div class="col-md-10">
                                    <select name="id_materia" id="id_materia" class="form-control" required >
                                        <option  value="">----Seleccione materia----</option>
                                        @foreach($materias as $materia)
                                            <option value="{{$materia->id_materia}}">{{$materia->materia}}</option>
                                        @endforeach
                                    </select>
                                    <div class="invalid-feedback">Debe seleccionar una materia*</div>

                                </div>
                                <br>
                           <!-- <div class="col-md-10">
                                <select name="capitulo" id="capitulo" class="form-control" required >
                                    <option  value="">----Seleccione Capítulo----</option>
                                    foreach($cronogramas as $cronograma)
                                        <option value="{$cronograma->capitulo}}">{$cronograma->capitulo}}</option>
                                    endforeach
                                </select>
                                <div class="invalid-feedback">Debe seleccionar un capítulo*</div>

                            </div>
                            <br>-->
                            <div class="col-md-10">
                                <select name="tema" id="tema" class="form-control" required >
                                    <option  value="">----Seleccione tema----</option>

                                </select>
                                <div class="invalid-feedback">Debe seleccionar un tema*</div>
                            </div>

                            <br>
                            <div class="col-md-10">
                              <!--  <textarea  class="form-control" name="" id=""  rows="3">{$cronogramas[0]->detalle}}</textarea>-->
                                <textarea  class="form-control" name="detalle" id="detalle"  rows="3"></textarea>
                            </div>
                            <br>
                            <input type="hidden" id="id_cronograma" name="id_cronograma"  value="">
                            <div class="form-group form-check">
                                <input type="checkbox" class="form-check-input" id="id_permiso" value="permiso">
                                <label class="form-check-label" for="exampleCheck1">Permiso</label>
                            </div>
                                <input type="hidden" name="permiso" id="permiso">
                                <input type="hidden" name="hora_registro" id="hora_registro" value="{{ date('H:i:s') }}">
                                <input type="hidden" name="fecha" id="fecha" value="{{ date('Y-m-d') }}">
                        <div>
                            <button type="submit" id="btnSubmit" class="btn btn-success">Guardar</button>
                        </div>
                            </form>
                            <br>
                        <div  class="table-responsive">
                            <!--    <table class="table">
                                  <thead class="thead-dark">
                                  <tr>
                                      <th scope="col">Fecha</th>
                                      <th scope="col">Hora Inicio</th>
                                      <th scope="col">Hora Fin</th>
                                      <th scope="col">Capítulos/Subcapítulos</th>
                                      <th scope="col">Tema</th>
                                      <th scope="col">Detalle de actividades</th>
                                  </tr>
                                  </thead>
                                  <tbody>

                                  </tbody>
                              </table>-->

                             <table class="table">
                                  <thead class="thead-light">
                                  <tr>
                                      <th scope="col">Fecha</th>
                                      <th scope="col">Hora Inicio</th>
                                      <th scope="col">Hora Fin</th>
                                      <th scope="col">Capítulos</th>
                                      <th scope="col">Tema</th>
                                      <th scope="col">Detalle de actividades</th>
                                      <th scope="col">Observación</th>
                                      <th scope="col">Eliminar</th>
                                  </tr>
                                  </thead>
                                  <tbody>
                                  @foreach($asistencias as $asistencia)
                                      <tr>
                                          <td>{{$asistencia->fecha_registro}}</td>
                                          <td>{{$asistencia->hora_inicio}}</td>
                                          <td>{{$asistencia->hora_fin}}</td>
                                          <td>{{$asistencia->capitulo}}</td>
                                          <td>{{$asistencia->tema}}</td>
                                          <td>{{$asistencia->detalle}}</td>
                                          <td>{{$asistencia->observacion}}</td>
                                          <td><form action="/EliminarTema/{{$asistencia->id_asistencia}}" method="POST">
                                                  {{csrf_field()}}
                                                  <input name="_method" type="hidden" value="DELETE">
                                                  <input type="hidden" id="id_cronograma" name="id_cronograma" value="{{$asistencia->id_cronograma}}">
                                                  <button class="btn btn-danger btn-sm" type="submit" onclick="return confirm('Estás seguro que deseas eliminar?');"><i class="fas fa-trash-alt"></i></button>
                                              </form></td>
                                      </tr>
                                      @endforeach

                                  </tbody>
                              </table>
                        </div>

                    </div>
                    <div align="center">
                        <a type="button" style="margin-bottom: 10px; font-size: 25px" href="/docente" class="btn btn-secondary btn-sm" >Regresar</a>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
@section('javascript')

    <script type="text/javascript">
        $(document).on('change','input[type="checkbox"]' ,function(e) {
            if(this.id=="id_permiso") {
                if(this.checked) $('#permiso').val(this.value);
                else $('#permiso').val("");
            }

        });
        $(document).ready(function() {
            $('#id_materia').on('change', function() {
                var materia = $(this).val();
                if(materia) {
                    $.ajax({
                        url: '/Materia/'+materia,
                        type: "GET",
                        data : {"_token":"{{ csrf_token() }}"},
                        dataType: "json",
                        success:function(data) {
                           /// console.log(data);
                            if(data){
                                $('#tema').empty();
                                $('#tema').focus;
                                $('#detalle').val("");
                                $('#id_cronograma').val("");
                                $('#tema').append('<option value="">--Seleccione Tema--</option>');
                                $.each(data, function(id, value){
                                    $('select[name="tema"]').append('<option value="'+ value.id_cronograma +'">' + value.tema+ '</option>');
                                    //$('#detalle').val(value.detalle);

                                });

                            }else{
                                $('#tema').empty();
                                $('#id_cronograma').val("");
                            }
                        }
                    });
                }else{
                    $('#tema').empty();
                    $('#id_cronograma').val("");

                }


            });

            $('#tema').on('change', function() {
                var tema = $(this).val();
                console.log(tema);
                if(tema) {
                    $.ajax({
                        url: '/Tema/'+tema,
                        type: "GET",
                        data : {"_token":"{{ csrf_token() }}"},
                        dataType: "json",
                        success:function(data) {
                           // console.log(data);
                            if(data){
                                $('#detalle').val("");

                               // $('#detalle').val(data[0]["detalle"]);
                                $.each(data, function(id, value){
                                    $('#id_cronograma').val(value.id_cronograma);
                                    $('#detalle').val(value.detalle);
                                });

                            }else{
                                $('#detalle').val("");
                            }
                        }
                    });
                }else{
                    $('#detalle').val("");
                }


            });

            $("#btnSubmit").click(function(event) {
                var form = $("#FormularioAsistencia");

                if (form[0].checkValidity() === false) {
                    event.preventDefault()
                    event.stopPropagation()

                }else{
                    remover();
                }
                form.addClass('was-validated');
            });



            function remover() {
                if(!confirm("Esta seguro!!"))
                    event.preventDefault();
            };


        });


    </script>
@endsection