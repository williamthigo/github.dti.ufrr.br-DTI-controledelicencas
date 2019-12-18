<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Maquina;
use App\Licenca;
use App\Tipo;
use Illuminate\Support\Facades\Session;
use App\Ativado;
use Illuminate\Support\Facades\Auth;

class AtivadoController extends Controller
{

    public function index(){
        $LIMIT = (isset($_GET['limit'])?$_GET['limit']:10);
        $ORDER = (isset($_GET['order'])?$_GET['order']:'id');
        $SEARCH = (isset($_GET['search'])?$_GET['search']:'%');
        $breadcrumb = array('Ativações','/ativacoes','Listar','/ativacoes');

        // $result = Ativado::orderBy((string) $ORDER)->paginate((int) $LIMIT);
        $result = Ativado::whereHas('maquina', function ($query) use ($SEARCH){
            $query->where('tombo','like', '%'.$SEARCH.'%');
        })->orderBy((string) $ORDER)->paginate((int) $LIMIT);

        return view('ativados.index')
            ->with('limit',$LIMIT)
            ->with('order',$ORDER)
            ->with('result',$result)
            ->with('breadcrumb',$breadcrumb);
    }

    public function create(){
        $LIMIT = (isset($_GET['limit'])?$_GET['limit']:10);
        $ORDER = (isset($_GET['order'])?$_GET['order']:'id');
        $SEARCH = (isset($_GET['search'])?$_GET['search']:'%');
        $MAQUINA = (isset($_GET['idmaquina'])?$_GET['idmaquina']:'%');
        $breadcrumb = array('Ativações','/ativacoes','Cadastrar','/ativacoes/create');

        $maquina = Maquina::find($MAQUINA);
        $tipos = Tipo::all();

        return view('ativados.create')
            ->with('breadcrumb',$breadcrumb)
            ->with('maquina',$maquina)
            ->with('tipos',$tipos)
            ->with('id',null);
    }

    public function store(Request $request){
        if(is_null($request->id)){
            $checking = Ativado::where('maquinas_id','=',$request->idmaquia)
            ->where('licencas_id','=',$request->licenca)->get();
            if($checking instanceof Ativado){
                Session::flash('msgerror', 'Esta licença já está ativada nesta máquina.');
                return redirect(request()->headers->get('referer'));
            }
        }

        $result = Ativado::updateOrCreate(['id'=>$request->id],[
            'users_id'=>Auth::id(),
            'licencas_id'=>$request->licenca,
            'maquinas_id'=>$request->idmaquina,
            'ativados_id'=>null
        ]);

        if($result instanceof Ativado){
            $licenca = Licenca::find($request->licenca);
            $licenca->disponivel -= 1;
            $licenca->utilizada += 1;
            $licenca->save();

            Session::flash('msgsuccess', 'Uma nova ativação foi realizada.');
            return redirect('/maquinas');
        }else{
            Session::flash('msgerror', 'Erro ao realizar ativação.');
            return redirect(request()->headers->get('referer'));
        }
    }

    public function destroy($id){
        $result = Ativado::find($id);
        if($result->delete()){
            // pode ser atulizado pelo metodo LicencaController::enable
            $licenca = Licenca::find($result->licencas_id);
            $licenca->disponivel += 1;
            $licenca->utilizada -= 1;
            $licenca->save();
            Session::flash('msgsuccess', 'Ativação desativada com sucesso.');
        }else{
            Session::flash('msgerror', 'Erro ao desativar ativação.');
        }
        return redirect(request()->headers->get('referer'));
    }

}
