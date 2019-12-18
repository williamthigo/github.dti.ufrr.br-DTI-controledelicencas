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
    <legend class="card-header">Ativações</legend>
    <div class="card-body">
        <div class="form-group form-inline">
            <div class="mr-auto form-inline">
                <label style="margin-right:10px">Ativações</label>
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
                        <th>Ativador</th>
                        <th>Licenca</th>
                        <th>Setor</th>
                        <th>Maquina</th>
                        <th class="text-center">Ação</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($result as $r)
                    <tr>
                        <td>{{$r->user->nome}}</td>
                        <td>{{$r->licenca->tipo->nome.' - '.$r->licenca->serial}}</td>
                        <td>{{$r->maquina->setor->nome.' - '.$r->maquina->setor->sigla}}</td>
                        <td>{{$r->maquina->tombo}}</td>
                        <td class="text-center">
                            {{ Form::open(['method' => 'DELETE', 'id'=>'delete'.$r->id,'route' => ['ativacoes.destroy', $r->id]]) }}
                                <a href="javascript:{}" onclick="submit({{$r->id}})" title="Desativar licença nesta máquina"><span class="fa fa-fw fa-times"></span></a>
                            {{ Form::close() }}
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <div class="pages">
        {{$result->appends(['limit'=>$limit,'order'=>$order])->links()}}
    </div>
@endsection
@section('script')
<script type="text/javascript">
    function reload(){
        window.location.assign("/ativacoes?limit="+$('#limit').val());
    }
    function search(){
        window.location.assign("/ativacoes?limit="+$('#limit').val()+"&search="+$('#search').val());
    }
    function submit(id) {
        if (confirm('Tem certeza que deseja retirar essa ativação?')) {
            document.getElementById('delete'+id).submit();
        }
    }
</script>
@endsection
