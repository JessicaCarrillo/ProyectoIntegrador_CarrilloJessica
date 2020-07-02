@extends('layouts.usuario')
@section('stilo')
    <style>
        .btnElegir[data-estado='0'] {
            background-color:#ff253a ;
            color: white;
            opacity: 0.6 !important; /* Fade effect */
            cursor: not-allowed;
            pointer-events: none;

        }
        .btnElegir[data-estado=''] {
            opacity: 0.6 !important; /* Fade effect */
            cursor: not-allowed;
            pointer-events: none;

        }
        .btnElegir[data-activo='0'] {
            background-color: rgba(8, 6, 21, 0.73);
            color: white;
            opacity: 0.6 !important; /* Fade effect */
            cursor: not-allowed;
            pointer-events: none;

        }


        .estado[data-estado='1'] {
            opacity: 0.6 !important;
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
                    <div class="card-header" align="center" style="font-size: xx-large"><u>GESTIÓN DE PROYECTORES</u>
                    </div>
                    <div class="card-body" >
                        @if(session()->has('success'))
                            <div class="alert alert-success" role="alert">
                                <button type="button" class="close" data-dismiss="alert">&times;</button>
                                {{Session::get('success')}}</div>

                        @endif
                        <div class= "container-fluid">

                            <div  class= "row justify-content-center">
                                <?php $i=1; ?>
                                @foreach($proyectores as $proyector)
                                    <div class="card-group">
                                        <div class="card col-12">
                                            <div id="pro" class="card-body" style="padding-bottom: 15px;padding-top: 15px;" >
                                                <input type="button" id="disponible-{{$i}}" name="{{$i}}" style="width: 129px; height: 38px; font-size: small" class="btn btn-success btnElegir"  href="#modalReservar-{{$proyector->id_proyector}}" data-estado=" " data-activo="{{$proyector->estado_activo}}" data-toggle="modal" value="{{$proyector->proyector}}" />
                                            </div>
                                        </div>
                                    </div>
                                    <?php $i++; ?>

                                @endforeach

                            </div>

                        </div>
                        <input type="hidden" id="Estado_cierre" name="Estado_cierre" value="">
                        <br>
                        <div  class="table-responsive">
                            <table class="table table-bordered " style="margin-top: 10px;">
                                <thead class="thead-light">
                                <tr>
                                    <th scope="col">Dispositivo</th>
                                    <th scope="col">Fecha</th>
                                    <th scope="col">Hora Retiro</th>
                                    <th scope="col">Hora Devolución</th>
                                    <th scope="col">Observación</th>
                                    <th scope="col">Estado</th>
                                    <th scope="col">Accion</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($fichas_proyectores as $ficha_proyector)
                                    <tr>


                                        <td>{{$ficha_proyector->reserva->proyector}}</td>
                                        <td>{{$ficha_proyector->fecha}}</td>
                                        <td>{{date('h:i:s',strtotime($ficha_proyector->hora_retiro))}}</td>
                                        <td>{{date('h:i:s',strtotime($ficha_proyector->hora_entrega))}}</td>
                                        @if($ficha_proyector->id_estado_devolucion_fk=='')
                                            <td></td>
                                        @else
                                            <td>{{$ficha_proyector->estado_devolucion->descripcion}}</td>
                                        @endif

                                        <td>{{\App\Http\Controllers\GestionProyector\GestionProyectorController::EstadoProyector($ficha_proyector->estado)}}</td>
                                        <td><button style="font-size: 20px; color: white" href="#" id="estado_devo" class="btn btn-info btn-sm estado" data-atraso="{{$ficha_proyector->atraso}}" data-id="{{$ficha_proyector->id_ficha_proyector}}" data-proyector="{{$ficha_proyector->reserva->proyector}}"  data-fecha="{{$ficha_proyector->fecha}}"
                                                    data-horaretiro="{{$ficha_proyector->hora_retiro}}" data-horaentrega="{{$ficha_proyector->hora_entrega}}" data-observacion="{{$ficha_proyector->observacion}}" data-idproyector="{{$ficha_proyector->id_proyector_fk}}"
                                                    data-estado="{{$ficha_proyector->estado}}" data-toggle="modal" data-target="#modalDevolver" value="{{$ficha_proyector->estado}}">Devolver</button>
                                        </td>

                                    </tr>
                                @endforeach

                                </tbody>
                            </table>
                        </div>

                    </div>

                </div>
            </div>
        </div>
    </div>

    <?php $i=1; ?>
    @foreach($proyectores as $proyector)
        <div class="modal fade" tabindex="-1" role="dialog" id="modalReservar-{{$proyector->id_proyector}}">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h3 class="modal-title text-center">Reservar</h3>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    </div>

                    <div class="modal-body" >
                        <form  method="POST"  action="/ReservarProyector" novalidate="" id="FormularioReservar-{{$i}}" >
                            {{csrf_field()}}

                            @if(Session()->has('error'))
                                <div class="alert alert-success" role="alert">
                                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                                    {{Session::get('error')}}</div>
                            @endif
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label" id="re">Dispositivo:</label>
                                <div class="col-sm-9">

                                    <input type="text" class="form-control" id="proyector" name="proyector"  value="{{$proyector->proyector}}" readonly/>
                                    <input type="hidden" class="form-control" id="id_proyector" name="id_proyector"  value="{{$proyector->id_proyector}}" readonly/>

                                </div>
                            </div>
                            <div class="form-group row">
                                <label   class="col-sm-3 col-form-label"  id="rec">Fecha:</label>
                                <div class="col-sm-9">
                                    <input type="date" class="form-control" id="fecha" name="fecha" value="{{ date('Y-m-d') }}" readonly/>
                                </div>
                            </div>
                            <div class="input-group">
                                <div class="form-group " style="width: 230px;">
                                    <label  class=" control-label" id="rec">Hora Retiro:</label>
                                    <input type="time" class="form-control" id="hora_retiro" name="hora_retiro" value="{{ date('H:i:s') }}" readonly />
                                </div>

                                <div  class="form-group" style="width: 230px;">
                                    <label  class=" control-label" >Hora Entrega:</label>
                                    <input type="time" class="form-control" id="hora_entrega{{$i}}" name="hora_entrega"  required/>
                                    <!--<div class="valid-feedback">Success! You've done it.</div>-->
                                    <div class="invalid-feedback">El campo hora entrega es obligatorio*</div>

                                </div>
                            </div>
                            <div class="form-group">
                                <label  class=" control-label" >Observación:</label>
                                <textarea type="text" class="form-control" id="observacion" name="observacion" readonly >{{ $proyector->estado_dev->descripcion}}</textarea>
                            </div>



                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                                <button type="submit" id="reservar-{{$i}}"  class="btn btn-primary reserva" name="{{$i}}" onclick="myFunction(this.name);" >Reservar</button>

                            </div>
                        </form>
                    </div><!-- /.modal-content -->
                </div><!-- /.modal-dialog -->
            </div>
        </div>
        <?php $i++; ?>
    @endforeach
    <!----------------------------------------------------------------------------------------------------------------------------------->
    <div class="modal fade" tabindex="-1" role="dialog" id="modalDevolver" >
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Devolver</h4>
                </div>
                <form  method="POST"  action="/DevolverProyector" novalidate="" id="FormularioDevolver" >
                    {{csrf_field()}}
                    <div class="modal-body">
                        <input type="hidden" class="form-control" id="id_ficha_proyector" name="id_ficha_proyector"  value="" />

                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label" id="re">Dispositivo:</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="proyector" name="proyector"  value="" readonly/>
                                <input type="hidden" class="form-control" id="id_proyector" name="id_proyector"  value="" readonly/>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label   class="col-sm-3 col-form-label"  id="rec">Fecha:</label>
                            <div class="col-sm-9">
                                <input type="date" class="form-control" id="fecha" name="fecha" value="" readonly/>
                            </div>
                        </div>
                        <div class="input-group">
                            <div class="form-group " style="width: 230px;">
                                <label  class=" control-label" id="rec">Hora Retiro:</label>
                                <input type="time" class="form-control" id="hora_retiro" name="hora_retiro" value="" readonly />
                            </div>

                            <div  class="form-group" style="width: 230px;">
                                <label  class=" control-label" id="rec">Hora Entrega:</label>
                                <input  type="time" class="form-control" id="hora_entrega" name="hora_entrega" value="{{ date('H:i:s') }}" readonly  />
                            </div>
                        </div>

                        <div class="form-group">
                            <label  class=" control-label" for="recipient-name">Estado de devolución:</label>
                            <select name="id_estado_devolucion" id="id_estado_devolucion" class="form-control" required >
                                <option value="">--Seleccione el estado--</option>
                                @foreach($estados_devolucion as $estado_devolucion)
                                    <option value="{{$estado_devolucion['id_estado']}}">{{$estado_devolucion['descripcion']}}</option>
                                @endforeach
                            </select>
                            <div class="invalid-feedback">Debe seleccionar un estado*</div>

                        </div>
                        <div class="form-group">
                            <label  class=" control-label" for="recipient-name">Observación:</label>
                            <textarea type="text" class="form-control" id="observacion" name="observacion"></textarea>
                        </div>


                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                        <button type="submit" class="btn btn-primary" id="btnSubmit">Devolver</button>

                    </div>
                </form>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div>


@endsection

@section('javascript')
    <script type="text/javascript">


        function myFunction(id) {
            var id_proyector = id;
            console.log(id_proyector);
            var form = $("#FormularioReservar-" + id_proyector);

            if (form[0].checkValidity() === false) {
                event.preventDefault()
                event.stopPropagation()

            } else {
                if (confirm("Esta seguro de la reserva!!")) {
                    $("#disponible-" + id_proyector).toggleClass("btn-success btn-danger");
                    // document.getElementById("disponible"+id_proyector).disabled = true;

                } else {
                    event.preventDefault();
                }
            }
            form.addClass('was-validated');
        }
        function ca_estados(){
            $.ajax({
                url: '/cambio/',
                type: "GET",
                data : {"_token":"{{ csrf_token() }}"},
                dataType: "json",
                success:function(data) {
                    //console.log(data);

                }
            });


        }

        function estados(){
            $.ajax({
                url: '/leer/',
                type: "GET",
                data : {"_token":"{{ csrf_token() }}"},
                dataType: "json",
                success:function(data) {
                    //console.log(data);
                    var a=data['Proyector1'];
                    var b=data['Proyector2'];
                    var c=data['Proyector3'];
                    var d=data['Proyector4'];
                    var e=data['Proyector5'];
                    var f=data['Proyector6'];
                    var g=data['Proyector7'];
                    var h=data['Proyector8'];
                    var i=data['Proyector9'];
                    var j=data['Proyector10'];
                    var k=data['Proyector11'];
                    var l=data['Proyector12'];
                    var m=data['Proyector13'];
                    var n=data['Proyector14'];
                    var o=data['Proyector15'];
                    var p=data['Proyector16'];
                    var q=data['Proyector17'];
                    var r=data['Proyector18'];
                    var s=data['Proyector19'];
                    var t=data['Proyector20'];
                    $("#disponible-1").attr('data-estado',a);
                    $("#disponible-2").attr('data-estado',b);
                    $("#disponible-3").attr('data-estado',k);
                    $("#disponible-4").attr('data-estado',l);
                    $("#disponible-5").attr('data-estado',c);
                    $("#disponible-6").attr('data-estado',d);
                    $("#disponible-7").attr('data-estado',m);
                    $("#disponible-8").attr('data-estado',n);
                    $("#disponible-9").attr('data-estado',e);
                    $("#disponible-10").attr('data-estado',f);
                    $("#disponible-11").attr('data-estado',o);
                    $("#disponible-12").attr('data-estado',p);
                    $("#disponible-13").attr('data-estado',g);
                    $("#disponible-14").attr('data-estado',h);
                    $("#disponible-15").attr('data-estado',q);
                    $("#disponible-16").attr('data-estado',r);
                    $("#disponible-17").attr('data-estado',i);
                    $("#disponible-18").attr('data-estado',j);
                    $("#disponible-19").attr('data-estado',s);
                    $("#disponible-20").attr('data-estado',t);

                    // $("#proyector-1").val(data['Proyector1']);

                    $("#Estado_cierre").val(data['Estado']);
                    if( data['Estado']==1){
                        ca_estados()
                        //alert("Cierre la puerta");
                        swal({
                            title: "Recoja el Proyector",
                            text: "No olvide cerrar la puerta y sesión!",
                            icon: "warning",
                            dangerMode: true,
                            closeOnClickOutside: false,
                            buttons: false,

                        })
                        // console.log(swal.getState())

                    }

                    cambio_cero();
                }
            });
        }

        function cambio_cero() {
            var x= document.getElementById("Estado_cierre").value;
            //  console.log(x);
            if(x==0 || x==''){
                ca_estados();
                //console.log(swal.getState().isOpen)
                if(swal.getState().isOpen==true){
                    swal.close();

                }
                //swal.close();
                // swal.close();
            }

        }
        var myVar = setInterval(estados, 2000);
        function myStopFunction() {
            clearInterval(myVar);
        }


        $(document).ready(function(){


            $("#btnSubmit").click(function(event) {
                var form = $("#FormularioDevolver");

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

            $('#modalDevolver').on('shown.bs.modal', function (event) {
                console.log('modal abierto');
                var button=$(event.relatedTarget);
                var id= button.data('id');
                var proyector=button.data('proyector');
                var fecha=button.data('fecha');
                var hora_retiro=button.data('horaretiro');
                var id_proyector=button.data('idproyector');
                var modal=$(this);
                modal.find('.modal-body #id_ficha_proyector').val(id);
                modal.find('.modal-body #proyector').val(proyector);
                modal.find('.modal-body #fecha').val(fecha);
                modal.find('.modal-body #hora_retiro').val(hora_retiro);
                modal.find('.modal-body #id_proyector').val(id_proyector);


            });


            $.ajax({
                url: '/leer/',
                type: "GET",
                data : {"_token":"{{ csrf_token() }}"},
                dataType: "json",
                success:function(data) {
                    console.log(data);
                    var a=data['Proyector1'];
                    var b=data['Proyector2'];
                    var c=data['Proyector3'];
                    var d=data['Proyector4'];
                    var e=data['Proyector5'];
                    var f=data['Proyector6'];
                    var g=data['Proyector7'];
                    var h=data['Proyector8'];
                    var i=data['Proyector9'];
                    var j=data['Proyector10'];
                    var k=data['Proyector11'];
                    var l=data['Proyector12'];
                    var m=data['Proyector13'];
                    var n=data['Proyector14'];
                    var o=data['Proyector15'];
                    var p=data['Proyector16'];
                    var q=data['Proyector17'];
                    var r=data['Proyector18'];
                    var s=data['Proyector19'];
                    var t=data['Proyector20'];
                    $("#disponible-1").attr('data-estado',a);
                    $("#disponible-2").attr('data-estado',b);
                    $("#disponible-3").attr('data-estado',k);
                    $("#disponible-4").attr('data-estado',l);
                    $("#disponible-5").attr('data-estado',c);
                    $("#disponible-6").attr('data-estado',d);
                    $("#disponible-7").attr('data-estado',m);
                    $("#disponible-8").attr('data-estado',n);
                    $("#disponible-9").attr('data-estado',e);
                    $("#disponible-10").attr('data-estado',f);
                    $("#disponible-11").attr('data-estado',o);
                    $("#disponible-12").attr('data-estado',p);
                    $("#disponible-13").attr('data-estado',g);
                    $("#disponible-14").attr('data-estado',h);
                    $("#disponible-15").attr('data-estado',q);
                    $("#disponible-16").attr('data-estado',r);
                    $("#disponible-17").attr('data-estado',i);
                    $("#disponible-18").attr('data-estado',j);
                    $("#disponible-19").attr('data-estado',s);
                    $("#disponible-20").attr('data-estado',t);

                }
            });
        });

        //document.getElementById('disponible-1').disabled=true;


    </script>
@endsection
