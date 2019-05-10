<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Funcionario;
use Auth;

class AuthController extends Controller
{
    protected $funcionario;
    
    public function __construct(Funcionario $funcionario)
    {
        $this->funcionario = $funcionario;
        //dd($funcionario);
    }

    public function index()
    {
        // $funcionario = $this->funcionario->first();
        // dd($funcionario);
        return view('login');
    }

    public function login(Request $request)
    {  

        $credentials = ['email'=>$request->email,'password'=>$request->password];
        //dd($credentials);
        if(Auth::attempt($credentials)){
            $usuario_logado = Auth::user();
            $retorno = DB::connection('mysql2')->select("select consulta_role($usuario_logado->id , 'CONSULTA', 'CON_ACE') as retorno");
            //dd($retorno[0]->retorno);
            if($retorno[0]->retorno){
                return redirect()->intended('consulta');
            }else{
                return redirect()->back()->with('msg','Voce não tem acesso ao sistema');
            }
        }else{
            return redirect()->back()->with('msg','Acesso Negado, Email ou senha invalida');
        }
    }
}
