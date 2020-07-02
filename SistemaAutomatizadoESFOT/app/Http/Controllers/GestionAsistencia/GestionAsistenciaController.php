<?php

namespace App\Http\Controllers\GestionAsistencia;

use App\gestionAsistencia\tbl_carrera as carrera;
use App\gestionAsistencia\tbl_materia as materia;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Docente as docente;
use App\gestionAsistencia\tbl_cronograma as cronograma;
use App\gestionAsistencia\tbl_ficha_asistencia as asistencia;
use Illuminate\Support\Facades\Auth;
use DB;


class GestionAsistenciaController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:docente');
        //parent::__construct();
    }
    public function index(){
        $carreras=carrera::where('estado',1)->get();
        $dato = Auth::user()->id;
        $now = Carbon::now();
        $date_actual = $now->format('Y-m-d');

       // $cronogramas=cronograma::where('id_docente',$dato)->where('fecha',$date_actual)->get();
       /* $cronogramas=cronograma::where([
            ['id_docente', $dato],
            //['fecha', $date_actual],
        ])->get();*/
        $cronogramas=DB::connection('SistemaEsfot')->select("SELECT  capitulo FROM tbl_cronograma, tbl_periodo where id_docente=$dato and tbl_periodo.id_periodo=tbl_cronograma.id_periodo and tbl_periodo.estado=1 and tbl_cronograma.estado is null;");
        $asistencias=DB::connection('SistemaEsfot')->select("SELECT * FROM `tbl_ficha_asistencia`,`tbl_cronograma` WHERE tbl_cronograma.id_cronograma=tbl_ficha_asistencia.id_cronograma and  id_docente=$dato and fecha_registro='$date_actual'");
        $materias=DB::connection('SistemaEsfot')->select("SELECT DISTINCT tbl_materia.id_materia, materia FROM tbl_cronograma,tbl_materia,tbl_periodo WHERE tbl_periodo.id_periodo=tbl_cronograma.id_periodo and  tbl_periodo.estado=1 
        and tbl_cronograma.id_materia=tbl_materia.id_materia and id_docente=$dato;");
        return view('gestionasistencia/GestionAsistencia',compact('cronogramas','asistencias','materias'));
    }

    public function dependencia($capitulo)
    {
        $dato = Auth::user()->id;
        $now = Carbon::now();
        $date_actual = $now->format('Y-m-d');
        $capitulos=DB::connection('SistemaEsfot')->select("SELECT  * FROM tbl_cronograma, tbl_periodo where id_docente=$dato and capitulo='$capitulo' and tbl_periodo.id_periodo=tbl_cronograma.id_periodo and tbl_periodo.estado=1 and tbl_cronograma.estado IS NULL ;");
        return response()->json($capitulos);
    }

    public function dependencia_materia($id)
    {
        $dato = Auth::user()->id;
        $now = Carbon::now();
        $tema=DB::connection('SistemaEsfot')->select("SELECT id_cronograma,tema, capitulo FROM tbl_cronograma, tbl_periodo where id_docente=$dato and id_materia='$id' and tbl_periodo.id_periodo=tbl_cronograma.id_periodo and tbl_periodo.estado=1 and tbl_cronograma.estado IS NULL ;");
        return response()->json($tema);
    }

    public function dependenciaTema($tema)
    {
        $dato = Auth::user()->id;
        $now = Carbon::now();
        $date_actual = $now->format('Y-m-d');
        //$temas = cronograma::where('capitulo', $tema)->where('id_docente',$dato)->get();
        $temas=DB::connection('SistemaEsfot')->select("SELECT * FROM tbl_cronograma, tbl_periodo where id_docente=$dato and id_cronograma='$tema' and tbl_periodo.id_periodo=tbl_cronograma.id_periodo and tbl_periodo.estado=1 and tbl_cronograma.estado IS NULL ;");

        return response()->json($temas);
        //return json_encode($subdepars);
    }

    public function store(Request $request){
       // dd($request->all());
        $asistencia = new asistencia();
        $asistencia->id_cronograma = $request->id_cronograma;
        $asistencia->observacion = $request->permiso;
        $asistencia->hora_registro = $request->hora_registro;
        $asistencia->fecha_registro = $request->fecha;
        $asistencia->estado = 0;
        $asistencia->save();

        $cronograma=cronograma::find($request->id_cronograma);
        $cronograma->estado=1;
        $cronograma->mensaje_enviado=1;
        $cronograma->save();

        return redirect()->route('docente.GestionAsistencia')->with('success', 'Asistencia Registrada Exitosamente!!');

    }
    public function eliminar(Request $request, $id_asistencia){
        //dd($request->all());
        $cronograma=cronograma::find($request->id_cronograma);
        $cronograma->estado=null;
        $cronograma->mensaje_enviado=0;
        $cronograma->save();

        $asistencia = asistencia::find($id_asistencia);
        $asistencia->delete();


        return redirect()->route('docente.GestionAsistencia')->with('success', 'Asistencia Removida Exitosamente!!');
    }
}
