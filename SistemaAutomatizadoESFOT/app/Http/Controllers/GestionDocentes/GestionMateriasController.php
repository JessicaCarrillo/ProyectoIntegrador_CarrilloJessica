<?php

namespace App\Http\Controllers\GestionDocentes;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\gestionAsistencia\tbl_materia as materia;
use App\gestionAsistencia\tbl_carrera as carrera;
use App\Http\Requests\ValidacionMateria as RequestMateria;

class GestionMateriasController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');


    }
    public function index(){
        $materias=materia::all();
        $carreras=carrera::where('estado',1)->get();
        return view('gestionmaterias.listaMaterias',compact('materias','carreras'));
    }

    public function create(){
        $carreras=carrera::where('estado',1)->get();
        return view('gestionmaterias.NuevaMateria',compact('carreras'));
    }

    public function store(RequestMateria $request){
        $materias = new materia();
        $materias->materia = $request->materia;
        $materias->id_carrera_fk = $request->id_carrera_fk;
        $materias->estado = 1;
        $materias->save();
        return redirect('GestionMaterias')->with('success', 'Materia Añadida Exitosamente!!');
    }

    public  function edit($id_materia){
        $materias = materia::find($id_materia);
        $carreras=carrera::where('estado',1)->get();
        return view('gestionmaterias.EditarMateria',compact('materias','carreras'));

    }

    public function update(RequestMateria $request,$id_materia){
        $materias = materia::find($id_materia);
        $materias->materia = $request->materia;
        $materias->id_carrera_fk = $request->id_carrera_fk;
        $materias->save();
        return redirect('GestionMaterias')->with('success', 'Materia Editada Exitosamente!!');


    }
    public function CambioEstadoMateria(Request $request)
    {
        $materias = materia::find($request->id);
        $materias->estado = $request->estado;
        $materias->save();

        return response()->json(['message'=>'Estado de materia cambiado exitosamente!!']);
    }

    public function eliminar($id){
        $materias = materia::find($id);
        $materias->delete();
        return redirect('GestionMaterias')->with('success', 'Materia Removida Exitosamente!!');
    }
}
