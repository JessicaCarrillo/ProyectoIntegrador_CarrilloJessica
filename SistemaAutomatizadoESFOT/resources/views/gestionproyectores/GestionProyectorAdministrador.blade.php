@extends('layouts.usuario')
@section('stilo')
    <style>
        .btnElegir[data-estados='0'] {
            background-color:#ff253a ;
            color: white;
            opacity: 0.6 !important; /* Fade effect */
            cursor: not-allowed;
            pointer-events: none;

        }

        .btnElegir[data-estados=''] {
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
                                                <input type="button" id="disponible-{{$i}}" name="{{$i}}" style="width: 129px; height: 38px; font-size: small" class="btn btn-success btnElegir" data-backdrop="static" href="#modalReservar-{{$proyector->id_proyector}}" data-estados=" " data-estadobase="{{$proyector->estado}}" data-activo="{{$proyector->estado_activo}}" data-toggle="modal" value="{{$proyector->proyector}}" />
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
                                                    data-estado_devolucion="{{$ficha_proyector->reserva->estado}}" data-estado="{{$ficha_proyector->estado}}" data-toggle="modal" data-target="#modalDevolver" value="{{$ficha_proyector->estado}}" data-backdrop="static" data-componentes="{{$ficha_proyector->reserva->componentes}}">Devolver</button>
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
                        <form  method="POST"  action="{{ route('docente.ReservarProyector')}}" novalidate="" id="FormularioReservar-{{$i}}" >
                            {{csrf_field()}}

                            @if(Session()->has('error'))
                                <div class="alert alert-success" role="alert">
                                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                                    {{Session::get('error')}}</div>
                            @endif
                            <input type="hidden" id="estado_arduino-{{$i}}" name="estado_arduino" value="">
                            <div class="input-group">
                                <div class="form-group" style="width: 230px;" >
                                    <label  class="control-label" id="rec">Dispositivo:</label>
                                    <input type="text" class="form-control" id="proyector" name="proyector"  value="{{$proyector->proyector}}" readonly/>
                                    <input type="hidden" class="form-control" id="id_proyector" name="id_proyector"  value="{{$proyector->id_proyector}}" readonly/>

                                </div>
                                <div class="form-group" style="width: 230px;" >
                                    <label   class="control-label"  id="rec">Fecha:</label>
                                    <input type="date" class="form-control" id="fecha" name="fecha" value="{{ date('Y-m-d') }}" readonly/>

                                </div>
                            </div>
                            <div class="input-group">
                                @if($proyector->marca!='' )
                                    <div class="form-group" style="width: 100px;">
                                        <label  class=" control-label" id="rec">Marca:</label>
                                        <input type="text" class="form-control" id="marca" name="marca" value="{{$proyector->marca}}" readonly />
                                    </div>
                                @endif
                                @if($proyector->modelo!='' )
                                    <div  class="form-group" style="width: 100px;">
                                        <label  class=" control-label" >Modelo:</label>
                                        <input type="text" class="form-control"  id="modelo" name="modelo" value="{{$proyector->modelo}}" readonly/>

                                    </div>
                                @endif
                                @if($proyector->serie!='' )
                                    <div  class="form-group" style="width: 150px;">
                                        <label  class=" control-label" >Serie:</label>
                                        <input type="text" class="form-control"  id="serie" name="serie" value="{{$proyector->serie}}" readonly/>
                                    </div>
                                @endif
                                @if($proyector->color!='' )
                                    <div  class="form-group" style="width: 100px;">
                                        <label  class=" control-label" >Color:</label>
                                        <input type="text" class="form-control"  id="Color" name="Color" value="{{$proyector->color}}" readonly/>
                                    </div>
                                @endif
                            </div>

                            @if($proyector->componentes!='')
                                <div class="form-group">
                                    <label  class=" control-label" >Componentes:</label>
                                    <textarea type="text" class="form-control" id="componentes" name="componentes" readonly >{{ $proyector->componentes}}</textarea>
                                </div>
                            @endif
                            <div class="input-group">
                                <div class="form-group " style="width: 230px;">
                                    <label  class=" control-label" id="rec">Hora Retiro:</label>
                                    <input type="time" class="form-control" id="hora_retiro" name="hora_retiro" value="{{ date('H:i') }}" readonly />
                                </div>

                                <div  class="form-group" style="width: 230px;">
                                    <label  class=" control-label" >Hora Entrega:</label>
                                    <input type="time" class="form-control" data-posicion="{{$i}}" id="hora_entrega{{$i}}" name="hora_entrega"  onchange="calculardiferencia(this)"  required/>
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
                                <button type="button" id="reservar-{{$i}}"  class="btn btn-primary reserva" name="{{$i}}" onclick="myFunction(this.name);" >Reservar</button>

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
                                <input type="hidden" id="estado_devolucion" name="estado_devolucion" value="">
                                <input type="text" class="form-control" id="proyector" name="proyector"  value="" readonly/>
                                <input type="hidden" class="form-control" id="id_proyector_fk" name="id_proyector_fk"  value="" readonly/>
                                <input type="hidden" class="form-control" id="id_proyector" name="id_proyector"  value="" readonly/>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label   class="col-sm-3 col-form-label"  id="rec">Fecha:</label>
                            <div class="col-sm-9">
                                <input type="date" class="form-control" id="fecha" name="fecha" value="" readonly/>
                            </div>
                        </div>
                        <div class="form-group" id="componente">
                            <label  class=" control-label" >Componentes:</label>
                            <textarea type="text" class="form-control" id="componentes" name="componentes" readonly ></textarea>
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
                        <input type="hidden" id="atraso">
                        <div class="alert alert-danger" role="alert" id="cont3"  align="center"></div>

                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                        <button type="button" class="btn btn-primary" id="btnSubmit">Devolver</button>

                    </div>
                </form>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div>

@endsection

@section('javascript')
    <script type="text/javascript">
        /*--------------------------------------VALIDACIONES DE FORMULARIO DE RESERVA E ACTIVACION DE LECTURA DE ESTADO DE PUERTA-------------*/
        function myFunction(id) {

            var id_proyector=id;
            console.log(id_proyector);
            var form = $("#FormularioReservar-"+id_proyector);

            if (form[0].checkValidity() === false) {
                event.preventDefault()
                event.stopPropagation()

            }else{
                swal("Correcto! Reserva en proceso!", {
                    icon: "warning",
                    buttons: false,
                    closeOnClickOutside: false,
                })


                        var dataString = $("#FormularioReservar-"+id_proyector).serialize(); // carga todos los campos para enviarlos
                        // AJAX
                        $.ajax({
                            type: "POST",
                            url: "{{route('docente.ReservarProyector')}}",
                            headers: {
                                'X-CSRF-Token': '{{ csrf_token() }}',
                            },

                            data: dataString,
                            success: function(data) {
                               // console.log('si');
                                ActivarTiempo(id_proyector);
                            }
                        });


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

        /*----------------------------------------VERIFICA ESTADO DE LA PUERTA ABIERTA ESTADO 1--------------------------------------------*/
        function Estado_puerta(id_proyector) {
            var x = document.getElementById("Estado_cierre").value;
            console.log(x);
            if (x == 1 || x == '') {
                //ca_estados();
                //alert("Cierre la puerta");
                swal({
                    title: "Recoja el Proyector",
                    text: "No olvide cerrar la puerta y sesión!",
                    icon: "warning",
                    dangerMode: true,
                    closeOnClickOutside: false,
                    buttons: false,

                })

            } else {
                //ca_estados();
                if (swal.getState().isOpen == true) {

                    //ca_estados();
                    var a = document.getElementById("estado_arduino-" + id_proyector).value;
                    var b = $("#disponible-" + id_proyector).attr('data-estadobase');
                    console.log(a);
                    console.log(b);
                    if (a != b) {
                        var dataString = $("#FormularioReservar-" + id_proyector).serialize(); // carga todos los campos para enviarlos
                        // AJAX
                        $.ajax({
                            type: "POST",
                            url: "/ReservarProyectorA",
                            data: dataString,
                            success: function (data) {
                                console.log('siREserva');
                            }
                        });
                        $("#FormularioReservar-" + id_proyector).submit();
                        swal.close();
                        myStopFunction();
                        swal("Reserva realizada!", {
                            icon: "success",
                            buttons: false,
                            closeOnClickOutside: false,
                        })
                    } else {
                        // Stop_Estados();
                        swal({
                            title: "Reserva no realizada",
                            text: "No ha retirado el dispositivo!",
                            icon: "warning",
                            dangerMode: true,
                            closeOnClickOutside: false,
                            buttons: false,
                            timer: 3000,
                        })
                        $('#modalReservar-' + id_proyector).modal('hide');

                        swal.close();
                        myStopFunction();

                    }
                }


            }
        }

        var myVar;
        function ActivarTiempo(id_proyector){
            myVar = setInterval(function(){Estado_puerta(id_proyector)}, 4000);

        }
        function myStopFunction() {
            clearInterval(myVar);
        }

        function estados(){
            $.ajax({
                url: '/leer/',
                type: "GET",
                data : {"_token":"{{ csrf_token() }}"},
                dataType: "json",
                success:function(data) {
                    ca_estados();
                    console.log(data);
                    $("#Estado_cierre").val(data['Estado']);
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
                    $("#disponible-1").attr('data-estados',a);
                    document.getElementById('estado_arduino-1').value=a;
                    $("#disponible-2").attr('data-estados',b);
                    document.getElementById('estado_arduino-2').value=b;
                    $("#disponible-3").attr('data-estados',k);
                    document.getElementById('estado_arduino-3').value=k;
                    $("#disponible-4").attr('data-estados',l);
                    document.getElementById('estado_arduino-4').value=l;
                    $("#disponible-5").attr('data-estados',c);
                    document.getElementById('estado_arduino-5').value=c;
                    $("#disponible-6").attr('data-estados',d);
                    document.getElementById('estado_arduino-6').value=d;
                    $("#disponible-7").attr('data-estados',m);
                    document.getElementById('estado_arduino-7').value=m;
                    $("#disponible-8").attr('data-estados',n);
                    document.getElementById('estado_arduino-8').value=n;
                    $("#disponible-9").attr('data-estados',e);
                    document.getElementById('estado_arduino-9').value=e;
                    $("#disponible-10").attr('data-estados',f);
                    document.getElementById('estado_arduino-10').value=f;
                    $("#disponible-11").attr('data-estados',o);
                    document.getElementById('estado_arduino-11').value=o;
                    $("#disponible-12").attr('data-estados',p);
                    document.getElementById('estado_arduino-12').value=p;
                    $("#disponible-13").attr('data-estados',g);
                    document.getElementById('estado_arduino-13').value=g;
                    $("#disponible-14").attr('data-estados',h);
                    document.getElementById('estado_arduino-14').value=h;
                    $("#disponible-15").attr('data-estados',q);
                    document.getElementById('estado_arduino-15').value=q;
                    $("#disponible-16").attr('data-estados',r);
                    document.getElementById('estado_arduino-16').value=r;
                    $("#disponible-17").attr('data-estados',i);
                    document.getElementById('estado_arduino-17').value=i;
                    $("#disponible-18").attr('data-estados',j);
                    document.getElementById('estado_arduino-18').value=j;
                    $("#disponible-19").attr('data-estados',s);
                    document.getElementById('estado_arduino-19').value=s;
                    $("#disponible-20").attr('data-estados',t);
                    document.getElementById('estado_arduino-20').value=t;

                }
            });
        }

        var myVar = setInterval(estados, 1700);
        function myStopFunction() {
            clearInterval(myVar);
        }

        function demo(){
            console.log("Retraso en tiempo");
            setTimeout(console.log.bind(null,'two seconds'),1500);

        }

        /**********************************************************************************************************/
        var Estado_devolver;
        function ActivarTiempo_devolver(){
            Estado_devolver = setInterval(Estado_puerta_devolver, 4000);

        }
        function myStopFunction_devolver() {
            clearInterval(Estado_devolver);
        }

        /*---------------------------------------ESTADO DE PUERTA ABIERTA AL DEVOLVER--------------------------------------------------*/
        function Estado_puerta_devolver(){

            var x = document.getElementById("Estado_cierre").value;
            console.log(x);
            if (x == 1 || x == '') {
                // ca_estados();
                //alert("Cierre la puerta");
                swal({
                    title: "Devuelva el Proyector",
                    text: "No olvide cerrar la puerta y sesión!",
                    icon: "warning",
                    dangerMode: true,
                    closeOnClickOutside: false,
                    buttons: false,

                })

            } else {
                // ca_estados();
                //console.log(swal.getState().isOpen)
                if (swal.getState().isOpen == true) {
                    demo();
                    var a= document.getElementById("estado_devolucion").value;
                    var id_proyector= document.getElementById("id_proyector_fk").value;
                    console.log(id_proyector);
                    var b= $("#disponible-"+id_proyector).attr('data-estados');
                    console.log(a);
                    console.log(b);
                    if(a!=b){
                        var dataString = $("#FormularioDevolver").serialize(); // carga todos los campos para enviarlos
                        // AJAX
                        $.ajax({
                            type: "POST",
                            url: "/DevolverProyectorA",
                            data: dataString,
                            success: function(data) {
                                console.log('siREserva');
                            }
                        });
                        $('#modalDevolver').modal('hide');
                        //$("#FormularioDevolver").submit();
                        swal.close();
                        myStopFunction_devolver();
                        location.reload();
                        swal("Devolución realizada!", {
                            icon: "success",
                            buttons: false,
                            closeOnClickOutside: false,
                        })
                    }else {
                        // Stop_Estados();
                        swal({
                            title: "Devolucion no realizada",
                            text: "No ha ingresado el dispositivo!",
                            icon: "warning",
                            dangerMode: true,
                            closeOnClickOutside: false,
                            buttons: false,
                            timer: 3000,
                        })
                        $('#modalDevolver').modal('hide');
                        swal.close();
                        myStopFunction_devolver();

                    }
                }


            }
        }

        /*---------------------------------VALIDACIONES DE FORMULARIO DE DECOLUCION Y ACTIVAR ESTADO DE PUERTA----------------------*/

        $("#btnSubmit").click(function(event) {
            var form = $("#FormularioDevolver");

            if (form[0].checkValidity() === false) {
                event.preventDefault()
                event.stopPropagation()

            }else{
                swal("Correcto! Devolución en proceso!", {
                    icon: "warning",
                    buttons: false,

                })
                        var dataString = $("#FormularioDevolver").serialize(); // carga todos los campos para enviarlos
                        // AJAX
                        $.ajax({
                            type: "POST",
                            url: '{{route('docente.ReservarProyector')}}',
                            headers: {
                                'X-CSRF-Token': '{{ csrf_token() }}',
                            },
                            data: dataString,
                            success: function(data) {
                                console.log('si');
                                ActivarTiempo_devolver();
                            }
                        });
            }
            form.addClass('was-validated');
        });


        $(document).ready(function(){



            $('#modalDevolver').on('shown.bs.modal', function (event) {
                console.log('modal abierto');
                var button=$(event.relatedTarget);
                var id= button.data('id');
                var proyector=button.data('proyector');
                var fecha=button.data('fecha');
                var hora_retiro=button.data('horaretiro');
                var id_proyector=button.data('idproyector');
                var atraso=button.data('atraso');
                var estado_devolucion=button.data('estado_devolucion');
                var componentes=button.data('componentes');
                var modal=$(this);
                modal.find('.modal-body #id_ficha_proyector').val(id);
                modal.find('.modal-body #proyector').val(proyector);
                modal.find('.modal-body #fecha').val(fecha);
                modal.find('.modal-body #hora_retiro').val(hora_retiro);
                modal.find('.modal-body #id_proyector_fk').val(id_proyector);
                modal.find('.modal-body #id_proyector').val(id_proyector);
                modal.find('.modal-body #atraso').val(atraso);
                modal.find('.modal-body #estado_devolucion').val(estado_devolucion);
                modal.find('.modal-body #componentes').val(componentes);

                if(componentes==''){
                    document.getElementById('componente').style.display = 'none';
                }

                var valor = document.getElementById('atraso').value;
                // console.log(valor);
                if(valor==""){
                    document.getElementById('cont3').style.display = 'none';

                }else{
                    document.getElementById('cont3').innerHTML=' '+valor+'!!';

                }
            });


            $.ajax({
                url: '/leer/',
                type: "GET",
                data : {"_token":"{{ csrf_token() }}"},
                dataType: "json",
                success:function(data) {
                    ca_estados();
                    console.log(data);
                    $("#Estado_cierre").val(data['Estado']);
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
                    $("#disponible-1").attr('data-estados',a);
                    $("#disponible-2").attr('data-estados',b);
                    $("#disponible-3").attr('data-estados',k);
                    $("#disponible-4").attr('data-estados',l);
                    $("#disponible-5").attr('data-estados',c);
                    $("#disponible-6").attr('data-estados',d);
                    $("#disponible-7").attr('data-estados',m);
                    $("#disponible-8").attr('data-estados',n);
                    $("#disponible-9").attr('data-estados',e);
                    $("#disponible-10").attr('data-estados',f);
                    $("#disponible-11").attr('data-estados',o);
                    $("#disponible-12").attr('data-estados',p);
                    $("#disponible-13").attr('data-estados',g);
                    $("#disponible-14").attr('data-estados',h);
                    $("#disponible-15").attr('data-estados',q);
                    $("#disponible-16").attr('data-estados',r);
                    $("#disponible-17").attr('data-estados',i);
                    $("#disponible-18").attr('data-estados',j);
                    $("#disponible-19").attr('data-estados',s);
                    $("#disponible-20").attr('data-estados',t);

                }
            });
        });

        //document.getElementById('disponible-1').disabled=true;
        function calculardiferencia(data){
            var id=$(data).attr('data-posicion');
            var hora_inicio = $('#hora_retiro').val();
            var hora_final = $('#hora_entrega'+id).val();

            // Expresión regular para comprobar formato
            var formatohora = /^([01]?[0-9]|2[0-3]):[0-5][0-9]$/;

            // Si algún valor no tiene formato correcto sale
            if (!(hora_inicio.match(formatohora)
                && hora_final.match(formatohora))){
                //alert("La hora final es anterior a la inicial");
                return;
            }

            // Calcula los minutos de cada hora
            var minutos_inicio = hora_inicio.split(':')
                .reduce((p, c) => parseInt(p) * 60 + parseInt(c));
            var minutos_final = hora_final.split(':')
                .reduce((p, c) => parseInt(p) * 60 + parseInt(c));

            // Si la hora final es anterior a la hora inicial sale
            if (minutos_final < minutos_inicio)  {
                //alert("La hora final es anterior a la inicial");
                swal("La hora de entrega es menor a la hora de retiro!!", {
                    icon: "error",
                    buttons: false,
                    timer: 3000,

                })
                document.getElementById('hora_entrega' + id).value = '';
                return

            };
            // Diferencia de minutos
            var diferencia = minutos_final - minutos_inicio;

            // Cálculo de horas y minutos de la diferencia
            var horas = Math.floor(diferencia / 60);
            var minutos = diferencia % 60;


        }


    </script>
@endsection
