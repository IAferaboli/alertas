@extends('adminlte::page')

@section('title', 'Municipio VC')

@section('content_header')
@stop

@section('content')

    <div class="row pt-2">
       
        <div class="col col-lg-6 col-6">
            <div class="small-box bg-info">
                <div id="canvas-holder" class="canvas pt-2" style="width:30vw">
                    <canvas id="temperaturaServer"></canvas>
                </div>
                <div class="inner text-center">
                    <p>Temperatura Data Center</p>
                </div>
    
            </div>
        </div>
        <div class="col col-lg-6 col-6">
            <div class="small-box bg-info">
                <div id="canvas-holder" class="canvas pt-2" style="width:30vw">
                    <canvas id="pm01sr01"></canvas>
                </div>
                <div class="inner text-center">
                    <p>Presión de Agua - Municipio</p>
                </div>
    
            </div>
        </div>
    </div>

@stop

@section('css')
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css"
        integrity="sha512-xodZBNTC5n17Xt2atTPuE1HxjVMSvLVW9ocqUKLsCC5CXdbqCmblAshOMAS6/keqq/sMZMZ19scR4PsZChSR7A=="
        crossorigin="" />

    <style>
        #issMap {
            clear: both;
            position: relative;
            width: 100%;
            height: 100vh;
            z-index: 1;
        }


        .my-label {
            position: absolute;
            width: 50px;
            font-size: 5px;
        }

        .footer {
            position: fixed;
            width: 99%;
            z-index: 10;
            bottom: 2px;
        }

        .presion {
            bottom: 120px;
            right: 5px;
        }

        .canvas {
            padding-left: 0;
            padding-right: 0;
            margin-left: auto;
            margin-right: auto;
            display: block;
            width: 800px;
        }
    </style>


@stop

@section('js')

    <script src="https://unpkg.com/chart.js@2.8.0/dist/Chart.bundle.js"></script>
    <script src="https://unpkg.com/chartjs-gauge@0.3.0/dist/chartjs-gauge.js"></script>

    <script>
        const api_url3 = "{{ env('APP_URL') }}/api/datacenter/temperatura";
        const api_url5 = "{{ env('APP_URL') }}/api/datacenter/mqttdata/pm01sr01";
   
        //Gauge
        var ctx = document.getElementById("temperaturaServer").getContext("2d");
        var chart = new Chart(ctx, {
            type: 'gauge',
            data: {
                datasets: [{
                    value: 10 / 10,
                    minValue: 0,
                    data: [16, 26, 42],
                    backgroundColor: ['blue', 'green', 'red'],
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
                    fontSize: 15,
                    padding: {
                        top: 10,
                        bottom: 10
                    }
                }
            }
        });


        var ctx2 = document.getElementById("pm01sr01").getContext("2d");
        var chart2 = new Chart(ctx2, {
            type: 'gauge',
            data: {
                datasets: [{
                    value: 10 / 10,
                    minValue: 0,
                    data: [0.6, 2.5, 3.1],
                    backgroundColor: ['blue', 'green', 'red'],
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
                        return value + "kg";
                    },
                    color: 'rgba(255, 255, 255, 1)',
                    backgroundColor: 'rgba(0, 0, 0, 1)',
                    borderRadius: 5,
                    fontSize: 15,
                    padding: {
                        top: 10,
                        bottom: 10
                    }
                }
            }
        });

        function addData(data, data2) {
            chart.data.datasets[0].value = data / 10;
            chart.update();
            chart2.data.datasets[0].value = data2.values.Presion;
            chart2.update();
        }
        async function getTemp() {
            const response = await fetch(api_url3)
            const response2 = await fetch(api_url5)
            const data = await response.json();
            const data2 = await response2.json();
            addData(data, data2);
        }
        getTemp();
        myTimerInit();


        function myTimerInit() {
            var myTimer = setInterval(function() {
                    
                    getTemp();
                
            }, 100000);
        }
    </script>

@stop
