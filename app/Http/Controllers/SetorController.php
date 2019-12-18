<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Setor;
use \Illuminate\Support\Facades\Response;

class SetorController extends Controller
{


    public function index(){
        $LIMIT = (isset($_GET['limit'])?$_GET['limit']:10);
        $ORDER = (isset($_GET['order'])?$_GET['order']:'id');
        $ORDERTYPE = (isset($_GET['ordertype'])?(bool) $_GET['ordertype']:'asc');
        $SEARCH = (isset($_GET['search'])?$_GET['search']:'%');
        $breadcrumb = array('Setores','/setores','Listar','/setores');

        $result = Setor::where('nome','like','%'.$SEARCH.'%')->orWhere('sigla','like','%'.$SEARCH.'%')->orderBy((string) $ORDER,(string) (is_bool($ORDERTYPE)? ($ORDERTYPE==true?'asc':'desc'):$ORDERTYPE))->paginate((int) $LIMIT);

        return view('setores.index')
            ->with('limit',$LIMIT)
            ->with('order',$ORDER)
            ->with('ordertype',$ORDERTYPE)
            ->with('result',$result)
            ->with('search', $SEARCH)
            ->with('breadcrumb',$breadcrumb);
    }

    public function busca($key){
        $result = Setor::where('nome','like','%'.$key.'%')->orWhere('sigla','like','%'.$key.'%')->get();
        return $result;
    }
}
