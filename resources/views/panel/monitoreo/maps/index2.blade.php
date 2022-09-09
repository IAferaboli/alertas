@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Ubicaciones de cámaras</h1>
@stop

@section('content')


    <div class="row position-fixed fixed-top pt-3 pl-3 pr-3">
        <div class="col-lg-4 col-6 ml-auto">
            <!-- small box -->
            <div class="small-box bg-info ">
                <div id="canvas-holder" class="pt-2" style="width:15vw">
                    <canvas id="temperaturaServer"></canvas>
                </div>
                <div class="inner text-center">
                    <p>Temperatura Data Center</p>
                </div>

            </div>
        </div>

    </div>



    <!-- ./col -->
    <div class="col-lg-3 col-6 footer presion">
        <!-- small box -->
        <div class="small-box bg-info">
            <div id="canvas-holder" class="canvas pt-2" style="width:15vw">
                <canvas id="pm01sr01"></canvas>
            </div>
            <div class="inner text-center">
                <p>Presión de Agua - Municipio</p>
            </div>

        </div>
    </div>

    <div class="row footer">
        <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-info">
                <div class="inner">
                    <h3 id="cantCamaras">0</h3>

                    <p>Cámaras Totales</p>
                </div>
                <div class="icon">
                    <i class="fas fa-info-circle text-white"></i>

                </div>

            </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-6">
            <!-- small box -->
            <div id="divStatusCamera" class="small-box @if (statusCameras('FUERA') == 0) bg-success @else bg-danger @endif">
                <div class="inner">
                    <h3 id="statusCamera">{{ statusCameras('FUERA') }}</h3>

                    <p>Fuera de Servicio</p>
                </div>
                <div class="icon">
                    <i id="iconStatus" class="fas fa-check text-white"></i>
                </div>
            </div>
        </div>
        <!-- ./col -->

        <div class="col-lg-3 col-6">
            <!-- small box -->
            <div id="divMantCamera" class="small-box bg-success">
                <div class="inner">
                    <h3 id="statusMantCamera">0</h3>

                    <p>Mantenimiento</p>
                </div>
                <div class="icon">
                    <i class="fas fa-wrench text-white"></i>
                </div>
            </div>
        </div>

        <!-- ./col -->
        <div class="col-lg-3 col-6">
            <div class="small-box @if (getLicenses() <= 5) bg-danger @else bg-info @endif">
                <div class="inner">
                    <h3>{{ getLicenses() }}</h3>
                    <p>Licencias Disponibles</p>
                </div>
                <div class="icon">
                    <i class="fas fa-info-circle text-white"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="row footer">
        <div class="col-lg-12 col-12">
            <x-adminlte-progress id="progressBarTimer" theme="info" value=0 size="xs" />
        </div>
    </div>

    <div id="issMap"></div>

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

        #temperaturaServer {
            margin-left: 50%;
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
    <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"
        integrity="sha512-XQoYMqMTK8LvdxXYG3nZ448hOEQiglfqkJs1NOQV44cWnUrBc8PkAOcXy20w0vlaXaVUearIOBhiXZ5V3ynxwA=="
        crossorigin=""></script>
    <script>
        const api_url = "{{ env('APP_URL') }}/api/monitoreo/camaras";
        const api_url2 = "{{ env('APP_URL') }}/api/monitoreo/camaras/0";
        const api_url3 = "{{ env('APP_URL') }}/api/datacenter/temperatura";
        const api_url4 = "{{ env('APP_URL') }}/api/monitoreo/camaras/-1";
        const api_url5 = "{{ env('APP_URL') }}/api/datacenter/mqttdata/pm01sr01";
        var domos = L.layerGroup();
        var fijas = L.layerGroup();
        var out = L.layerGroup();
        var sinFuncionar = "";
        var markers2 = [];
        async function getISS() {
            const response = await fetch(api_url)
            const response2 = await fetch(api_url2)
            const response4 = await fetch(api_url4)
            const data4 = await response4.json();
            const data = await response.json();
            const data2 = await response2.json();

            sinFuncionar = Object.keys(data2).length;
            document.getElementById('cantCamaras').innerHTML = Object.keys(data).length;
            document.getElementById('statusCamera').innerHTML = Object.keys(data2).length;
            document.getElementById('statusMantCamera').innerHTML = Object.keys(data4).length;
            if (Object.keys(data2).length == 0) {
                document.getElementById('divStatusCamera').classList.add('bg-success');
                document.getElementById('iconStatus').classList.add('fa-check');
                document.getElementById('iconStatus').classList.remove('fa-exclamation-triangle');
                document.getElementById('divStatusCamera').classList.remove('bg-danger');
            } else {
                document.getElementById('divStatusCamera').classList.add('bg-danger');
                document.getElementById('iconStatus').classList.add('fa-exclamation-triangle');
                document.getElementById('iconStatus').classList.remove('fa-check');
                document.getElementById('divStatusCamera').classList.remove('bg-success');
            }

            if (Object.keys(data4).length == 0) {
                document.getElementById('divMantCamera').classList.add('bg-success');
                document.getElementById('divMantCamera').classList.remove('bg-warning');
            } else {
                document.getElementById('divMantCamera').classList.add('bg-warning');
                document.getElementById('divMantCamera').classList.remove('bg-success');
            }

            var markers = [];
            markers2 = []

            for (const camera of data) {
                markers.push([camera.name, camera.lat, camera.lng, camera.type, camera.status])
            }
            for (const camera of data2) {
                if (camera.status == 0) {
                    markers2.push([camera.lat, camera.lng])
                }
            }
            for (const camera of data4) {
                if (camera.status == -1) {
                    markers2.push([camera.lat, camera.lng])
                }
            }


            const domeIcon = L.icon({
                iconUrl: "{{ asset('img/dome.png') }}",
                iconSize: [32, 32],
                iconAnchor: [25, 25]
            });
            const domeOutIcon = L.icon({
                iconUrl: "{{ asset('img/domeOut.png') }}",
                iconSize: [32, 32],
                iconAnchor: [25, 25]
            });

            const domeMantIcon = L.icon({
                iconUrl: "{{ asset('img/domeMant.png') }}",
                iconSize: [32, 32],
                iconAnchor: [25, 25]
            });

            const fixedIcon = L.icon({
                iconUrl: "{{ asset('img/cctv.png') }}",
                iconSize: [32, 32],
                iconAnchor: [25, 25]
            });
            const fixedOutIcon = L.icon({
                iconUrl: "{{ asset('img/cctvOut.png') }}",
                iconSize: [32, 32],
                iconAnchor: [25, 25]
            });

            const fixedMantIcon = L.icon({
                iconUrl: "{{ asset('img/cctvMant.png') }}",
                iconSize: [32, 32],
                iconAnchor: [25, 25]
            });

            for (var i = 0; i < markers.length; i++) {
                let icon = ""
                if (markers[i][4] === 1) {
                    if (markers[i][3] === 1) {
                        icon = fixedIcon
                        var marker = L.marker([markers[i][1], markers[i][2]], {
                            icon: icon
                        }).bindPopup("Nombre: " + markers[i][0]).addTo(fijas);
                    } else {
                        icon = domeIcon
                        var marker = L.marker([markers[i][1], markers[i][2]], {
                            icon: icon
                        }).bindPopup("Nombre: " + markers[i][0]).addTo(domos);
                    }
                } else if (markers[i][4] === 0) {
                    if (markers[i][3] === 1) {
                        icon = fixedOutIcon
                        var marker = L.marker([markers[i][1], markers[i][2]], {
                                icon: icon
                            })
                            .bindPopup("Nombre: " + markers[i][0]).addTo(fijas);
                        var marker = L.marker([markers[i][1], markers[i][2]], {
                                icon: icon
                            })
                            .bindPopup("Nombre: " + markers[i][0]).addTo(out);
                    } else {
                        icon = domeOutIcon
                        var marker = L.marker([markers[i][1], markers[i][2]], {
                            icon: icon
                        }).bindPopup("Nombre: " + markers[i][0]).addTo(domos);
                        var marker = L.marker([markers[i][1], markers[i][2]], {
                            icon: icon
                        }).bindPopup("Nombre: " + markers[i][0]).addTo(out);
                    }
                } else {
                    if (markers[i][3] === 1) {
                        icon = fixedMantIcon
                        var marker = L.marker([markers[i][1], markers[i][2]], {
                                icon: icon
                            })
                            .bindPopup("Nombre: " + markers[i][0]).addTo(fijas);
                        var marker = L.marker([markers[i][1], markers[i][2]], {
                                icon: icon
                            })
                            .bindPopup("Nombre: " + markers[i][0]).addTo(out);
                    } else {
                        icon = domeMantIcon
                        var marker = L.marker([markers[i][1], markers[i][2]], {
                            icon: icon
                        }).bindPopup("Nombre: " + markers[i][0]).addTo(domos);
                        var marker = L.marker([markers[i][1], markers[i][2]], {
                            icon: icon
                        }).bindPopup("Nombre: " + markers[i][0]).addTo(out);
                    }
                }
            }
        }
        var mbAttr =
            'Dirección de Tecnología y Sistemas - Municipio de Villa Constitución';
        var mbUrl =
            'https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token=pk.eyJ1IjoibWFwYm94IiwiYSI6ImNpejY4NXVycTA2emYycXBndHRqcmZ3N3gifQ.rJcFIG214AriISLbB6B5aw';
        var grayscale = L.tileLayer(mbUrl, {
            id: 'mapbox/light-v9',
            tileSize: 512,
            zoomOffset: -1,
            attribution: mbAttr
        });
        var streets = L.tileLayer(mbUrl, {
            id: 'mapbox/streets-v11',
            tileSize: 512,
            zoomOffset: -1,
            attribution: mbAttr
        });
        var map = L.map('issMap', {
            center: [-33.2421833, -60.3220064],
            zoom: 14,
            layers: [grayscale, domos, fijas, out]
        });
        var baseLayers = {
            'Grises': grayscale,
            'Color': streets
        };
        var overlays = {
            'Domos': domos,
            'Fijas': fijas,
            'Sin Funcionar': out
        };
        var layerControl = L.control.layers(baseLayers, overlays).addTo(map);
        getISS();

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

        var myTimerProgress;


        function progressBarTimer() {
            let pBar = new _AdminLTE_Progress('progressBarTimer');

            let inc = (val) => {
                let v = pBar.getValue() + val;
                if (v >= 100) {
                    clearInterval(myTimerProgress);
                    console.log("V > 100: " + v)
                    return 0;
                }else{
                    console.log("V < 100: " +v)
                    return v;
                }
            };
            myTimerProgress = setInterval(() => pBar.setValue(inc((0.2))), 200);
        }


        function myTimerInit() {
            progressBarTimer();
            var myTimer = setInterval(function() {
                if (markers2.length != 0) {
                    domos.clearLayers();
                    fijas.clearLayers();
                    value = false;
                    getTemp();
                    clearInterval(myTimer);
                    var flightNumber = 0;
                    // clearInterval(myTimerProgress);
                    var myTimer2 = setInterval(function() {
                        if (flightNumber >= markers2.length) {

                            flightNumber = 0;
                            map.flyTo([-33.2421833, -60.3220064], 14)
                            out.clearLayers();
                            getISS();
                            value = true;
                            getTemp();
                            clearInterval(myTimer2);
                            myTimerInit();
                        } else {
                            map.flyTo([markers2[flightNumber][0], markers2[flightNumber][1]], 18);
                        }

                        flightNumber++;
                    }, 6000);
                } else {
                    domos.clearLayers();
                    fijas.clearLayers();
                    out.clearLayers();
                    getISS();
                    getTemp();

                }
            }, 100000);
        }
    </script>

@stop
