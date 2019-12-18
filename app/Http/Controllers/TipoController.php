<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Tipo;
use Illuminate\Support\Facades\Session;
use App\Licenca;

class TipoController extends Controller
{
    public function index(){
        $LIMIT = (isset($_GET['limit'])?$_GET['limit']:10);
        $ORDER = (isset($_GET['order'])?$_GET['order']:'id');
        $ORDERTYPE = (isset($_GET['ordertype'])?(bool) $_GET['ordertype']:'asc');
        $SEARCH = (isset($_GET['search'])?$_GET['search']:'%');
        $breadcrumb = array('Tipos','/tipos','Listar','/tipos');

        $result = Tipo::where('nome','like','%'.$SEARCH.'%')->orderBy((string) $ORDER,(string) (is_bool($ORDERTYPE)? ($ORDERTYPE==true?'asc':'desc'):$ORDERTYPE))->paginate((int) $LIMIT);

        $dispCount = array();
        $indispCount = array();
        foreach($result as $t){
            $licencas = Licenca::whereHas('tipo',function($query) use ($t){
                $query->where('id','=',$t->id);
            })->get(['disponivel', 'utilizada']);
            $countDisp = $countUti = 0;
            foreach ($licencas as $l) {
                $countDisp += $l->disponivel;
                $countUti += $l->utilizada;
            }
            array_push($dispCount,$countDisp);
            array_push($indispCount,$countUti);
        }
        
        return view('tipos.index')
            ->with('limit',$LIMIT)
            ->with('order',$ORDER)
            ->with('ordertype',$ORDERTYPE)
            ->with('result',$result)
            ->with('breadcrumb',$breadcrumb)
            ->with('disp',$dispCount)
            ->with('indisp',$indispCount);
    }

    public function create(){
        $breadcrumb = array('Tipos','/tipos','Cadastrar','/tipos/create');

        return view('tipos.create')
            ->with('breadcrumb',$breadcrumb);
    }

    public function edit($id){
        $breadcrumb = array('Tipos','/tipos','Editar','/tipos');

        $result = Tipo::find($id);

        return view('tipos.edit')
            ->with('breadcrumb',$breadcrumb)
            ->with('result',$result);
    }

    public function store(Request $request){
        $tipo = Tipo::updateOrCreate(['id'=>$request->idtipo],[
            'nome'=>$request->nometipo
        ]);
        if($tipo instanceof Tipo){
            Session::flash('msgsuccess', 'Uma novo tipo foi cadastrado.');
            return redirect(request()->headers->get('referer'));
        }else{
            Session::flash('msgerror', 'Uma nova licença foi cadastrada.');
            return redirect(request()->headers->get('referer'));
        }
    }

    public function destroy($id){
        $count = Licenca::where('tipos_id','=',$id)->count();
        if($count>0){
            Session::flash('msgerror', 'Este tipo não pode ser apagado, pois já existem '.$count.' licenças com este tipo atribuido.');
        }else{
            $result = Tipo::find($id);
            if($result->delete()){
                Session::flash('msgsuccess', 'Tipo de software deletado com sucesso.');
            }else {
                Session::flash('msgerror', 'Erro ao deletar tipo de software.');
            }
        }
        return redirect(request()->headers->get('referer'));
    }
}
