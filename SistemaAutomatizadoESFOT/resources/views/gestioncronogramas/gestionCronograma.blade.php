@extends('layouts.administrador')
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="">
                <div class="card">
                    <div class="card-header" align="center" style="font-size: xx-large">CRONOGRAMA</div>
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
                            <center><h3>Es necesario ingresar períodos académicos!!!</h3>
                                <div align="right">
                                    <a type="button" class="btn btn-success btn-sm" href="{{url('/NuevoPeriodo')}}">Nuevo</a>
                                </div>
                        @else
                                    @if($cronogramas->isEmpty())
                                        <center><h3>No exiten cronogramas registrados!!!</h3>
                                        <h4>Es necesario subir archivo mediante el siguiente formato <a role="button" class="btn btn-success btn-sm" href="{{ asset('Documents/FormatoCronograma.xlsx') }}">Descargar</a>
                                        </h4></center>

                                <div class="text-center" >
                                    <form action="{{route('import')}}" method="post" id="subir" enctype="multipart/form-data">
                                        {{csrf_field()}}
                                        <br>
                                        <center  >
                                        <select name="id_periodo" id="id_periodo" class="form-control col-md-6" >
                                            <option value="">--Seleccione período--</option>
                                            @foreach($periodos as $periodo)
                                                <option value="{{$periodo->id_periodo}}">{{$periodo->periodo}}</option>
                                            @endforeach
                                        </select>

                                        </center>
                                        {!! $errors->first('id_periodo','<small style="color:Red;">:message</small>')!!}
                                        <br>
                                        <center  >
                                            <select name="id_carrera" id="id_carrera" class="form-control col-md-6" >
                                                <option value="">--Seleccione carrera--</option>
                                                @foreach($carreras as $carrera)
                                                    <option value="{{$carrera->id_carrera}}">{{$carrera->carrera}}</option>
                                                @endforeach
                                            </select>
                                        </center>
                                        {!! $errors->first('id_carrera','<small style="color:Red;">:message</small>')!!}
                                        <br>

                                        <center  >
                                            <select name="id_materia" id="id_materia" class="form-control col-md-6" >
                                                <option value="">--Seleccione materia--</option>
                                            </select>
                                        </center>
                                        {!! $errors->first('id_materia','<small style="color:Red;">:message</small>')!!}
                                        <br>
                                        <input type="file"  name="file"  >
                                        <button class="btn btn-outline-secondary" >Subir</button>
                                        <input type="hidden" id="id_docente" name="id_docente" value="{{$docentes->id}}">
                                        <input type="hidden" id="estado_mensaje" name="estado_mensaje" value="0">
                                        <br>
                                        {!! $errors->first('file','<small style="color:Red;">:message</small>')!!}
                                    </form>
                                </div>
                                @else

                            <div class="table-responsive">
                                <form  method="POST"  action="/EliminarCronograma" >
                                    {{csrf_field()}}
                                    <input name="_method" type="hidden" value="DELETE">
                                    <div align="center">

                                        <select name="busqueda" id="busqueda" class="form-control col-md-6" >
                                            <option  value="">-----Seleccione período-----</option>
                                            @foreach($periodos as $periodo)
                                                <option value="{{$periodo->id_periodo}}">{{$periodo->periodo}}</option>
                                            @endforeach
                                        </select>
                                        <input type="hidden" id="id_do" name="id_do" value="{{$docentes->id}}">
                                        <div align="right">
                                            <a role="button" class="btn btn-success btn-sm " id="agregar" style="display: inline-block;width: 118px;" href="/GestionSubirCronograma/{{$docentes->id}}">Agregar</a>

                                            <input type="hidden" id="id_cronograma" name="id_cronograma[]" >
                                            <button  id="eliminar"   class="btn btn-danger btn-sm" type="submit">Eliminar</button>
                                        </div>

                                    </div>
                                <br>
                                <table class="table" id="tbl_cronograma" >
                                    <thead class="thead-light">
                                    <tr>
                                        <th><input type="checkbox" class="todo" onclick="marcar(this);"/></th>
                                        <th>Fecha</th>
                                        <th>Hora Inicio</th>
                                        <th>Hora Fin</th>
                                        <th>Capítulos</th>
                                        <th>Tema</th>
                                        <th>Detalle de Actividades</th>
                                        <th>Materia</th>
                                        <th>Carrera</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                       <!--     foreach($cronogramas as $cronograma)
                                        <tr>
                                            <td><input type="checkbox" id="cronograma" name="cronograma[]" class="checkbox" onclick="rangoid('cronograma[]');" value="{$cronograma->id_cronograma}}"></td>
                                            <td> {$cronograma->fecha}}</td>
                                            <td> {$cronograma->hora_inicio}}</td>
                                            <td> {$cronograma->hora_fin}}</td>
                                            <td></td>
                                            <td>{$cronograma->tema}}</td>
                                            <td>{$cronograma->detalle}}</td>
                                        </tr>
                                        endforeach-->

                                    </tbody>
                                </table>
                                </form>
                            </div>

                                @endif
                        @endif

                </div>

            </div>
        </div>
    </div>
    </div>
@endsection
@section('javascript')
<script type="text/javascript">
    /*document.getElementById('agregar').style.display = 'none';
    document.getElementById('eliminar').style.display = 'none';*/

    function marcar(source)
    {
        checkboxes=document.getElementsByTagName('input'); //obtenemos todos los controles del tipo Input
        for(i=0;i<checkboxes.length;i++) //recoremos todos los controles
        {
            if(checkboxes[i].type == "checkbox") //solo si es un checkbox entramos
            {
                if(checkboxes[i].checked=source.checked==true){
                    checkboxes[i].checked=source.checked;

                }else{
                    checkboxes[i].checked=source.checked=false;
                    $("#id_cronograma").val("");
                }
                //si es un checkbox le damos el valor del checkbox que lo llamó (Marcar/Desmarcar Todos)
            }
        }
    }

    function rangoid(checkboxName) {
        var checkboxes = document.querySelectorAll('input[name="' + checkboxName + '"]:checked'), values = [];

            Array.prototype.forEach.call(checkboxes, function(el) {
                values.push(el.value);

                $("#id_cronograma").val(values);
            });

        if (values=="") {
            $("#id_cronograma").val("");
        }
    };


    $('.todo').on('click', function(e) {
        var idsArr = [];
        $(".checkbox:checked").each(function() {
            idsArr.push($(this).attr('value'));
            var strIds = idsArr.join(",");
            $("#id_cronograma").val(strIds);
        });

    })

    $ ('#eliminar' ).on('click',function (e) {
        var checkbox= $("#id_cronograma").val();
        console.log(checkbox);
        if(checkbox==""){
        alert("Seleccione al menos un registro para eliminar ")
            e.preventDefault();
        }else{
            remover();
        }

    });

    function remover() {
        if(!confirm("Esta seguro que desea eliminar!!"))
            event.preventDefault();
    };

    /* function myFunction() {
         var x = document.getElementById("id_periodo").value;
         $("#busqueda").append($("#busqueda").val(x));
     }

     function preferedBrowser() {
         prefer = document.forms[0].browsers.value;
         $("#busqueda").append($("#busqueda").val(prefer));
     }*/

    $(document).ready(function () {
        $('#id_carrera').on('change', function() {
            var id_carr = $(this).val();
            //console.log(id_carr);
            if(id_carr) {
                $.ajax({
                    url: '/Carrera/'+id_carr,
                    type: "GET",
                    data : {"_token":"{{ csrf_token() }}"},
                    dataType: "json",
                    success:function(data) {
                        //console.log(data);
                        if(data){
                            $('#id_materia').empty();
                            $('#id_materia').focus;
                            $('#id_materia').append('<option value="">--Seleccione materia--</option>');
                            $.each(data, function(id, value){
                                $('select[name="id_materia"]').append('<option value="'+ value.id_materia +'">' + value.materia+ '</option>');
                            });
                        }else{
                            $('#id_materia').empty();
                        }
                    }
                });
            }else{
                $('#id_materia').empty();
            }


        });
        var id_periodo;
        var id_do;
        //$("#busqueda").focus();
        $("#busqueda").on('change',function(e){
            id_periodo = $("#busqueda").val();
            id_do=$("#id_do").val();
            $.ajax({
                url: '/buscar/'+id_periodo+'/docente/'+id_do,
                type: 'GET',
               // data: "cronogramas="+id_periodo,
               // contentType: "application/json; charset=utf-8",
                dataType: 'json',
                success: function(data){
                    console.log(data);
                    var a=Object.keys(data).length === 0;
                    if(a==true){
                        $("#tema").val('');
                        alert('no existen registros');
                        $('#tbl_cronograma').DataTable().clear().destroy();

                        }else{
                      /*  $('#tbl_cronograma').dataTable( {
                            data : data,
                            columns: [
                                {"data" : "fecha"},
                                {"data" : "hora_inicio"},
                                {"data" : "hora_inicio"}
                            ],
                        });
                        $("#tema").empty();
                        $("#tema").val(data['tema']);*/

                        let lista = data;
                        let htmlCode = ``;
                        $.each(lista, function (index, item) {
                            htmlCode += `<tr>
                             <td><input type="checkbox" id="cronograma" name="cronograma[]" class="checkbox"  value="${item['id_cronograma']}" onclick="rangoid('cronograma[]')"></td>
                             <td>${item['fecha']}</td>
                             <td>${item['hora_inicio']}</td>
                             <td>${item['hora_fin']}</td>
                             <td>${item['capitulo']}</td>
                             <td>${item['tema']}</td>
                             <td>${item['detalle']}</td>
                             <td>${item['materia']}</td>
                             <td>${item['carrera']}</td>

                            </tr>`;
                            $('#tbl_cronograma tbody').html(htmlCode);
                          //  $(htmlCode).appendTo("#tbl_cronograma tbody");

                        });

                      $('#tbl_cronograma').DataTable({
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
                      /*  var valor = '<tr>' +
                            '<td><input type="checkbox" id="cronograma" name="cronograma[]" class="checkbox"  value="'+ data.id_cronograma +'" onclick="'+rangoid("cronograma[]")+'"></td>' +
                            '<td>' + data.fecha + '</td>' +
                            '<td>' + data.hora_inicio + '</td>' +
                            '<td>' + data.hora_fin + '</td>' +
                            '<td>' +   '</td>' +
                            '<td>' + data.tema + '</td>' +
                            '<td>' + data.detalle + '</td>' +
                            '</tr>';
                        $("#tbl_docentes tbody").html(valor);*/

                    }

                },
            });
        });

        });


</script>

@endsection
