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
        <legend class="card-header">Cadastro de Nova Maquina</legend>
        <div class="card-body">
            {{Form::open(array('action' => 'MaquinaController@store', 'method' => 'post', 'class' => 'form-horizontal'))}}
            {{Form::token()}}
                <div class="form-group row">
                    <div class="col-sm-12 col-md-12 col-lg-12">
                        <label>Tombo</label>
                        <input class="form-control" id="tombo" name="tombo" type="text" placeholder="Tombo da Máquina" value="{{old('tombo')}}" required>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-sm-12 col-md-12 col-lg-12">
                        <label>Setor</label>
                        <input class="form-control" name="setor" id="setor" placeholder="Utilize o nome ou a sigla do setor"  list="guess" required value="{{is_null ($setor)?'':$setor->id.' >> '.$setor->nome.' - '.$setor->sigla}}">
                        <datalist id="guess" name="guess">
                            @foreach($setores as $s)
                                <option value="{{$s->id.' - '.$s->nome.' - '.$s->sigla}}"></option>
                            @endforeach
                        </datalist>
                    </div>
                </div>
                <input id="id" name="id" value="{{$id}}" type="hidden">
                <button class="btn btn-primary btn-block">Cadastrar</button>
            {{Form::close()}}
      </div>
    </div>
  </div>
@endsection
@section('script')
<script type="text/javascript">
    // $('#setor').on('keyup',function(){
    //     $('#guess').empty();
    //     $.get('/setores/busca/' + $('#setor').val(), function (result) {
    //         $.each(result, function (key, value) {
    //             var val = value.idsetores+"@#@"+value.nome+" - "+value.sigla;
    //             $('#guess').append('<option value="'+ val + '">' + value.nome+" - "+value.sigla + '</option>');
    //         });
    //     });
    // });
</script>
@endsection
