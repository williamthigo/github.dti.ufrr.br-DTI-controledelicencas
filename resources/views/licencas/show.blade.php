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
    <legend class="card-header">Histórico</legend>
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
        </div>
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Usuário</th>
                        <th>Máquina</th>
                        <th>Criado<a href="{{url('/licencas/'.$id.'?limit='.$limit.'&order=created_at&ordertype='.!$ordertype)}}"><span class="fa fa-sort bord-space-left"></span></a></th>
                        <th>Atualizado<a href="{{url('/licencas/'.$id.'?limit='.$limit.'&order=updated_at&ordertype='.!$ordertype)}}"><span class="fa fa-sort bord-space-left"></span></a></th>
                        <th>Deletado<a href="{{url('/licencas/'.$id.'?limit='.$limit.'&order=deleted_at&ordertype='.!$ordertype)}}"><span class="fa fa-sort bord-space-left"></span></a></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($result as $r)
                    <tr>
                        <td>{{$r->user->nome}}</td>
                        <td>{{$r->maquinaTrashed->tombo.' - '.$r->maquinaTrashed->setor->sigla}}</td>
                        <td class="{{$r->created_at==$r->updated_at? 'state-change':''}}">{{$r->created_at->format('d-m-Y / H:i:s')}}</td>
                        <td class="{{$r->deleted_at!=$r->updated_at && $r->updated_at!=$r->created_at? 'state-change':''}}"> {{$r->updated_at->format('d-m-Y / H:i:s')}}</td>
                        <td class="{{$r->deleted_at==$r->updated_at? 'state-change':''}}"> {{is_null($r->deleted_at)?'':$r->deleted_at->format('d-m-Y / H:i:s')}}</td>
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
