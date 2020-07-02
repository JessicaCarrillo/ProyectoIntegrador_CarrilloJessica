<?php

namespace App\Http\Controllers\GestionDocentes;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\gestionAsistencia\tbl_carrera as carrera;
use App\Http\Requests\ValidacionCarrera as RequestCarrera;

class GestionCarrerasController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');


    }
    public function index(){
        $carreras=carrera::all();
        return view('gestioncarreras.listaCarreras',compact('carreras'));
    }

    public function create(){
        return view('gestioncarreras.NuevaCarrera');
    }

    public function store(RequestCarrera $request){
        $carreras = new carrera();
        $carreras->carrera = $request->carrera;
        $carreras->estado = 1;
        $carreras->save();
        return redirect('GestionCarreras')->with('success', 'Carrera Añadida Exitosamente!!');
    }

    public  function edit($id_carrera){
        $carreras = carrera::find($id_carrera);
        return view('gestioncarreras.EditarCarrera',compact('carreras'));

    }
    public function update(RequestCarrera $request,$id_carrera){
        $carreras = carrera::find($id_carrera);
        $carreras->carrera = $request->carrera;
        $carreras->save();
        return redirect('GestionCarreras')->with('success', 'Carrera Editada Exitosamente!!');


    }
    public function CambioEstadoCarrera(Request $request)
    {
        $carreras = carrera::find($request->id);
        $carreras->estado = $request->estado;
        $carreras->save();

        return response()->json(['message'=>'Estado de carrera cambiado exitosamente!!']);
    }

    public function eliminar($id){
        $carreras = carrera::find($id);
        $carreras->delete();
        return redirect('GestionCarreras')->with('success', 'Carrera Removida Exitosamente!!');
    }


}
