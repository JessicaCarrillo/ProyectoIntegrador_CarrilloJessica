<?php

namespace App\Http\Controllers\Auth;

use App\Docente;
use App\Http\Controllers\GestionBiometrico\GestionBiometricoController;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use League\Flysystem\Exception;
use Route;
use App\User as usuario;


class DocenteLoginController extends Controller

{
  //  use AuthenticatesUsers;


   // protected $guarded = 'docente';
    protected $redirectTo = '/docente';

    public function __construct()
    {
        $this->middleware('guest:docente')->except('logout');
    }

    public function showLoginForm(){
        try {

        } catch (Exception $e) {
            echo 'Message: ' . $e->getMessage();
        }
        //return view('DocentesAutenticacion.login',compact('id_biometrico','contraseña'));
        return view('DocentesAutenticacion.login');
    }
    public function login(Request $request){


        $this->validate( $request, [
            'id_biometrico' => 'required',
            // 'password' => 'required|min:6',

        ]);
        //$credentials = $request->only('email', 'password');
        //$user = usuario::where('id_biometrico', $request->id_biometrico)->first();
        $usuario = usuario::where('id', $request->id_biometrico)->first();
        if (empty($usuario)) {
            return back()->withErrors(['id_biometrico'=>'Estas credenciales no concuerdan'])->withInput(request(['id_biometrico']));
        }elseif (Auth::guard('docente')->loginUsingId($usuario->id) && Auth::guard('docente')->user()->roles_usuarios[0]->rol == 'Docente' ){

           // dd($user->tipo_rol);
            return redirect()->intended(route('docente.dashboard'));
        }else{
            return redirect()->intended('/GestionProyectorAdministrador');

        }

     /*  if(Auth::guard('docente')->attempt(['id_biometrico'=>$request->id_biometrico],$request->remember)){
      // if(Auth::guard('docente')->attempt(['id_biometrico'=>$request->id_biometrico,'password'=>$request->password],$request->remember)){
       //if(Auth::guard('docente')->attempt($credentials)){
          // dd(auth()->guard('docente')->user());

            return redirect()->intended(route('docente.dashboard'));
       }*/

         //return $this->loginFailed();
    }

    public function logout()
    {
        Auth::guard('docente')->logout();
        return redirect()->route('docente.login');
    }

    private function loginFailed()
    {
        return redirect()->back()->withInput()->with('error','Login failed, please try again!');
    }

    public function redirectTo()
    {
        //dd(Auth::guard('docente')->user()->roles_usuarios[0]->rol);

        if(Auth::guard('docente')->user()->roles_usuarios[0]->rol == 'Administrador')
        {
            return '/home';
        } else {
            return '/GestionCronograma/';
        }
    }


}
