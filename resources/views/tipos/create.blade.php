@extends('layouts.app')
@section('content')
<!-- Breadcrumbs-->
<ol class="breadcrumb">
    @for($i=0;$i<sizeof($breadcrumb);$i+=2)
        <li class="breadcrumb-item {{$i==(sizeof($breadcrumb)-2)?'not-active':''}}">
            <a href="{{$breadcrumb[$i+1]}}">{{$breadcrumb[$i]}}</a>
        </li>
    @endfor
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

<div class="container">
    <div class="card card-register mx-auto" id="formTipo" name="formTipo">
        <legend class="card-header">Cadastro de Novo Tipo</legend>
        <div class="card-body">
            {{Form::open(array('action' => 'TipoController@store', 'method' => 'post', 'class' => 'form-horizontal'))}}
            {{Form::token()}}
                <div class="form-group row">
                    <div class="col-sm-12 col-md-12 col-lg-12">
                        <label>Tipo</label>
                        <input class="form-control" id="nometipo" name="nometipo" type="text" placeholder="Nome do Software" value="{{old('nometipo')}}" required>
                    </div>
                </div>
                <input type="hidden" id="idtipo" name="idtipo" value="{{null}}">
                <button class="btn btn-primary btn-block">Cadastrar</button>
            {{Form::close()}}
      </div>
    </div>
  </div>
@endsection
