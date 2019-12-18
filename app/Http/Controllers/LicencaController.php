<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Licenca;
use App\Tipo;
use App\Ativado;
use \Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;

class LicencaController extends Controller
{
    public function index(){
        $LIMIT = (isset($_GET['limit'])?$_GET['limit']:10);
        $ORDER = (isset($_GET['order'])?$_GET['order']:'id');
        $ORDERTYPE = (isset($_GET['ordertype'])?(bool) $_GET['ordertype']:'asc');
        $SEARCH = (isset($_GET['search'])?$_GET['search']:'%');
        $breadcrumb = array('Licenças','/licencas','Listar','/licencas');

        $result = Licenca::where('serial','like','%'.$SEARCH.'%')->orderBy((string) $ORDER,(string) (is_bool($ORDERTYPE)? ($ORDERTYPE==true?'asc':'desc'):$ORDERTYPE))->paginate((int) $LIMIT);

        return view('licencas.index')
            ->with('limit',$LIMIT)
            ->with('order',$ORDER)
            ->with('ordertype',$ORDERTYPE)
            ->with('result',$result)
            ->with('search', $SEARCH)
            ->with('breadcrumb',$breadcrumb);
    }

    public function create(){
        $breadcrumb = array('Licenças','/licencas','Cadastrar','/licencas/create');

        $tipos = Tipo::all();

        return view('licencas.create')
            ->with('tipos',$tipos)
            ->with('breadcrumb',$breadcrumb);
    }

    public function edit($id){
            $breadcrumb = array('Licenças','/licencas','Editar','/licencas/create');

            $tipos = Tipo::all();
            $result = Licenca::find($id);

            return view('licencas.edit')
                ->with('id',$id)
                ->with('tipos',$tipos)
                ->with('result',$result)
                ->with('breadcrumb',$breadcrumb);
    }

    public function store(Request $request){
        if(!is_null($request->id)){
            $backup = Licenca::find($request->id);
        }else {
            $arquivo = $request->file('arquivo');
            $path = time().'_'.$request->serial.'.'.$arquivo->extension();
            Storage::put($path, file_get_contents($arquivo->getRealPath()));
        }

        $result = Licenca::updateOrCreate(['id'=>$request->id],[
            'serial'=>$request->serial,
            'arquivo'=>($request->hasFile('arquivo')? $path:$backup->arquivo),
            'tipos_id'=>$request->tipo,
            'disponivel'=> $request->disponivel,
            'utilizada'=>(is_null($request->id)? 0 : $backup->utilizada)
        ]);

        if($result instanceof Licenca){
            if(is_null($request->id)){
                Session::flash('msgsuccess', 'Uma nova licença foi cadastrada.');
            }else{
                Session::flash('msgsuccess', 'Uma licença foi atualizada.');
            }
            return redirect(request()->headers->get('referer'));
        }else{
            Session::flash('msgerror', 'Erro ao cadastrar licença.');
            return redirect(request()->headers->get('referer'));
        }
    }

    public function show($id){
        $LIMIT = (isset($_GET['limit'])?$_GET['limit']:10);
        $ORDER = (isset($_GET['order'])?$_GET['order']:'created_at');
        $ORDERTYPE = (isset($_GET['ordertype'])?(bool) $_GET['ordertype']:'asc');
        $breadcrumb = array('Licenças','/licencas','Listar','/licencas','Histórico','/licencas/'.$id);

        $result = Ativado::withTrashed()->where('licencas_id','=',$id)->orderBy((string) $ORDER,(string) (is_bool($ORDERTYPE)? ($ORDERTYPE==true?'asc':'desc'):$ORDERTYPE))->paginate((int) $LIMIT);
        // dd($result[0]->maquinaTrashed);

        return view('licencas.show')
            ->with('limit',$LIMIT)
            ->with('order',$ORDER)
            ->with('ordertype',$ORDERTYPE)
            ->with('result',$result)
            ->with('breadcrumb',$breadcrumb)
            ->with('id',$id);
    }


    public function getFreeKey($key,$idmaquina){
        $checkingExistence = Ativado::where('maquinas_id','=',$idmaquina)->whereHas('licenca', function ($query) use ($key) {
            $query->where('tipos_id', '=', $key);
        })->first();

        if($checkingExistence instanceof Ativado){
            return "false";
        }else{
            $result = Licenca::where('disponivel','>',0)->whereHas('tipo', function ($query) use ($key) {
                $query->where('id', '=', $key);
            })->get();

            if(sizeof($result)>0){
                return Response::json($result);
            }else{
                return "false";
            }
        }
    }

    public function destroy($id){
        $ativado = Ativado::where('licencas_id','=',$id)->get();
        if(sizeof($ativado)<1){
            $result = Licenca::find($id);
            if($result->delete()){
                Session::flash('msgsuccess', 'Licença deletada com sucesso.');
            }else {
                Session::flash('msgerror', 'Erro ao deletar Licença.');
            }
        }else{
            Session::flash('msgerror', 'Esta licença não pode ser deletada pois está sendo utilizada por uma máquina.');
        }
        return redirect(request()->headers->get('referer'));
    }

    public static function enable($id){
        $result = Licenca::find($id);
        $result->disponivel += 1;
        $result->utilizada -= 1;
        return $result->save();
    }

    public static function getFile($file){
        $path = storage_path('app/').$file;
        if(is_file($path)){
            return response()->download($path);
        }
    }
}
