<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Styles -->
    <link href="{{asset('/css/app.css')}}" rel="stylesheet" type="text/css">
    <link href="{{asset('/css/custom.css')}}" rel="stylesheet" type="text/css">
    <link href="{{asset('/font-awesome-4.7.0/css/font-awesome.css')}}" rel="stylesheet" type="text/css">

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>
    <!-- Bootstrap core JavaScript-->
    <script src="{{asset('/jquery/jquery.min.js')}}"></script>
    <script src="{{asset('/js/bootstrap.bundle.min.js')}}"></script>
    <!-- Core plugin JavaScript-->
    <script src="{{asset('/jquery/jquery.easing.min.js')}}"></script>
    <!-- Page level plugin JavaScript-->
    <script src="{{asset('/jquery/jquery.dataTables.js')}}"></script>
    <script src="{{asset('/jquery/dataTables.bootstrap4.js')}}"></script>
    <!-- Custom scripts for all pages-->
    <script src="{{asset('/js/sb-admin.min.js')}}"></script>
    <!-- Custom scripts for this page-->
    <script src="{{asset('/js/sb-admin-datatables.min.js')}}"></script>
    <!-- Chart.js -->
    <script src="{{asset('/js/Chart.bundle.js')}}"></script>
    <script src="{{asset('/js/Chart.bundle.min.js')}}"></script>
    <script src="{{asset('/js/Chart.js')}}"></script>
    <script src="{{asset('/js/Chart.min.js')}}"></script>
</head>
<body>
    @if(!Auth::guest())
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="/">Licenças</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarColor01" aria-controls="navbarColor01" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarColor01">
            <ul class="navbar-nav mr-auto">
            </ul>
            <a href="{{ url('/logout') }}"><button type="button" class="btn btn-outline-warning">
                    <strong>Sair</strong></button></a>
        </div>
    </nav>

    <div class="container-fluid">
        <div class="row">
            <nav class="col-sm-3 col-md-2 d-none d-sm-block bg-light sidebar">
                <ul class="navbar-nav navbar-sidenav fixed-left" id="sidemenu">
                    <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Ativações">
                        <a class="nav-link nav-link-collapse collapsed" data-toggle="collapse" href="#ativados" data-parent="#exampleAccordion">
                            <i class="fa fa-fw fa-check"></i>
                            <span class="nav-link-text"><strong>Ativados</strong></span>
                        </a>
                        <ul class="sidenav-second-level collapse" id="ativados">
                            <li>
                                <a href="{{url('/ativacoes')}}">Listar</a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Licenças">
                        <a class="nav-link nav-link-collapse collapsed" data-toggle="collapse" href="#licencas" data-parent="#exampleAccordion">
                            <i class="fa fa-fw fa-key"></i>
                            <span class="nav-link-text"><strong>Licenças</strong></span>
                        </a>
                        <ul class="sidenav-second-level collapse" id="licencas">
                            <li>
                                <a href="{{url('/licencas/create')}}">Cadastrar</a>
                            </li>
                            <li>
                                <a href="{{url('/licencas')}}">Listar</a>
                            </li>
                            <li>
                                <a class="nav-link-collapse collapsed" data-toggle="collapse" href="#collapseMulti2">Tipos</a>
                                <ul class="sidenav-third-level collapse" id="collapseMulti2">
                                <li>
                                    <a href="{{url('/tipos/create')}}">Cadastrar</a>
                                </li>
                                <li>
                                    <a href="{{url('/tipos')}}">Listar</a>
                                </li>
                              </ul>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Maquinas">
                        <a class="nav-link nav-link-collapse collapsed" data-toggle="collapse" href="#maquinas" data-parent="#exampleAccordion">
                            <i class="fa fa-fw fa-desktop"></i>
                            <span class="nav-link-text"><strong>Maquinas</strong></span>
                        </a>
                        <ul class="sidenav-second-level collapse" id="maquinas">
                            <li>
                                <a href="{{url('/maquinas/create')}}">Cadastrar</a>
                            </li>
                            <li>
                                <a href="{{url('/maquinas')}}">Listar</a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Setores">
                        <a class="nav-link nav-link-collapse collapsed" data-toggle="collapse" href="#setores" data-parent="#exampleAccordion">
                            <i class="fa fa-fw fa-building"></i>
                            <span class="nav-link-text"><strong>Setores</strong></span>
                        </a>
                        <ul class="sidenav-second-level collapse" id="setores">
                            <li>
                              <a href="{{url('setores/')}}">Listar</a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </nav>

            <main role="main" class="col-sm-9 ml-sm-auto col-md-10 pt-3">
    @endif
                @yield('content')
    @if(!Auth::guest())
            </main>
    @endif
        </div>
    </div>
    @yield('script')
</body>
</html>
