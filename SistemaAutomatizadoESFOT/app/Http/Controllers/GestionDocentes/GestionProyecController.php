<?php

namespace App\Http\Controllers\GestionDocentes;

use App\gestionProyector\tbl_ficha_proyector as ficha_proyector;
use App\Http\Requests\ValidacionReservarProyector as RequestReservar;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\gestionProyector\tbl_proyector as proyector;
use App\gestionProyector\tbl_estados_devolucion as estado_devolucion;
use App\Http\Requests\ValidacionProyector as RequestProyector;
use DB;
use Illuminate\Support\Facades\Auth;

class GestionProyecController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');


    }
    public function index(){
        //$proyectores=proyector::where('estado',1)->get();
        $proyectores=proyector::all();
        $numero_proyectores=proyector::count();
        $estados_devolucion=estado_devolucion::where('estado',1)->get();

        return view('gestionproyectores.listaProyectores',compact('proyectores','numero_proyectores','estados_devolucion'));

    }
    public function create(){
        $estados_devolucion=estado_devolucion::where('estado',1)->get();
        return view('gestionproyectores.NuevoProyector',compact('estados_devolucion'));

    }
    public function store(RequestProyector $request){
        $proyectores = new proyector();
        $proyectores->proyector = $request->proyector;
        $proyectores->id_estado_devolucion = $request->id_estado_devolucion;
        $proyectores->estado = 0;
        $proyectores->estado_activo = 1;
        $proyectores->save();
        return redirect('Proyectores')->with('success', 'Proyector Añadido Exitosamente!!');
    }
    public  function edit($id){
        $proyectores = proyector::find($id);
        $estados_devolucion=estado_devolucion::where('estado',1)->get();
        return view('gestionproyectores.EditarProyector',compact('proyectores','estados_devolucion'));

    }
    public function update(RequestProyector  $request, $id){
        $proyectores = proyector::find($id);
        $proyectores->proyector = $request->proyector;
        $proyectores->id_estado_devolucion = $request->id_estado_devolucion;
        $componentes =$_POST["componentes"];
        $array1 = explode(',', $componentes[0]);
        $array = implode(',', $array1);
        $proyectores->componentes=$array;
        $proyectores->save();
        return redirect('Proyectores')->with('success', 'Proyector Editado Exitosamente!!');

    }

    public function eliminar($id){
        $proyectores = proyector::find($id);
        $proyectores->estado='0';
        $proyectores->save();
        return redirect('Proyectores')->with('success', 'Proyector Removido Exitosamente!!');
    }

    public function destroy($id){
        $proyectores = proyector::find($id);
        $proyectores->delete();
        return redirect('Proyectores')->with('success', 'Proyector Removido Exitosamente!!');
    }

    public function cambioestado(Request $request)
    {
        $proyectores = proyector::find($request->id_proyector);
        $proyectores->estado_activo = $request->estado_activo;
        $proyectores->save();

        return response()->json(['message'=>'Estado de proyector cambiado exitosamente!!']);
    }

    public function abrir_puerta(){

        $val = "0";
        $archive = 'C:\xampp\htdocs\pyphp\pyphp.txt';
        $manager = fopen($archive, "w");
        if($_POST["id_proyector"]==1){
            $val = "1";
            $write = fwrite($manager,$val);
            fclose($manager);

        }
        if($_POST["id_proyector"]==2){
            $val = "2";
            $write = fwrite($manager,$val);
            fclose($manager);

        }
        if($_POST["id_proyector"]==3){
            $val = "3";
            $write = fwrite($manager,$val);
            fclose($manager);

        }
        if($_POST["id_proyector"]==4){
            $val = "4";
            $write = fwrite($manager,$val);
            fclose($manager);

        }
        if($_POST["id_proyector"]==5){
            $val = "5";
            $write = fwrite($manager,$val);
            fclose($manager);

        }
        if($_POST["id_proyector"]==6){
            $val = "6";
            $write = fwrite($manager,$val);
            fclose($manager);

        }
        if($_POST["id_proyector"]==7){
            $val = "7";
            $write = fwrite($manager,$val);
            fclose($manager);

        }
        if($_POST["id_proyector"]==8){
            $val = "8";
            $write = fwrite($manager,$val);
            fclose($manager);

        }
        if($_POST["id_proyector"]==9){
            $val = "9";
            $write = fwrite($manager,$val);
            fclose($manager);

        }
        if($_POST["id_proyector"]==10){
            $val = "10";
            $write = fwrite($manager,$val);
            fclose($manager);

        }
        if($_POST["id_proyector"]==11){
            $val = "11";
            $write = fwrite($manager,$val);
            fclose($manager);

        }
        if($_POST["id_proyector"]==12){
            $val = "12";
            $write = fwrite($manager,$val);
            fclose($manager);

        }
        if($_POST["id_proyector"]==13){
            $val = "13";
            $write = fwrite($manager,$val);
            fclose($manager);

        }
        if($_POST["id_proyector"]==14){
            $val = "14";
            $write = fwrite($manager,$val);
            fclose($manager);

        }
        if($_POST["id_proyector"]==15){
            $val = "15";
            $write = fwrite($manager,$val);
            fclose($manager);

        }
        if($_POST["id_proyector"]==16){
            $val = "16";
            $write = fwrite($manager,$val);
            fclose($manager);

        }
        if($_POST["id_proyector"]==17){
            $val = "17";
            $write = fwrite($manager,$val);
            fclose($manager);

        }
        if($_POST["id_proyector"]==18){
            $val = "18";
            $write = fwrite($manager,$val);
            fclose($manager);

        }
        if($_POST["id_proyector"]==19){
            $val = "19";
            $write = fwrite($manager,$val);
            fclose($manager);

        }
        if($_POST["id_proyector"]==20){
            $val = "20";
            $write = fwrite($manager,$val);
            fclose($manager);

        }

        return redirect('Proyectores')->with('success', 'Puerta Abierta Exitosamente!!');

    }

}
