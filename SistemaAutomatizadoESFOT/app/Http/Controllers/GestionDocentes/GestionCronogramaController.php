<?php

namespace App\Http\Controllers\GestionDocentes;

use App\gestionPeriodo\tbl_periodo as periodo;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Imports\CsvImport;
use Maatwebsite\Excel\Facades\Excel;
use DB;
use App\gestionAsistencia\tbl_cronograma as cronograma;
use App\Http\Requests\ValidacionSubirCronograma as RequestSubir;
use App\gestionAsistencia\tbl_materia as materia;
use App\gestionAsistencia\tbl_carrera as carrera;
//use App\Docente as docente;
use App\User as docente;

class GestionCronogramaController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');


    }

    public function index($id){
        $cronogramas=cronograma::where('id_docente',$id)->get();
        $docentes=docente::find($id);
        $periodos=periodo::all();
        $materias=materia::where('estado',1)->get();
        $carreras=carrera::where('estado',1)->get();
       // dd($cronogramas);
        return view('gestioncronogramas.gestionCronograma',compact('cronogramas','docentes','periodos','materias','carreras'));
    }
    public function subir($id){
        $cronogramas=cronograma::where('id_docente',$id)->get();
        $docentes=docente::find($id);
        $periodos=periodo::where('estado',1)->get();
        $materias=materia::where('estado',1)->get();
        $carreras=carrera::where('estado',1)->get();
        // dd($cronogramas);
        return view('gestioncronogramas.gestionSubir',compact('cronogramas','docentes','periodos','materias','carreras'));

    }

    public function csv_import(RequestSubir $request){
        //dd($request->all());
        $id_docente =$_POST["id_docente"];
        $file = $request->file('file');
        //Excel::import(new CsvImport, request()->file('file'));
        Excel::import(new CsvImport, $file);

        //return back()->with('success', 'Importación realizada con éxito!!');
        return redirect('GestionCronograma/'.$id_docente)->with('success', 'Importación realizada con éxito!!');

    }

    public function eliminar_masivo(){

        $a =$_POST["id_cronograma"];
        $array1 = explode(',', $a[0]);
        if(count($array1)>0){
            foreach ($array1 as $dato ) {
                $cronogramas = cronograma::find($dato);
                $cronogramas->delete();
            }
        }
         return back()->with('success', 'Temas Removidos Exitosamente!!');
    }

    public function buscar($id_periodo,$id_do){
        $id =$id_do;
        $cronogramas = DB::connection('SistemaEsfot')->select("SELECT id_cronograma,fecha,hora_inicio,hora_fin,capitulo,tema,detalle,materia,carrera FROM tbl_cronograma,tbl_materia,tbl_carrera WHERE id_periodo=$id_periodo
        and id_docente=$id and tbl_materia.id_materia=tbl_cronograma.id_materia and id_carrera=id_carrera_fk ;");
        return response()->json($cronogramas);

    }

    public function dependencia_carrera($id)
    {
        $materias = materia::where('id_carrera_fk', $id)->get();
        return response()->json($materias);
        //return json_encode($subdepars);
    }




}
