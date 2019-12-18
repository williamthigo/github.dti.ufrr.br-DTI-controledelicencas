@extends('layouts.app')
@section('content')
@if(@Session::get('msgerro'))
    <div class="alert alert-dismissible alert-danger">
        <button type="button" class="close" data-dismiss="alert">x</button>
        {{Session::get('msgerro')}}
    </div>
@endif
@if(@Session::get('msgsuccess'))
    <div class="alert alert-dismissible alert-success">
        <button type="button" class="close" data-dismiss="alert">&times;</button>
        {{Session::get('msgsuccess')}}
    </div>
@endif

<div class="row">
    <div class="col-lg-4">
        <div class="card card-register mx-auto mb-3">
            <legend class="card-header">Disponibilidade</legend>
            <div class="card-body">
                <canvas id="disponibilidade" width="100%" height="100%" data-disp="{{json_encode($disp)}}"></canvas>
            </div>
        </div>
    </div>
    <div class="col-lg-8">
        <div class="card card-register mx-auto mb-3">
            <legend class="card-header">Distribuição por Tipo</legend>
            <div class="card-body">
                <canvas id="distribuicao" width="100%" height="47%" data-tipos="{{json_encode($tipos)}}" data-tiposcount="{{json_encode($tiposCount)}}" data-colors="{{json_encode($tiposcolors)}}"></canvas>
            </div>
        </div>
    </div>
</div>
@endsection
@section('script')
<script type="text/javascript">
var ctxDisp = document.getElementById("disponibilidade");
var myChart = new Chart(ctxDisp, {
    type: 'doughnut',
    data: {
        labels: ["Licenças indisponíveis","Licenças disponíveis"],
        datasets: [{
            data: [JSON.parse(ctxDisp.dataset['disp']).indisp,JSON.parse(ctxDisp.dataset['disp']).disp],
            backgroundColor: [
                'rgba(231,76,60, 0.7)',
                'rgba(32,201,151,0.7)'
            ],
            borderColor: [
                'rgba(231,76,60, 0.7)',
                'rgba(32,201,151, 0.7)'
            ],
            borderWidth: 1
        }]
    }
});
var ctxbar = document.getElementById("distribuicao");
var barChart = new Chart(ctxbar, {
type: 'bar',
data: {
labels: JSON.parse(ctxbar.dataset['tipos']),
datasets: [{
    label: 'Unidades',
    data: JSON.parse(ctxbar.dataset['tiposcount']),
        backgroundColor: JSON.parse(ctxbar.dataset['colors']),
        borderWidth: 1
    }]
    },
    options: {
        scales: {
            yAxes: [{
                ticks: {
                    beginAtZero:true
                }
            }]
        }
    }
});
</script>
@endsection
