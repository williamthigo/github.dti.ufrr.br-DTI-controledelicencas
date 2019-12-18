@extends('layouts.app')
@section('content')
<!-- Breadcrumbs-->
<ol class="breadcrumb">
    @for($i=0;$i<sizeof($breadcrumb);$i+=2)
        <li class="breadcrumb-item {{$i==(sizeof($breadcrumb)-2)?'not-active':''}}">
            <a href="{{$breadcrumb[$i+1]}}">{{$breadcrumb[$i]}}</a>
        </li>
    @endfor
    <!-- <li class="breadcrumb-item active">Tables</li> -->
</ol>
<div class="card card-register mx-auto">
    <legend class="card-header">Setores</legend>
    <div class="card-body">
        <div class="form-group form-inline">
            <div class="mr-auto form-inline">
                <label style="margin-right:10px">Mostrar </label>
                <select id="limit" name="limit" class="custom-select" onchange="reload()">
                  <option value="10" {{$limit==10?'selected':''}}>10</option>
                  <option value="20" {{$limit==20?'selected':''}}>20</option>
                  <option value="50" {{$limit==50?'selected':''}}>50</option>
                  <option value="100" {{$limit==100?'selected':''}}>100</option>
                </select>
                <label style="margin-left:10px">resultados</label>
            </div>
            <div class="form-inline">
                <input class="form-control mr-sm-2" id="search" name="search" type="text" placeholder="Buscar">
                <button class="btn btn-secondary my-2 my-sm-0" type="button" onclick="search()">Buscar</button>
            </div>
        </div>
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Nome<a href="{{url('/setores?limit='.$limit.'&order=nome&ordertype='.!$ordertype.'&search='.$search)}}"><span class="fa fa-sort bord-space-left"></th>
                        <th>Sigla<a href="{{url('/setores?limit='.$limit.'&order=sigla&ordertype='.!$ordertype.'&search='.$search)}}"><span class="fa fa-sort bord-space-left"></th>
                        <th class="text-center">Máquinas</th>
                        <th class="text-center">Ação</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($result as $r)
                    <tr>
                        <td>{{$r->nome}}</td>
                        <td>{{$r->sigla}}</td>
                        <td class="text-center">{{sizeof($r->maquina)}}</td>
                        <td class="text-center">
                            <a href="{{url('/maquinas/create?idsetor='.$r->id)}}" title="Adicionar Máquina"><span class="fa fa-fw fa-plus"></span></a>
                            <a href="{{url('/maquinas?idsetor='.$r->id)}}" title="Visualizar máquinas deste setor"><span class="fa fa-fw fa-search"></span></a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <div class="pages">
        {{$result->appends(['limit'=>$limit,'order'=>$order,'ordertype'=>$ordertype,'search'=>$search])->links()}}
    </div>
</div>
@endsection
@section('script')
<script type="text/javascript">
    function reload(){
        window.location.assign("/setores?limit="+$('#limit').val());
    }
    function search(){
        console.log($('#search').val());
        window.location.assign("/setores?limit="+$('#limit').val()+"&search="+$('#search').val());
    }
</script>
@endsection
