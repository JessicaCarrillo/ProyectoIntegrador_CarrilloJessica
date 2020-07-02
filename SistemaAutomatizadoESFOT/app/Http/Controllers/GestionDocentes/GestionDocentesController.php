<?php

namespace App\Http\Controllers\GestionDocentes;
use App\Docente as docente;
use App\User as Usuario;
use App\gestionAsistencia\tbl_roles as rol;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\ValidacionDocente as  RequestDocente;

class GestionDocentesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');


    }
    public function index(){
        //$docentes=docente::where('estado', 1)->get();
        //$usuarios=Usuario::where('estado',1)->get();
        $usuarios=Usuario::all();
        $roles=rol::all();
        return view('gestiondocentes.listaDocentes',compact('usuarios','roles'));
    }

    public function create(){
        $roles=rol::all();
        return view('gestiondocentes.NuevoDocente',compact('roles'));

    }
    public function store(RequestDocente $request){

        $docentes = new Usuario();
        $docentes->id_biometrico = $request->id_biometrico;
        $docentes->name = $request->name;
        $docentes->email = $request->email;
       // $docentes->password=$request->password;
        $password = $_POST["password"];
        $hashed = Hash::make($password);
        $docentes->password=$hashed;
        $docentes->tipo_rol=$request->tipo_rol;
        $docentes->estado=1;
        $docentes->save();

        $id_biometrico=$request->id_biometrico;
        $name=$request->name;

        $process2 = shell_exec('C:\Python\Python36\python.exe C:\xampp\htdocs\SistemaAutomatizadoESFOT\SistemaAutomatizadoESFOT\public\pyscripts\usuarios.py 2>&1 "'.$id_biometrico.'" "'.$name.'"'  );
        //dd($process2);
        return redirect('GestionDocentes')->with('success', 'Docente Añadido Exitosamente!!');

    }
    public  function edit($id){
        $docentes = Usuario::find($id);
        $roles=rol::all();
        return view('gestiondocentes.EditarDocente',compact('docentes','roles'));

    }

    public function update(RequestDocente  $request,  $id){
        $docentes = Usuario::find($id);
        $docentes->id_biometrico = $request->id_biometrico;
        $docentes->name = $request->name;
        $docentes->email = $request->email;
        $password = $_POST["password"];
        if(!empty($password)){
            $hashed = Hash::make($password);
            $docentes->password=$hashed;

        }
        $docentes->tipo_rol=$request->tipo_rol;
        $docentes->estado=1;
        $docentes->save();

        return redirect('GestionDocentes')->with('success', 'Docente Editado Exitosamente!!');

    }

    public function eliminar($id){
        $docentes = Usuario::find($id);
        $docentes->estado='0';
        $docentes->save();
        return redirect('GestionDocentes')->with('success', 'Docente Removido Exitosamente!!');
    }

    public function destroy($id){
        $docentes = docente::find($id);
        $docentes->delete();
        return redirect('GestionDocentes')->with('success', 'Docente Removido Exitosamente!!');
    }

    public function cambioestado(Request $request)
    {
        $docentes = Usuario::find($request->id);
        $docentes->estado = $request->estado;
        $docentes->save();

        return response()->json(['message'=>'Estado de docente cambiado exitosamente!!']);
    }

    public static function EstadoDocente($estado){
        return ($estado == 1)? 'Activo' : 'Inactivo';
    }

}
