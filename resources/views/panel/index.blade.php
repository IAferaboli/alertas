@extends('adminlte::page')

@section('title', 'Municipio VC')

@section('content_header')
    <h1>Dashboard</h1>
@stop

@section('content')

    @can('panel.monitoreo.dashboard')
    
        {{-- Monitoreo --}}
        <div class="row">
            <div class="col-lg-4 col-6">
                <!-- small box -->
                <div class="small-box bg-info">
                    <div class="inner">
                        <h3>{{ $cantCamaras }}</h3>

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
            <div class="col-lg-4 col-12">
                <!-- small box -->
                <div class="small-box @if ($fueraDeServicio == 0) bg-success @else bg-danger @endif">
                    <div class="inner">
                        <h3>{{ $fueraDeServicio }}</h3>

                        <p>Fuera de Servicio</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-minus-circled"></i>
                    </div>
                    @if ($fueraDeServicio != 0)
                        <a href="{{ route('panel.monitoreo.cameras.index') }}" class="small-box-footer">Más info <i
                                class="fas fa-arrow-circle-right"></i></a>
                    @endif

                </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-4 col-12">
                <!-- small box -->
                <div class="small-box @if ($desactivadas == 0) bg-success @else bg-danger @endif">
                    <div class="inner">
                        <h3>{{ $desactivadas }}</h3>

                        <p>Cámaras Desactivadas</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-minus-circled"></i>
                    </div>
                    @if ($desactivadas != 0)
                        <a href="{{ route('panel.monitoreo.cameras.index') }}" class="small-box-footer">Más info <i
                                class="fas fa-arrow-circle-right"></i></a>
                    @endif
                </div>
            </div>
            <!-- ./col -->

            <!-- ./col -->
        </div>

        <div class="row">
            <div class="col col-12 col-md-4">
                <!-- small box -->
                <div class="small-box @if ($sinGrabar != 0) bg-warning @else bg-success @endif">
                    <div class="inner">
                        <h3>{{ $sinGrabar }}</h3>

                        <p>Cámaras sin grabar</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-exclamation-circle"></i>
                    </div>
                    @if ($sinGrabar != 0)
                        <a href="{{ route('panel.monitoreo.cameras.index') }}" class="small-box-footer">Más info <i
                                class="fas fa-arrow-circle-right"></i></a>
                    @endif


                </div>
            </div>
            <div class="col col-12 col-md-4">
                <!-- small box -->
                <div class="small-box @if ($mantenimiento != 0) bg-warning @else bg-success @endif">
                    <div class="inner">
                        <h3>{{ $mantenimiento }}</h3>

                        <p>Cámaras en mantenimiento</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-wrench"></i>
                    </div>
                    @if ($mantenimiento != 0)
                        <a href="{{ route('panel.monitoreo.cameras.index') }}" class="small-box-footer">Más info <i
                                class="fas fa-arrow-circle-right"></i></a>
                    @endif


                </div>
            </div>
            <div class="col-lg-4 col-12">
                <!-- small box -->
                <div class="small-box @if (getLicenses() <= 5) bg-danger @else bg-info @endif">
                    <div class="inner">
                        <h3>{{ getLicenses() }}</h3>

                        <p>Licencias Disponibles</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-ios-information-outline"></i>
                    </div>

                </div>
            </div>
        </div>

        <div class="row">
            <!-- ./col -->
            <div class="col-lg-4 col-12">
                <!-- small box -->
                <div class="small-box bg-info">
                    <div class="inner">
                        <h3>{{ timeServer(1) }}</h3>

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
                        <h3>{{ timeServer(2) }}</h3>

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
                        <h3>{{ timeServer(3) }}</h3>

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
                <div class="card card-default">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="fas fa-chart-line"></i>
                            Intervenciones anuales
                        </h3>
                    </div>

                    <div class="card-body">
                        <canvas id="interventions" style="width:100%;max-width:700px"></canvas>
                    </div>

                </div>

            </div>


            <div class="col-lg-6 col-12">
                <div class="card card-default">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="fas fa-temperature-low"></i>
                            Temperatura Servidores
                        </h3>
                    </div>

                    <div class="card-body">
                        <div id="canvas-holder" style="width:100%">
                            <canvas id="temperaturaServer"></canvas>
                        </div>
                    </div>

                </div>

            </div>



        </div>

        <div class="row">
            <div class="col-lg-6 col-12">
                <div class="card card-default">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="fas fa-chart-bar"></i>
                            Fallas acumuladas por día
                        </h3>
                    </div>

                    <div class="card-body">
                        <canvas id="fallasPorDia" style="width:100%;max-width:700px"></canvas>
                    </div>

                </div>

            </div>


            <div class="col-lg-6 col-12">
                @isset($weather)
                    <div class="card card-widget widget-user">
                        <!-- Add the bg color to the header using any of the bg-* classes -->
                        <div class="widget-user-header bg-info">
                            <h3 class="widget-user-username">Villa Constitución</h3>
                            <h5 class="widget-user-desc">{{ $weather['clima'] }}</h5>
                        </div>
                        <div class="widget-user-image">
                            <img class="img-circle elevation-2"
                                src="https://openweathermap.org/img/wn/{{ $weather['icono'] }}@2x.png" alt="User Avatar">
                        </div>
                        <div class="card-footer">
                            <div class="row">
                                <div class="col-sm-4 border-right">
                                    <div class="description-block">
                                        <h5 class="description-header">{{ $weather['main']['temp'] - 273.1 }}ºC</h5>
                                        <span class="description-text">Temperatura</span>
                                    </div>
                                    <!-- /.description-block -->
                                </div>
                                <!-- /.col -->
                                <div class="col-sm-4 border-right">
                                    <div class="description-block">
                                        <h5 class="description-header">{{ $weather['main']['humidity'] }}%</h5>
                                        <span class="description-text">Humedad</span>
                                    </div>
                                    <!-- /.description-block -->
                                </div>
                                <!-- /.col -->
                                <div class="col-sm-4">
                                    <div class="description-block">
                                        <h5 class="description-header">{{ $weather['main']['temp_min'] - 273.1 }}ºC -
                                            {{ $weather['main']['temp_max'] - 273.1 }}ºC</h5>
                                        <span class="description-text">Mín. - Máx.</span>
                                    </div>
                                    <!-- /.description-block -->
                                </div>
                                <!-- /.col -->
                            </div>
                            <!-- /.row -->
                        </div>
                    </div>
                @endisset

            </div>
        </div>
        {{-- Fin Monitoreo --}}
    @endcan

    @can('panel.agua.dashboard') 
    {{-- Agua --}}
    <div class="row">
        <div class="col col-12 col-md-6">
            <div class="card card-default">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-water"></i>
                        Presión de Agua - Sensor Municipio (pm01sr01)
                    </h3>
                </div>
                <div class="card-body">
                    <div id="canvas-holder-2" style="width:100%">
                        <canvas id="pm01sr01"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- Fin Agua --}}
    @endcan



@stop

@section('css')
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
@stop

@section('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.min.js"></script>

    <script src="https://unpkg.com/chart.js@2.8.0/dist/Chart.bundle.js"></script>
    <script src="https://unpkg.com/chartjs-gauge@0.3.0/dist/chartjs-gauge.js"></script>

    <script>
        var _ydata = JSON.parse('{!! json_encode($monthCount) !!}');
        var _ydataLast = JSON.parse('{!! json_encode($monthCountLast) !!}');
        var _ydataProm = JSON.parse('{!! json_encode($monthCountProm) !!}');
        let month = ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre',
            'Noviembre', 'Diciembre'
        ]
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
                        label: year - 1,
                        data: _ydataLast,
                        borderColor: "green",
                        fill: false
                    }, {
                        label: "Media anual acumulada",
                        data: _ydataProm,
                        borderColor: "blue",
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

        //Barra Fallas por día

        var _ydataFalla = JSON.parse('{!! json_encode($fallasPorDia) !!}');
        let day = ['Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado', 'Domingo'];
        if (document.getElementById("fallasPorDia")) {
            var myChart = new Chart("fallasPorDia", {
                type: "bar",
                data: {
                    labels: day,
                    datasets: [{
                        data: _ydataFalla,
                        backgroundColor: [
                            'rgba(255, 99, 132, 0.8)',
                            'rgba(255, 159, 64, 0.8)',
                            'rgba(255, 205, 86, 0.8)',
                            'rgba(75, 192, 192, 0.8)',
                            'rgba(54, 162, 235, 0.8)',
                            'rgba(153, 102, 255, 0.8)',
                            'rgba(201, 203, 207, 0.8)'
                        ],
                        borderColor: [
                            'rgb(255, 99, 132)',
                            'rgb(255, 159, 64)',
                            'rgb(255, 205, 86)',
                            'rgb(75, 192, 192)',
                            'rgb(54, 162, 235)',
                            'rgb(153, 102, 255)',
                            'rgb(201, 203, 207)'
                        ],
                        borderWidth: 1
                    }]
                },
                options: {
                    legend: {
                        display: false
                    },
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        }

        // GAUGE 

        if (document.getElementById("temperaturaServer")) {
            var ctx = document.getElementById("temperaturaServer").getContext("2d");
        var chart = new Chart(ctx, {
            type: 'gauge',
            data: {
                datasets: [{
                    value: {{ $tempServer }} / 10,
                    minValue: 0,
                    data: [16, 26, 42],
                    backgroundColor: ['lightblue', 'green', 'red'],
                }]
            },
            options: {
                needle: {
                    radiusPercentage: 2,
                    widthPercentage: 3.2,
                    lengthPercentage: 80,
                    color: 'rgba(0, 0, 0, 1)'
                },
                valueLabel: {
                    display: true,
                    formatter: (value) => {
                        return value + "ºC";
                    },
                    color: 'rgba(255, 255, 255, 1)',
                    backgroundColor: 'rgba(0, 0, 0, 1)',
                    borderRadius: 5,
                    padding: {
                        top: 10,
                        bottom: 10
                    }
                }
            }
        });
        }
        

        if (document.getElementById("pm01sr01")) {
            var ctx = document.getElementById("pm01sr01").getContext("2d");
            var chart = new Chart(ctx, {
                type: 'gauge',
                data: {
                    datasets: [{
                        value: {{ $pm01sr01['values']['Presion'] }},
                        minValue: 0,
                        data: [0.6, 2.5, 3.1],
                        backgroundColor: ['lightblue', 'green', 'red'],
                    }]
                },
                options: {
                    needle: {
                        radiusPercentage: 2,
                        widthPercentage: 3.2,
                        lengthPercentage: 80,
                        color: 'rgba(0, 0, 0, 1)'
                    },
                    valueLabel: {
                        display: true,
                        formatter: (value) => {
                            return value + " kg";
                        },
                        color: 'rgba(255, 255, 255, 1)',
                        backgroundColor: 'rgba(0, 0, 0, 1)',
                        borderRadius: 5,
                        padding: {
                            top: 10,
                            bottom: 10
                        }
                    }
                }
            })
        };
    </script>
@stop
