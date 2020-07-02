@extends('layouts.usuario')
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header" align="center" style="font-size: xx-large">EDITAR PROYECTOR</div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                        <form  action="/EditarProyectorAdministrador/{{$proyectores->id_proyector}}"  method="post">
                            <input type="hidden" name="_token" value="{{csrf_token()}}">
                            {{ method_field('PUT') }}
                            <div class="form-group">
                                <label for="proyector">Proyector:</label>
                                <input id="proyector" name="proyector" class="form-control" type="text" placeholder="Proyector N°" value="{{$proyectores->proyector}}">
                                {!! $errors->first('proyector','<small style="color:Red;">:message</small>')!!}
                            </div>
                            <div class="form-group">
                                <label for="name">Descripcion:</label>
                                <select name="id_estado_devolucion" id="id_estado_devolucion" class="form-control"  >
                                    <option value="{{$proyectores->estado_dev->id_estado}}">{{$proyectores->estado_dev->descripcion}}</option>
                                    @foreach($estados_devolucion as $estado_devolucion)
                                        <option value="{{$estado_devolucion['id_estado']}}">{{$estado_devolucion['descripcion']}}</option>
                                    @endforeach
                                </select>
                                {!! $errors->first('id_estado_devolucion','<small style="color:Red;">:message</small>')!!}
                            </div>
                            <div class="row" >
                                <div class="col">
                                    <label for="name">Marca:</label>
                                    <input id="marca" name="marca" class="form-control" type="text" placeholder="Marca" value="{{$proyectores->marca}}">
                                    {!! $errors->first('marca','<small style="color:Red;">:message</small>')!!}
                                </div>
                                <div class="col">
                                    <label for="name">Modelo:</label>
                                    <input id="modelo" name="modelo" class="form-control" type="text" placeholder="Modelo" value="{{$proyectores->modelo}}">
                                    {!! $errors->first('modelo','<small style="color:Red;">:message</small>')!!}

                                </div>
                                <div class="col">
                                    <label for="name">Serie:</label>
                                    <input id="serie" name="serie" class="form-control" type="text" placeholder="Serie" value="{{$proyectores->serie}}">
                                    {!! $errors->first('color','<small style="color:Red;">:message</small>')!!}

                                </div>
                                <div class="col">
                                    <label for="name">Color:</label>
                                    <input id="color" name="color" class="form-control" type="text" placeholder="Color" value="{{$proyectores->color}}">
                                    {!! $errors->first('color','<small style="color:Red;">:message</small>')!!}

                                </div>

                            </div>
                            <br>
                            <div class="form-group">
                                <label for="name">Componentes:</label>
                                <div class="form-group" align="center">

                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="checkbox" id="componente"  name="componente1" value="HDMI"  onclick="rangoComponente('componente');">
                                        <label class="form-check-label" for="inlineCheckbox1">HDMI</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="checkbox" id="componente" name="componente2" value="Cable USB-B"  onclick="rangoComponente('componente');">
                                        <label class="form-check-label" for="inlineCheckbox1">Cable USB-B</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="checkbox" id="componente" name="componente3" value="Cable serial"  onclick="rangoComponente('componente');">
                                        <label class="form-check-label" for="inlineCheckbox1">Cable serial</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="checkbox" id="componente" name="componente4" value="Cable de poder"  onclick="rangoComponente('componente');" >
                                        <label class="form-check-label" for="inlineCheckbox1">Cable de poder</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="checkbox" id="componente" name="componente5" value="Extensión 110V"  onclick="rangoComponente('componente');" >
                                        <label class="form-check-label" for="inlineCheckbox1">Extensión 110V</label>
                                    </div>
                                    <input type="hidden" id="componentes" name="componentes[]" value="{{$proyectores->componentes}}">
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
        function rangoComponente(checkboxName) {
            var checkboxes = document.querySelectorAll('input[id="' + checkboxName + '"]:checked'), values = [];
            Array.prototype.forEach.call(checkboxes, function(el) {
                values.push(el.value);

            });
            $("#componentes").val(values);
        };


        var str = document.getElementById("componentes").value;
        var oldArray = str.split(',');
        var newArray = [];
        while(oldArray.length){
            let start = 0;
            let end = 1;
            newArray.push(oldArray.slice(start, end));
            oldArray.splice(start, end);
        }
        //console.log(newArray);
        for (var valor of newArray) {
            console.log(valor[0]);
            if(valor[0]=='HDMI' ){
                $("input[name=componente1]").val([valor[0]]);

            } if(valor[0]=='Cable USB-B'){
                $("input[name=componente2]").val([valor[0]]);

            }if(valor[0]=='Cable serial'){
                $("input[name=componente3]").val([valor[0]]);

            }if(valor[0]=='Cable de poder'){
                $("input[name=componente4]").val([valor[0]]);

            }if(valor[0]=='Extensión 110V'){
                $("input[name=componente5]").val([valor[0]]);

            }
        };

    </script>
@endsection



