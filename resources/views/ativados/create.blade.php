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
    <div class="card card-register mx-auto">
        <legend class="card-header">Cadastrar Ativação</legend>
        <div class="card-body">
            {{Form::open(array('action' => 'AtivadoController@store', 'method' => 'post', 'class' => 'form-horizontal'))}}
            {{Form::token()}}
                <div class="form-group row">
                    <div class="col-sm-12 col-md-12 col-lg-12">
                        <label>Setor</label>
                        <input class="form-control" id="setor" name="setor" type="text" value="{{$maquina->setor->nome.' - '.$maquina->setor->sigla}}" required>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-sm-12 col-md-12 col-lg-12">
                        <label>Tombo</label>
                        <input class="form-control" id="tombo" name="tombo" type="text" value="{{$maquina->tombo}}" required>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-sm-12 col-md-12 col-lg-12">
                        <label>Tipo</label>
                        <input class="form-control" name="tipo" id="tipo" list="tipos" required onchange="search()">
                        <datalist id="tipos" name="tipos">
                            @foreach($tipos as $t)
                                <option value="{{$t->id.' - '.$t->nome}}"></option>
                            @endforeach
                        </datalist>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-sm-12 col-md-12 col-lg-12">
                        <label>Licença</label>
                        <select class="form-control" id="licenca" name="licenca">
                            <option value="">-- Selecione uma licença --</option>
                        </select>
                        <!-- <input class="form-control" id="licenca" name="licenca" list="licencas" required>
                        <datalist id="licencas" name="licencas">

                        </datalist> -->
                    </div>
                </div>
                <input type="hidden" id="idmaquia" name="idmaquina" value="{{$maquina->id}}">
                <input type="hidden" id="id" name="id" value="{{$id}}">
                <button class="btn btn-primary btn-block">Cadastrar</button>
            {{Form::close()}}
      </div>
    </div>
  </div>
@endsection
@section('script')
<script type="text/javascript">
    function search(){
        $('#licenca').val('');
        var valor = $('#tipo').val().split(" - ");
        $.get('/licencas/busca/' + valor[0]+'/'+{{$maquina->id}}, function (result) {
            if(result!='false'){
                $("#licenca").empty();
                $.each(result, function (key, value) {
                    $('select[name=licenca]').append('<option value="' + value.id + '" >'+value.serial+'</option>');
                });
            }else{
                $('select[name=licenca]').append('<option value="" >Não existe licença disponível desse tipo para esta máquina.</option>');
            }
        });
    }
</script>
@endsection
