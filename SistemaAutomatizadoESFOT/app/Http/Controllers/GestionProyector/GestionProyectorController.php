<?php

namespace App\Http\Controllers\GestionProyector;

use App\Http\Requests\ValidacionProyector as RequestProyector;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\gestionProyector\tbl_proyector as proyector;
use App\gestionProyector\tbl_ficha_proyector as ficha_proyector;
use App\gestionProyector\tbl_estados_devolucion as estado_devolucion;
use App\gestionAsistencia\tbl_cronograma as cronograma;
use App\Http\Requests\ValidacionDevolverProyector as RequestDevolver;
use App\Http\Requests\ValidacionReservarProyector as RequestReservar;

use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use DB;
use File;
use League\Flysystem\Exception;
use stdClass;

class GestionProyectorController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:docente');
        //parent::__construct();
    }
    public static function EstadoProyector($estado){
        return ($estado == 1)? 'Entregado' : 'Retirado';
    }
    public static function round_time( $time, $round_to_minutes = 60, $type = 'auto' ) {
        $round = array( 'auto' => 'round', 'up' => 'ceil', 'down' => 'floor' );
        $round = @$round[ $type ] ? $round[ $type ] : 'round';
        $seconds = $round_to_minutes * 60;
        if(substr_count($time,":")==2)
            return date( 'H:i:s', $round( strtotime( $time ) / $seconds ) * $seconds );
        else
            return date( 'H:i', $round( strtotime( $time ) / $seconds ) * $seconds );
    }


    public function index(){

        //$dato = Auth::user()->id_docente;
        $dato = Auth::user()->id;
        $now = Carbon::now();
        $time=$now->toTimeString();
        $date_actual = $now->format('Y-m-d');
        $proyectores=proyector::all();
        $estados_devolucion=estado_devolucion::where('estado',1)->get();

        $fichas_proyectores=ficha_proyector::where([
            ['id_docente_fk', $dato],
            ['fecha', $date_actual],
        ])->get();
        $cronogramas=DB::connection('SistemaEsfot')->select("Select *from tbl_cronograma where id_docente=$dato and fecha='$date_actual';");
        //dd($cronogramas);
        if (count($cronogramas)>0){
            foreach ($cronogramas as $cronograma){
                $hora_fin=$cronograma->hora_fin;

            }
        }else{
            $hora_fin1 = strtotime("+2 hour", strtotime($time));
            $hora_fin = date('H:i', $hora_fin1);
           // $hora_fin=round($hora_fin1,30, "down");
            //$hora_fin='';
        }
         return view('gestionproyectores/GestionProyector',compact('proyectores','fichas_proyectores','hora_fin','estados_devolucion'));
    }

    public function reservar(RequestReservar $request){
        //dd($request->all());

        if ($request->ajax()) {

            $hora_entrega_f = $_POST['hora_entrega'];
            $now = Carbon::now();
            $date_actual = $now->format('Y-m-d');
            $dato = Auth::user()->id;

            $ficha_docentes = new ficha_proyector();
            $ficha_docentes->fecha = $date_actual;

            if ($hora_entrega_f != '') {
                $hora_entrega1 = strtotime("+15 minutes", strtotime($request->hora_entrega));
                $hora_entrega = date('H:i:s', $hora_entrega1);
                $ficha_docentes->hora_entrega = $hora_entrega;
            }

            $ficha_docentes->hora_retiro = $request->hora_retiro;
            $ficha_docentes->id_docente_fk = $dato;
            $ficha_docentes->id_proyector_fk = $request->id_proyector;
            $ficha_docentes->estado = 0;
            $ficha_docentes->save();

            $proyector = proyector::find($request->id_proyector);
            $proyector->estado = 0;
            $proyector->save();
        }
        if (Auth::guard('docente')->user()->roles_usuarios[0]->rol == 'Administrador') {
            return redirect('GestionProyectorAdministrador')->with('success', 'Dispositivo Reservado Exitosamente!!');

        } else {
            return redirect()->route('docente.GestionProyector')->with('success', 'Dispositivo Reservado Exitosamente!!');
           // return response()->json(['message'=>'Estado de proyector cambiado exitosamente!!']);
            //return back()->response()->json(['message'=>'Estado de proyector cambiado exitosamente!!']);

        }

    }

    public function store(RequestReservar $request)
    {
        //dd($request->all());
       /* $fecha=$_POST['hora_entrega'];
        $now = Carbon::now();
        $time=$now->toTimeString();
        $date_actual = $now->format('Y-m-d');
        $dato = Auth::user()->id;

        $ficha_docentes = new ficha_proyector();
        $ficha_docentes->fecha = $date_actual;
        if($fecha!=''){
            $hora_entrega1 = strtotime("+15 minutes", strtotime($request->hora_entrega));
            $hora_entrega = date('H:i:s', $hora_entrega1);
            $ficha_docentes->hora_entrega = $hora_entrega;
        }

        $ficha_docentes->hora_retiro = $request->hora_retiro;

        $ficha_docentes->id_docente_fk = $dato;
        $ficha_docentes->id_proyector_fk = $request->id_proyector;
        $ficha_docentes->estado=0;
        $ficha_docentes->save();

        $proyector=proyector::find($request->id_proyector);
        $proyector->estado_activo=1;
        $proyector->save();*/

        if ($request->ajax()) {

            $val = "0";
            $archive = 'C:\xampp\htdocs\pyphp\pyphp.txt';
            $manager = fopen($archive, "w");
            if ($_POST["id_proyector"] == 1) {
                $val = "1";
                $write = fwrite($manager, $val);
                fclose($manager);
            }
            if ($_POST["id_proyector"] ==2) {
                $val = "2";
                $write = fwrite($manager, $val);
                fclose($manager);


            }
            if ($_POST["id_proyector"] ==3) {
                $val = "3";
                $write = fwrite($manager, $val);
                fclose($manager);

            }
            if ($_POST["id_proyector"]==4) {
                $val = "4";
                $write = fwrite($manager, $val);
                fclose($manager);

            }
            if ($_POST["id_proyector"]==5) {
                $val = "5";
                $write = fwrite($manager, $val);
                fclose($manager);

            }
            if ($_POST["id_proyector"]==6) {
                $val = "6";
                $write = fwrite($manager, $val);
                fclose($manager);

            }
            if ($_POST["id_proyector"]==7) {
                $val = "7";
                $write = fwrite($manager, $val);
                fclose($manager);

            }
            if ($_POST["id_proyector"]==8) {
                $val = "8";
                $write = fwrite($manager, $val);
                fclose($manager);

            }
            if ($_POST["id_proyector"]==9) {
                $val = "9";
                $write = fwrite($manager, $val);
                fclose($manager);

            }
            if ($_POST["id_proyector"]==10) {
                $val = "10";
                $write = fwrite($manager, $val);
                fclose($manager);

            }
            if ($_POST["id_proyector"]==11) {
                $val = "11";
                $write = fwrite($manager, $val);
                fclose($manager);

            }
            if ($_POST["id_proyector"]==12) {
                $val = "12";
                $write = fwrite($manager, $val);
                fclose($manager);

            }
            if ($_POST["id_proyector"]==13) {
                $val = "13";
                $write = fwrite($manager, $val);
                fclose($manager);

            }
            if ($_POST["id_proyector"]==14) {
                $val = "14";
                $write = fwrite($manager, $val);
                fclose($manager);

            }
            if ($_POST["id_proyector"]==15) {
                $val = "15";
                $write = fwrite($manager, $val);
                fclose($manager);

            }
            if ($_POST["id_proyector"]==16) {
                $val = "16";
                $write = fwrite($manager, $val);
                fclose($manager);

            }
            if ($_POST["id_proyector"]==17) {
                $val = "17";
                $write = fwrite($manager, $val);
                fclose($manager);

            }
            if ($_POST["id_proyector"]==18) {
                $val = "18";
                $write = fwrite($manager, $val);
                fclose($manager);

            }
            if ($_POST["id_proyector"]==19) {
                $val = "19";
                $write = fwrite($manager, $val);
                fclose($manager);

            }
           // if (isset($_POST["20"])) {
            if ($_POST["id_proyector"]==20) {
                $val = "20";
                $write = fwrite($manager, $val);
                fclose($manager);

            }
        }
            //estado();
            if (Auth::guard('docente')->user()->roles_usuarios[0]->rol == 'Administrador') {
                return redirect('GestionProyectorAdministrador')->with('success', 'Dispositivo Reservado Exitosamente!!');

            } else {
               // return response()->json(['message'=>'Estado de proyector cambiado exitosamente!!']);
                //return back()->response()->json(['message'=>'Estado de proyector cambiado exitosamente!!']);
                return redirect()->route('docente.GestionProyector')->with('success', 'Dispositivo Reservado Exitosamente!!');

            }



    }
    public function devolver_proyector(RequestDevolver $request){
        if ($request->ajax()) {
            $ficha_proyector = ficha_proyector::find($request->id_ficha_proyector);
            $ficha_proyector->hora_entrega = $request->hora_entrega;
            $ficha_proyector->id_estado_devolucion_fk = $request->id_estado_devolucion;
            $ficha_proyector->observacion=$request->observacion;
            $ficha_proyector->estado = 1;
            $ficha_proyector->save();

            $proyector=proyector::find($request->id_proyector_fk);
            $proyector->id_estado_devolucion = $request->id_estado_devolucion;
            $proyector->estado = 1;
            $proyector->save();



        }
        if(Auth::guard('docente')->user()->roles_usuarios[0]->rol=='Administrador'){
            return redirect('GestionProyectorAdministrador')->with('success', 'Dispositivo Entregado Exitosamente!!');

        }else{
            return redirect()->route('docente.GestionProyector')->with('success', 'Dispositivo Entregado Exitosamente!!');

        }

    }

    public function update(RequestDevolver $request)
    {
        //dd($request->all());


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

        if(Auth::guard('docente')->user()->roles_usuarios[0]->rol=='Administrador'){
            return redirect('GestionProyectorAdministrador')->with('success', 'Dispositivo Entregado Exitosamente!!');

        }else{
            return redirect('GestionProyector')->with('success', 'Dispositivo Entregado Exitosamente!!');

        }

    }

    public function estado_puerta(){
        $filename = 'C:\xampp\htdocs\pyphp\lectura.txt';
        $contents = File::get($filename);
        $proyectores=str_replace("\r","",$contents);
        $array = explode("\n", $proyectores);
        $estado = substr($array[0], -1);
        $std = new stdClass();
        $std->Estado = $estado;
        $json = json_encode($std);
        return $json;
       }

    public function cambio_estado(){
        $archive = 'C:\xampp\htdocs\pyphp\pyphp.txt';
        $manager = fopen($archive, "w");
        $val = "21";
        $write = fwrite($manager,$val);
        fclose($manager);
        return "ok";
}


    public function leer(){
        try
        {
            $filename = 'C:\xampp\htdocs\pyphp\lectura.txt';
            $contents = File::get($filename);

            if($contents!=''){
                $proyectores=str_replace("\r","",$contents);
                $array = explode("\n", $proyectores);
                $contar= count(file($filename));
                if($contar==21){
                    $a1 = substr($array[0], -1);
                    $b1 = substr($array[1], -1);
                    $c1 = substr($array[2], -1);
                    $d1 = substr($array[3], -1);
                    $e1 = substr($array[4], -1);
                    $f1 = substr($array[5], -1);
                    $g1 = substr($array[6], -1);
                    $h1 = substr($array[7], -1);
                    $i1 = substr($array[8], -1);
                    $j1 = substr($array[9], -1);
                    $k1 = substr($array[10], -1);
                    $l1 = substr($array[11], -1);
                    $m1 = substr($array[12], -1);
                    $n1 = substr($array[13], -1);
                    $o1 = substr($array[14], -1);
                    $p1 = substr($array[15], -1);
                    $q1 = substr($array[16], -1);
                    $r1 = substr($array[17], -1);
                    $s1 = substr($array[18], -1);
                    $t1 = substr($array[19], -1);
                    $u1 = substr($array[20], -1);

                    //return response()->json($array)
                    //$a=json_encode($array,true);
                    $std = new stdClass();
                    $std->Estado = $a1;
                    $std->Proyector1 = $b1;
                    $std->Proyector2 = $c1;
                    $std->Proyector3 = $d1;
                    $std->Proyector4 = $e1;
                    $std->Proyector5 = $f1;
                    $std->Proyector6 = $g1;
                    $std->Proyector7 = $h1;
                    $std->Proyector8 = $i1;
                    $std->Proyector9 = $j1;
                    $std->Proyector10 = $k1;
                    $std->Proyector11 = $l1;
                    $std->Proyector12 = $m1;
                    $std->Proyector13 = $n1;
                    $std->Proyector14 = $o1;
                    $std->Proyector15 = $p1;
                    $std->Proyector16 = $q1;
                    $std->Proyector17 = $r1;
                    $std->Proyector18 = $s1;
                    $std->Proyector19 = $t1;
                    $std->Proyector20 = $u1;
                    $json = json_encode($std);
                    return $json;

                }else{
                    $std = new stdClass();
                    $std->Estado = '';
                    $std->Proyector1 = "";
                    $std->Proyector2 = "";
                    $std->Proyector3 = "";
                    $std->Proyector4 = "";
                    $std->Proyector5 = "";
                    $std->Proyector6 = "";
                    $std->Proyector7 = "";
                    $std->Proyector8 = "";
                    $std->Proyector9 = "";
                    $std->Proyector10 = "";
                    $std->Proyector11 = "";
                    $std->Proyector12 = "";
                    $std->Proyector13 = "";
                    $std->Proyector14 = "";
                    $std->Proyector15 = "";
                    $std->Proyector16 = "";
                    $std->Proyector17 = "";
                    $std->Proyector18 = "";
                    $std->Proyector19 = "";
                    $std->Proyector20 = "";
                    $json = json_encode($std);
                    return $json;
                    cambio_estado();

                }


                //dd(response()->json($json));
                //dd($json);

            }else{
                $std = new stdClass();
                $std->Estado = '';
                $std->Proyector1 = "";
                $std->Proyector2 = "";
                $std->Proyector3 = "";
                $std->Proyector4 = "";
                $std->Proyector5 = "";
                $std->Proyector6 = "";
                $std->Proyector7 = "";
                $std->Proyector8 = "";
                $std->Proyector9 = "";
                $std->Proyector10 = "";
                $std->Proyector11 = "";
                $std->Proyector12 = "";
                $std->Proyector13 = "";
                $std->Proyector14 = "";
                $std->Proyector15 = "";
                $std->Proyector16 = "";
                $std->Proyector17 = "";
                $std->Proyector18 = "";
                $std->Proyector19 = "";
                $std->Proyector20 = "";
                $json = json_encode($std);
                return $json;
            }

        }
        catch (Exception $e)
        {
            echo 'Message: ' . $e->getMessage();
            echo "No existe el archivo";
        }

    }
    public function index_administrador(){
        $dato = Auth::user()->id;
        $now = Carbon::now();
        $date_actual = $now->format('Y-m-d');
        $proyectores=proyector::all();
        $estados_devolucion=estado_devolucion::where('estado',1)->get();
        $fichas_proyectores=ficha_proyector::where([
            ['id_docente_fk', $dato],
            ['fecha', $date_actual],
        ])->get();

        return view('gestionproyectores/GestionProyectorAdministrador',compact('proyectores','fichas_proyectores','estados_devolucion'));


    }

    public function index_lista_pro(){
        //$proyectores=proyector::where('estado',1)->get();
        $proyectores=proyector::all();
        $estados_devolucion=estado_devolucion::where('estado',1)->get();

        return view('gestionproyectores/listaProyectoresAdministrador',compact('proyectores','estados_devolucion'));

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

        return redirect('ListaProyectorAdministrador')->with('success', 'Puerta Abierta Exitosamente!!');



    }

    public function cambioestado(Request $request)
    {
        $proyectores = proyector::find($request->id_proyector);
        $proyectores->estado_activo = $request->estado_activo;
        $proyectores->save();

        return response()->json(['message'=>'Estado de dispositivo cambiado exitosamente!!']);
    }

    public  function edit($id){
        $proyectores = proyector::find($id);
        $estados_devolucion=estado_devolucion::where('estado',1)->get();
        return view('gestionproyectores.EditarProyectorAdministrador',compact('proyectores','estados_devolucion'));

    }

    public function update_administrador(RequestProyector  $request, $id){
        $proyectores = proyector::find($id);
        $proyectores->proyector = $request->proyector;
        $proyectores->id_estado_devolucion = $request->id_estado_devolucion;
        $componentes =$_POST["componentes"];
        $array1 = explode(',', $componentes[0]);
        $array = implode(',', $array1);
        $proyectores->componentes=$array;
        $proyectores->save();
        return redirect('ListaProyectorAdministrador')->with('success', 'Dispositivo Editado Exitosamente!!');

    }



}
