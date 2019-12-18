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
    <div class="card card-register mx-auto">
        <legend class="card-header">Cadastro de Nova Licença</legend>
        <div class="card-body">
            {{Form::open(array('action' => 'LicencaController@store', 'method' => 'post', 'class' => 'form-horizontal', 'enctype'=>'multipart/form-data'))}}
            {{Form::token()}}
                <div class="form-group row">
                    <div class="col-sm-8 col-md-8 col-lg-8">
                        <label for="exampleInputName">Serial</label>
                        <input class="form-control" id="serial" name="serial" type="text" placeholder="xxxx-xxxx-xxxx-xxxx-xxxx" value="{{old('serial')}}" required>
                    </div>
                    <div class="col-sm-4 col-md-4 col-lg-4">
                        <label for="exampleInputName">Quantidade Disponível</label>
                        <input class="form-control" id="disponivel" name="disponivel" type="number" value="{{old('disponivel')}}" min="0" required>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-sm-12 col-md-12 col-lg-12">
                        <label for="exampleInputLastName">Arquivo</label>
                        <input class="form-control" id="arqivo" name="arquivo" type="file" required>
                    </div>
                </div>
                <div class="form-group">
                    <div class="form-row">
                        <div class="col-sm-9 col-md-9 col-lg-9">
                            <label>Tipo</label>
                            <select class="form-control" name="tipo" id="tipo" required>
                                <option value="">-- Selecione o tipo de Software --</option>
                                @foreach($tipos  as $t)
                                    <option value="{{$t->id}}">{{$t->nome}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-sm-3 col-md-3 col-lg-3">
                            <label><br></label>
                            <a class="btn btn-info btn-block" href="#" onclick="alternar()">Adicionar Novo Tipo</a>
                        </div>
                    </div>
                </div>
                <input id="id" name="id" type="hidden" value="{{null}}">
                <button class="btn btn-primary btn-block">Cadastrar</button>
            {{Form::close()}}
      </div>
    </div>
  </div>
@endsection
@section('script')
<script type="text/javascript">
    window.onload = function(){
        $('#formTipo').hide();
    }
    function alternar(){
        if($('#formTipo').is(":visible")){
            $('#formTipo').hide();
        }else{
            $('#formTipo').show();
        }
    }
</script>
@endsection
