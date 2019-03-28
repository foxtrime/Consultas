<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Consulta;

class ConsultaController extends Controller
{
    public function index()
    {
        $unidades = DB::table('view_paciente_consultas')->select('unidade_saude')->distinct()->get();     
        //dd($consultas);
        return view('welcome', compact('especializacoes','unidades'));
    }

    public function especializacao($unidade){
        $especializacoes = DB::table('view_paciente_consultas')
            ->select('ocupacao')
                ->where('unidade_saude','=',$unidade)
                    ->distinct()
                        ->get();

        return response($especializacoes);
    }
    
    public function tipoConsulta($especializacao){
        $tipo=DB::table('view_paciente_consultas')
            ->select('tipo_consulta')
                ->where('ocupacao','=',$especializacao)
                    ->distinct()
                        ->get();

        return response($tipo);
    }

    public function queryFull($unidade,$especializacao,$datai,$dataf,$tipo_consulta)
    {
       
        //$qtd_ocupa = DB::table('view_paciente_consultas')->select('ocupacao')->where('status_consulta','=','EM ABERTO')->count();
        $teste1 = DB::table('view_paciente_consultas')
            ->select('ocupacao','unidade_saude')
                ->where('unidade_saude', '=', $unidade)
                    ->where('ocupacao', '=', $especializacao)
                        ->where('tipo_consulta', '=', $tipo_consulta)
                            ->where('status_consulta','=','EFETIVADA')
                                ->whereBetween('data_consulta', [$datai, $dataf])
                                    ->count();
        
        $teste2 = DB::table('view_paciente_consultas')
            ->select('ocupacao','unidade_saude')
                ->where('unidade_saude', '=', $unidade)
                    ->where('ocupacao', '=', $especializacao)
                        ->where('tipo_consulta', '=', $tipo_consulta)
                            ->where('status_consulta','=','EM ABERTO')
                                ->whereBetween('data_consulta', [$datai, $dataf])
                                    ->count();

        //dd($teste1);

        $a = [$teste1,$teste2];
        
        //dd($a);

        //$json = json_encode($a);
        
        return response()->json($a);
    }


    public function querySemiFull($unidade,$especializacao,$datai,$dataf)
    {
       
        //$qtd_ocupa = DB::table('view_paciente_consultas')->select('ocupacao')->where('status_consulta','=','EM ABERTO')->count();
        $teste1 = DB::table('view_paciente_consultas')
            ->select('ocupacao','unidade_saude')
                ->where('unidade_saude', '=', $unidade)
                    ->where('ocupacao', '=', $especializacao)
                            ->where('status_consulta','=','EFETIVADA')
                                ->whereBetween('data_consulta', [$datai, $dataf])
                                    ->count();
        
        $teste2 = DB::table('view_paciente_consultas')
            ->select('ocupacao','unidade_saude')
                ->where('unidade_saude', '=', $unidade)
                    ->where('ocupacao', '=', $especializacao)
                            ->where('status_consulta','=','EM ABERTO')
                                ->whereBetween('data_consulta', [$datai, $dataf])
                                    ->count();

        //dd($teste1);

        $a = [$teste1,$teste2];
        
        //dd($a);

        //$json = json_encode($a);
        
        return response()->json($a);
    }    

    public function querySimple($unidade,$datai,$dataf)
    {
        //$qtd_ocupa = DB::table('view_paciente_consultas')->select('ocupacao')->where('status_consulta','=','EM ABERTO')->count();
        $teste1 = DB::table('view_paciente_consultas')
            ->select('ocupacao','unidade_saude')
                ->where('unidade_saude', '=', $unidade)
                            ->where('status_consulta','=','EFETIVADA')
                                ->whereBetween('data_consulta', [$datai, $dataf])
                                    ->count();
        
        $teste2 = DB::table('view_paciente_consultas')
            ->select('ocupacao','unidade_saude')
                ->where('unidade_saude', '=', $unidade)
                            ->where('status_consulta','=','EM ABERTO')
                                ->whereBetween('data_consulta', [$datai, $dataf])
                                    ->count();

        //dd($teste1);

        $a = [$teste1,$teste2];
        
        //dd($a);

        //$json = json_encode($a);
        
        return response()->json($a);
    }

}

