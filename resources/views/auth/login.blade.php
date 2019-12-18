@extends('layouts.app')

@section('content')
<div class="container">
    <form class="form-signin" method="post" action="/login/logar">
        {{ csrf_field() }}
        <h2 class="form-signin-heading">LOGIN</h2>

        <label for="user" class="sr-only">Usuário</label>
        <input type="text" id="user" name="user" class="form-control" placeholder="Usuário" value="{{old('user')}}" required autofocus>

        <label for="password" class="sr-only">Senha</label>
        <input type="password" id="password" name="password" class="form-control" placeholder="Senha" required>
        
        <button class="btn btn-lg btn-primary btn-block" type="submit">Entrar</button>
    </form>

</div>
@endsection
