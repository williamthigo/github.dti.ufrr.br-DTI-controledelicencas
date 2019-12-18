<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Maquina;
use Illuminate\Support\Facades\Session;
use App\Setor;
use App\Ativado;
use App\Licenca;

class MaquinaController extends Controller
{

    public function index(){
        $LIMIT = (isset($_GET['limit'])?$_GET['limit']:10);
        $ORDER = (isset($_GET['order'])?$_GET['order']:'id');
        $ORDERTYPE = (isset($_GET['ordertype'])?(bool) $_GET['ordertype']:'asc');
        $SEARCH = (isset($_GET['search'])?$_GET['search']:'%');
        $SETOR = (isset($_GET['idsetor'])?$_GET['idsetor']:'%');
        $breadcrumb = array('Maquinas','/maquinas','Listar','/maquinas');

        $result = Maquina::where('tombo','like','%'.$SEARCH.'%')->whereHas('setor', function ($query) use ($SETOR) {
            $query->where('id', 'like', (string) $SETOR);
        })->orderBy((string) $ORDER,(string) (is_bool($ORDERTYPE)? ($ORDERTYPE==true?'asc':'desc'):$ORDERTYPE))->paginate((int) $LIMIT);

        return view('maquinas.index')
            ->with('limit',$LIMIT)
            ->with('order',$ORDER)
            ->with('ordertype',$ORDERTYPE)
            ->with('result',$result)
            ->with('setor',$SETOR)
            ->with('search', $SEARCH)
            ->with('breadcrumb',$breadcrumb);
    }

    public function create(){
        $breadcrumb = array('Maquinas','/maquinas','Cadastrar','/maquinas/create');
        $setores = Setor::all();
        if(isset($_GET['idsetor'])){
            $setor = Setor::find($_GET['idsetor']);
        }else{
            $setor = null;
        }
        return view('maquinas.create')
            ->with('breadcrumb',$breadcrumb)
            ->with('id',null)
            ->with('setores',$setores)
            ->with('setor',$setor);
    }

    public function edit($id){
        $breadcrumb = array('Maquinas','/maquinas','Editar','/maquinas/create');
        $setores = Setor::all();

        $maquina = Maquina::find($id);

        return view('maquinas.edit')
            ->with('breadcrumb',$breadcrumb)
            ->with('id',$maquina->id)
            ->with('setores',$setores)
            ->with('maquina',$maquina);
    }

    public function store(Request $request){
        $data = explode(' - ',$request->setor);
        $idsetor = (int) $data[0];
        $result = Maquina::updateOrCreate(['id'=>$request->id],[
            'tombo'=>$request->tombo,
            'setores_id'=> $idsetor
        ]);
        if($result instanceof Maquina){
            if(is_null($request->id)){
                Session::flash('msgsuccess', 'Uma nova maquina foi cadastrada.');
            }else{
                Session::flash('msgsuccess', 'Uma maquina foi atualizada.');
            }
            return redirect(request()->headers->get('referer'));
        }else{
            Session::flash('msgerror', 'Erro ao cadastrar maquina.');
            return redirect(request()->headers->get('referer'));
        }
    }

    public function destroy($id){
        $result = Maquina::find($id);
        foreach($result->ativado as $a){
            LicencaController::enable($a->licenca->id);
            $a->delete();
        }
        if($result->delete()){
            Session::flash('msgsuccess', 'Máquina deletada com sucesso.');
        }else {
            Session::flash('msgerror', 'Erro ao deletar máquina.');
        }
        return redirect(request()->headers->get('referer'));
    }

}
