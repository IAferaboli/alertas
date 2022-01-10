@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Dashboard</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-info">
                <div class="inner">
                    <h3>{{ cantCameras() }}</h3>

                    <p>Cámaras Totales</p>
                </div>
                <div class="icon">
                    <i class="ion ion-ios-videocam-outline"></i>
                </div>
                <a href="{{ route('panel.monitoreo.cameras.index') }}" class="small-box-footer">Más info <i
                        class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box @if (statusCameras('FUERA')==0) bg-success @else bg-danger @endif">
                <div class="inner">
                    <h3>{{ statusCameras('FUERA') }}</h3>

                    <p>Fuera de Servicio</p>
                </div>
                <div class="icon">
                    <i class="ion ion-minus-circled"></i>
                </div>
                <a href="{{ route('panel.monitoreo.cameras.index') }}" class="small-box-footer">Más info <i
                        class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box @if (statusCameras('ACTIVE')==0) bg-success @else bg-danger @endif">
                <div class="inner">
                    <h3>{{ statusCameras('ACTIVE') }}</h3>

                    <p>Cámaras Desactivadas</p>
                </div>
                <div class="icon">
                    <i class="ion ion-minus-circled"></i>
                </div>
                <a href="#" class="small-box-footer">Más info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box @if (getLicenses() <=10) bg-danger @else bg-info @endif">
                <div class="inner">
                    <h3>{{ getLicenses() }}</h3>

                    <p>Licencias Disponibles</p>
                </div>
                <div class="icon">
                    <i class="ion ion-ios-information-outline"></i>
                </div>
            </div>
        </div>
        <!-- ./col -->
    </div>

    <div class="row">
        <!-- ./col -->
        <div class="col-lg-4 col-12">
            <!-- small box -->
            <div class="small-box bg-info">
                <div class="inner">
                    <h3>{{ $serv1 }}</h3>

                    <p>TIEMPO ACTIVO - SERVER 1</p>
                </div>
                <div class="icon">
                    <i class="ion ion-ios-information-outline"></i>
                </div>
            </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-4 col-12">
            <!-- small box -->
            <div class="small-box bg-info">
                <div class="inner">
                    <h3>{{ $serv2 }}</h3>

                    <p>TIEMPO ACTIVO - SERVER 2</p>
                </div>
                <div class="icon">
                    <i class="ion ion-ios-information-outline"></i>
                </div>
            </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-4 col-12">
            <!-- small box -->
            <div class="small-box bg-info">
                <div class="inner">
                    <h3>{{ $serv3 }}</h3>

                    <p>TIEMPO ACTIVO - SERVER 3</p>
                </div>
                <div class="icon">
                    <i class="ion ion-ios-information-outline"></i>
                </div>
            </div>
        </div>
        <!-- ./col -->
    </div>

    <div class="row">
        <div class="col-lg-6 col-12">
            <div class="panel panel-default">
                <div class="panel-heading">Dashboard</div>
                <div class="panel-body">
                    <canvas id="interventions" style="width:100%;max-width:700px"></canvas>
                </div>
            </div>
        </div>
    </div>

@stop

@section('css')
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
@stop

@section('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.min.js"></script>

    <script>
        var _ydata=JSON.parse('{!! json_encode($monthCount) !!}');
        var _ydataLast=JSON.parse('{!! json_encode($monthCountLast) !!}');
        let month= ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre']
        var year = new Date().getFullYear()
        

        if (document.getElementById("interventions")) {
            var myChart = new Chart("interventions", {
                type: "line",
                data: {
                    labels: month,
                    datasets: [{
                        label: year,
                        data: _ydata,
                        borderColor: "red",
                        fill: false,
                    }, {
                        label: year-1,
                        data: _ydataLast,
                        borderColor: "green",
                        fill: false
                    }]
                },
                options: {
                    legend: {
                        display: true
                    }
                }
            });
        }
    </script>
@stop
