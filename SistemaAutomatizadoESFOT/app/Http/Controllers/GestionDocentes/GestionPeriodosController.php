<?php

namespace App\Http\Controllers\GestionDocentes;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\gestionPeriodo\tbl_periodo as periodo;
use App\Http\Requests\ValidacionPeriodo as RequestPeriodo;

class GestionPeriodosController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');


    }
    public function index(){
        $periodos=periodo::all();
        return view('gestionperiodos.listaPeriodosAcademicos',compact('periodos'));
    }

    public function create(){
        return view('gestionperiodos.NuevoPeriodo');
    }

    public function store(RequestPeriodo $request){
        $periodos = new periodo();
        $periodos->periodo = $request->periodo;
        $periodos->fecha_inicio = $request->fecha_inicio;
        $periodos->fecha_fin = $request->fecha_fin;
        $periodos->estado=1;
        $periodos->save();
        return redirect('GestionPeriodos')->with('success', 'Período Añadido Exitosamente!!');

    }
    public function edit($id){
        $periodos = periodo::find($id);
        return view('gestionperiodos.EditarPeriodo',compact('periodos'));

    }
    public function update(RequestPeriodo  $request,$id){
        $periodos = periodo::find($id);
        $periodos->periodo = $request->periodo;
        $periodos->fecha_inicio = $request->fecha_inicio;
        $periodos->fecha_fin = $request->fecha_fin;
        $periodos->save();
        return redirect('GestionPeriodos')->with('success', 'Período Editado Exitosamente!!');

    }
    public function eliminar($id){
        $periodos = periodo::find($id);
        $periodos->delete();
        return redirect('GestionPeriodos')->with('success', 'Período eliminado!!');
    }
}
