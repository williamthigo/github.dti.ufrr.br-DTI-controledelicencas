<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Licenca;
use App\Tipo;
use \Illuminate\Support\Facades\Response;

class HomeController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $disponivel = $indisponivel = 0;
        foreach (Licenca::get(['disponivel','utilizada']) as $l) {
            $disponivel += $l->disponivel;
            $indisponivel += $l->utilizada;
        }
        $disp = ['indisp'=>$indisponivel,'disp'=>$disponivel];

        $tiposnome = array();
        $tiposCount = array();
        foreach(Tipo::all() as $key=>$t){
            array_push($tiposnome,$t->nome);
            $licencas = Licenca::whereHas('tipo',function($query) use ($t){
                $query->where('id','=',$t->id);
            })->get(['disponivel','utilizada']);
            $count=0;
            foreach ($licencas as $l) {
                $count += $l->disponivel;
                $count += $l->utilizada;
            }
            array_push($tiposCount,$count);
        }
        $barColors = array();
        for($i=0; $i < sizeof($tiposnome); $i++){
            array_push($barColors,'rgba(32,201,151,0.7)');
        }

        return view('home')
            ->with('disp',$disp)
            ->with('tiposCount',$tiposCount)
            ->with('tipos',$tiposnome)
            ->with('tiposcolors',$barColors);
    }
}
