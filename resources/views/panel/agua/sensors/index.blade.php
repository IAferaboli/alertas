@extends('adminlte::page')

@section('title', 'Municipio VC')

@section('content_header')
    <h1>Sensores de Presión de Agua</h1>
@stop

@section('content')

    <div class="row">
        <div class="col col-12 col-md-8">
            <x-adminlte-card title="Presión de sensor - PM01SR01" maximizable>
                <div class="card-body">
                    <canvas id="sensor" style="max-width:100%"></canvas>
                </div>
            </x-adminlte-card>
        </div>
        <div class="col col-12 col-md-4">
            <div class="row">
                <div class="col col-12">
                    <x-adminlte-card title="Presión actual - PM01SR01">
                        <div class="card-body">
                            <canvas id="pm01sr01" style="max-width:100%"></canvas>
                        </div>
                    </x-adminlte-card>
                </div>
               
            </div>
            <div class="row">
                <div class="col col-12">
                    <x-adminlte-card title="Último registro - PM01SR01">
                        <div class="card-body">
                            <strong class="">{{$dataSensor->created_at->format('d-m-Y - H:i')}}</strong>
                        </div>
                    </x-adminlte-card>
                </div>
                
            </div>
            
        </div>
    </div>

@stop

@section('css')
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
@stop

@section('js')
<script src="https://unpkg.com/chart.js@2.8.0/dist/Chart.bundle.js"></script>
<script src="https://unpkg.com/chartjs-gauge@0.3.0/dist/chartjs-gauge.js"></script>
    <script>
        var labels = JSON.parse('{!! json_encode($label) !!}');
        var presion = JSON.parse('{!! json_encode($presion) !!}');

        new Chart(document.getElementById("sensor"), {
            type: 'line',
            data: {
                labels: labels,
                datasets: [{
                    data: presion,
                    label: "PM01SR01",
                    borderColor: "#3e95cd",
                    fill: false
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
