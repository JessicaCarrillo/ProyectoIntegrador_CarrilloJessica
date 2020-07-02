@extends('layouts.administrador')
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header" align="center" style="font-size: xx-large">EDITAR PERÍODO</div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                        <form  action="/EditarPeriodo/{{$periodos->id_periodo}}"  method="post">
                            <input type="hidden" name="_token" value="{{csrf_token()}}">
                            {{ method_field('PUT') }}
                            <div class="form-group">
                                <label for="periodo">Período:</label>
                                <input id="periodo" name="periodo" class="form-control" type="text" placeholder="Ejemplol: 2012-A" value="{{$periodos->periodo}}">
                                {!! $errors->first('periodo','<small style="color:Red;">:message</small>')!!}
                            </div>
                            <div class="form-group">
                                <label for="fecha_inicio">Fecha Inicio:</label>
                                <input id="fecha_inicio" name="fecha_inicio" class="form-control" type="date" placeholder="Fecha inicio" value="{{$periodos->fecha_inicio}}"  onchange="calcularDias();">
                                {!! $errors->first('fecha_inicio','<small style="color:Red;">:message</small>')!!}
                            </div>
                            <div class="form-group">
                                <label for="fecha_fin">Fecha Fin:</label>
                                <input type="date" class="form-control" id="fecha_fin" name="fecha_fin"  placeholder="Fecha fin" value="{{$periodos->fecha_fin}}"  onchange="calcularDias();">
                                {!! $errors->first('fecha_fin','<small style="color:Red;">:message</small>')!!}
                            </div>

                            <div class="form-group" align="center">
                                <button type="submit" class="btn btn-primary">Actualizar</button>
                            </div>
                        </form>


                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('javascript')

    <script type="text/javascript">
        function isValidDate(day,month,year)
        {
            var dteDate;
            month=month-1;
            dteDate=new Date(year,month,day);
            return ((day==dteDate.getDate()) && (month==dteDate.getMonth()) && (year==dteDate.getFullYear()));
        }
        function validate_fecha(fecha)
        {
            var patron=new RegExp("^(19|20)+([0-9]{2})([-])([0-9]{1,2})([-])([0-9]{1,2})$");

            if(fecha.search(patron)==0)
            {
                var values=fecha.split("-");
                if(isValidDate(values[2],values[1],values[0]))
                {
                    return true;
                }
            }
            return false;
        }
        function calcularDias()
        {
            var fechaInicial=document.getElementById("fecha_inicio").value;
            var fechaFinal=document.getElementById("fecha_fin").value;
            var resultado="";
            if(validate_fecha(fechaInicial) && validate_fecha(fechaFinal))
            {
                inicial=fechaInicial.split("-");
                final=fechaFinal.split("-");
                // obtenemos las fechas en milisegundos
                var dateStart=new Date(inicial[0],(inicial[1]-1),inicial[2]);
                var dateEnd=new Date(final[0],(final[1]-1),final[2]);

                if(dateStart>dateEnd){
                    alert("La fecha inicial es posterior a la fecha final");
                    document.getElementById("fecha_fin").value='';

                }
            }}

    </script>
@endsection

