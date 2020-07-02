@extends('layouts.administrador')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header" align="center" style="font-size: xx-large">REPORTE DE PROYECTORES</div>

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

                        <div class="row input-daterange"  >
                            <div class="col-md-4">
                                <input type="text" name="from_date" id="from_date" class="form-control" placeholder="Desde" readonly="true">
                            </div>
                            <div class="col-md-4">
                                <input type="text" name="to_date" id="to_date" class="form-control" placeholder="Hasta" readonly="true">

                            </div>
                            <div class="col-md-4">
                                <button type="button" name="filter" id="filter" class=" btn btn-primary">Filtrar</button>
                                <button type="button" name="refresh" id="refresh" class=" btn btn-default">Refrescar</button>
                                <button type="button" name="todo" id="todo" class=" btn btn-success">Mostrar Todo</button>
                            </div>
                        </div>
                        <br>
                        <div class="table-responsive">
                            <table class="table " id="tbl_proyector" >
                                <thead class="thead-light">
                                <tr>
                                    <th>#</th>
                                    <th>Fecha</th>
                                    <th>Docente</th>
                                    <th>Dispositivo</th>
                                    <th>Hora retiro</th>
                                    <th>Hora entrega</th>
                                    <th>Observación</th>
                                </tr>
                                </thead>
                            </table>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
    </div>

@endsection
@section('estilo')
    <style>
        :after, :before {
            box-sizing: border-box;
        }

        .btn {
            display: inline-block;
            font-size: 14px;
            font-weight: 400;
            line-height: 1.42857143;
            text-align: center;
            white-space: nowrap;
            vertical-align: middle;
            cursor: pointer;
            user-select: none;
            background-image: none;
            border: 1px solid transparent;
            border-radius: 4px;
        }


        .btn-app {
            color: white;
            box-shadow: none;
            border-radius: 3px;
            position: relative;
            padding: 10px 15px;
            margin: 0;
            min-width: 60px;
            max-width: 80px;
            text-align: center;
            border: 1px solid #ddd;
            background-color: #f4f4f4;
            font-size: 12px;
            transition: all .2s;
            background-color: steelblue !important;
        }

        .btn-app > .fa{
            font-size: 25px;
            display: block;

        }

        .btn-app:hover {
            border-color: #aaa;
            transform: scale(1.1);
        }

        .pdf{
            background-color: #dc2f2f !important;
        }

        .excel {
            background-color: #3ca23c !important;
        }


    </style>
@endsection
@section('javascript')

    <script type="text/javascript">
        $(document).ready(function(){
            $.fn.datepicker.dates['es'] = {
                days: ["Domingo", "Lunes", "Martes", "Miéercoles", "Jueves", "Viernes", "Sábado"],
                daysShort: ["Dom","Lun","Mar","Mié","Juv","Vie","Sáb"],
                daysMin: ["Do","Lu","Ma","Mi","Ju","Vi","Sá"],
                months: ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"],
                monthsShort: ["Ene","Feb","Mar","Abr", "May","Jun","Jul","Ago","Sep", "Oct","Nov","Dic"],
                today: "Hoy",
                weekStart: 0
            };

            $('.input-daterange').datepicker({
                todayBtn:'linked',
                format:'yyyy-mm-dd',
                autoclose:true,
                language: 'es',
            });


            //load_data();


            function load_data(from_date = '', to_date = '')
            {
                $('#tbl_proyector').DataTable({

                    "language": {
                        "lengthMenu": "Mostrar _MENU_ entradas",
                        "zeroRecords": "No se ha encontrado resultados",
                        "info": "Mostrándo página _PAGE_ de _PAGES_",
                        "sInfo":           "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
                        "infoEmpty": "No hay registros disponibles",
                        "infoFiltered": "(filtered from _MAX_ total records)",
                        "search": "Buscar:",
                        "paginate": {
                            "first":      "Primero",
                            "last":       "Último",
                            "next":       "Siguiente",
                            "previous":   "Anterior"

                        },

                    },
                    destroy: true,
                    searching: true,
                    ordering:  true,
                    stateSave: true,
                    processing: true,
                    serverSide: true,

                    dom: "<'row'<'col-sm-5'><'col-sm-6'B>>+<'row'<'col-sm-6'l><'col-sm-6'f>>" +
                        "<'row'<'col-sm-12'tr>>" +
                        "<'row'<'col-sm-5'i><'col-sm-7'p>>",
                    buttons: {
                        dom: {
                            container:{
                                tag:'div',
                                className:'flexcontent'
                            },
                            buttonLiner: {
                                tag: null
                            }
                        },


                        buttons: [
                            {
                                extend: 'pdfHtml5',
                                text: '<i class="fa fa-file-pdf"></i>PDF',
                                title: 'Reporte de proyectores',
                                titleAttr: 'PDF',
                                className: 'btn btn-app export pdf',
                                exportOptions: {
                                    columns: [0, 1,2,3,4,5,6]
                                },
                                customize: function (doc) {

                                    doc.styles.title = {
                                        color: '#4c8aa0',
                                        fontSize: '30',
                                        alignment: 'center'
                                    }
                                    doc.styles['td:nth-child(2)'] = {
                                        width: '100px',
                                        'max-width': '100px'
                                    },
                                        doc.styles.tableHeader = {
                                            fillColor: '#4c8aa0',
                                            color: 'white',
                                            alignment: 'center'
                                        },
                                       // doc.content[1].margin = [0, 0, 0, 0 ];
                                        doc.content[1].table.widths =
                                            Array(doc.content[1].table.body[0].length + 1).join('*').split('');

                                }

                            },

                            {
                                extend: 'excelHtml5',
                                text: '<i class="fa fa-file-excel"></i>Excel',
                                title: 'Reporte de proyectores',
                                titleAttr: 'Excel',
                                className: 'btn btn-app export excel',
                                exportOptions: {
                                    columns: [0, 1,2,3,4,5,6]
                                },
                            },

                        ]
                    },

                    ajax: {
                        url:'/ReporteProyector/',
                        data:{from_date:from_date, to_date:to_date}
                    },
                    columns: [
                        {
                            data:'id_ficha_proyector',
                            name:'id_ficha_proyector'
                        },
                        {
                            data:'fecha',
                            name:'fecha'

                        },
                        {
                            data:'name',
                            name:'name'
                        },
                        {
                            data:'proyector',
                            name:'proyector'

                        },
                        {
                            data:'hora_retiro',
                            name:'hora_retiro'

                        },

                        {
                            data:'hora_entrega',
                            name:'hora_entrega'

                        },
                        {
                            data:'descripcion',
                            name:'descripcion'

                        }

                    ]

                });
            }

            $('#filter').click(function(){
                var from_date = $('#from_date').val();
                var to_date = $('#to_date').val();
                if(from_date != '' &&  to_date != '')
                {
                    $('#tbl_proyector').DataTable().destroy();
                    load_data(from_date, to_date);
                }
                else
                {
                    /*alert('Ingrese rango de fechas!!');*/
                    swal({
                        text: "Ingrese rango de fechas!!",
                    });
                }
            });

            $('#refresh').click(function(){
                $('#from_date').val('');
                $('#to_date').val('');
                $('#tbl_proyector').DataTable().clear().destroy();

            });

            $('#todo').click(function(){
                $('#from_date').val('');
                $('#to_date').val('');
                // $('#tbl_asistencia').DataTable().clear().destroy();
                load_data();

            });

        });
    </script>
@endsection



