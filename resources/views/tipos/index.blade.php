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

@if(@Session::get('msgerror'))
    <div class="alert alert-dismissible alert-danger">
        <button type="button" class="close" data-dismiss="alert">x</button>
        {{Session::get('msgerror')}}
    </div>
@endif
@if(@Session::get('msgsuccess'))
    <div class="alert alert-dismissible alert-success">
        <button type="button" class="close" data-dismiss="alert">&times;</button>
        {{Session::get('msgsuccess')}}
    </div>
@endif

<div class="card card-register mx-auto">
    <legend class="card-header">Tipos</legend>
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
                        <th>Nome<a href="{{url('/tipos?limit='.$limit.'&order=nome&ordertype='.!$ordertype)}}"><span class="fa fa-sort bord-space-left"></span></a></th>
                        <th class="text-center">Disponíveis</th>
                        <th class="text-center">Indisponíveis</th>
                        <th class="text-center">Ação</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($result as $key=>$r)
                    <tr>
                        <td>{{$r->nome}}</td>
                        <td class="text-center">{{$disp[$key]}}</td>
                        <td class="text-center">{{$indisp[$key]}}</td>
                        <td class="text-center">
                            {{ Form::open(['method' => 'DELETE', 'id'=>'delete'.$r->id,'route' => ['tipos.destroy', $r->id]]) }}
                            <a href="/tipos/{{$r->id}}/edit" title="Editar este tipo"><span class="fa fa-fw fa-pencil"></span></a>
                            <a href="javascript:{}" onclick="submit({{$r->id}})" title="Deletar este tipo"><span class="fa fa-fw fa-trash"></span></a>
                            {{ Form::close() }}
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <div class="pages">
        {{$result->appends(['limit'=>$limit,'order'=>$order,'ordertype'=>$ordertype])->links()}}
    </div>
@endsection
@section('script')
<script type="text/javascript">
    function reload(){
        window.location.assign("/tipos?limit="+$('#limit').val());
    }
    function submit(id) {
        if (confirm('Tem certeza que deletar este tipo?')) {
            document.getElementById('delete'+id).submit();
        }
    }
    function search(){
        window.location.assign("/maquinas?limit="+$('#limit').val()+"&search="+$('#search').val());
    }
</script>
@endsection
