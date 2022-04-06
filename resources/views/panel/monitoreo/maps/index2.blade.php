@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Ubicaciones de cámaras</h1>
@stop

@section('content')


    <div class="row position-fixed fixed-top mt-3 ml-3 mr-3">

        <div class="col-lg-4 col-6 ml-auto">
            <!-- small box -->
            <div class="small-box bg-info ">
                <div id="canvas-holder" class="pt-3 pl-2" style="width:15vw">
                    <canvas id="temperaturaServer"></canvas>
                </div>
                <div class="inner text-center">
                    <p>Temperatura Data Center</p>
                </div>


            </div>
        </div>

    </div>





    <div class="row position-fixed fixed-bottom ml-3 mr-3">
        <div class="col-lg-4 col-6">
            <!-- small box -->
            <div class="small-box bg-info">
                <div class="inner">
                    <h3>{{ cantCameras() }}</h3>

                    <p>Cámaras Totales</p>
                </div>
                <div class="icon">
                    <i class="fas fa-info-circle text-white"></i>

                </div>

            </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-4 col-6">
            <!-- small box -->
            <div id="divStatusCamera" class="small-box @if (statusCameras('FUERA') == 0) bg-success @else bg-danger @endif">
                <div class="inner">
                    <h3 id="statusCamera">{{ statusCameras('FUERA') }}</h3>

                    <p>Fuera de Servicio</p>
                </div>
                <div class="icon">
                    <i class="fas fa-exclamation-triangle text-white"></i>
                </div>
            </div>
        </div>
        <!-- ./col -->

        <!-- ./col -->
        <div class="col-lg-4 col-6">
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

    </style>


@stop

@section('js')

    <script src="https://unpkg.com/chart.js@2.8.0/dist/Chart.bundle.js"></script>
    <script src="https://unpkg.com/chartjs-gauge@0.3.0/dist/chartjs-gauge.js"></script>
    <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"
        integrity="sha512-XQoYMqMTK8LvdxXYG3nZ448hOEQiglfqkJs1NOQV44cWnUrBc8PkAOcXy20w0vlaXaVUearIOBhiXZ5V3ynxwA=="
        crossorigin=""></script>
    <script>
        const api_url = 'http://alertas.test/api/monitoreo/camaras';
        const api_url2 = 'http://alertas.test/api/monitoreo/camaras/0';
        const api_url3 = 'http://alertas.test/api/datacenter/temperatura';
        var domos = L.layerGroup();
        var fijas = L.layerGroup();
        var out = L.layerGroup();
        var sinFuncionar = "";
        var markers2 = [];
        async function getISS() {
            const response = await fetch(api_url)
            const response2 = await fetch(api_url2)
            const data = await response.json();
            const data2 = await response2.json();
            sinFuncionar = Object.keys(data2).length;
            document.getElementById('statusCamera').innerHTML = Object.keys(data2).length;
            if (Object.keys(data2).length == 0) {
                document.getElementById('divStatusCamera').classList.add('bg-success');
                document.getElementById('divStatusCamera').classList.remove('bg-danger');
            } else {
                document.getElementById('divStatusCamera').classList.add('bg-danger');
                document.getElementById('divStatusCamera').classList.remove('bg-success');
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
                } else {
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
            center: [-33.2421833, -60.3440649],
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

        function addData(data) {
            chart.data.datasets[0].value = data / 10;
            chart.update();
        }
        async function getTemp() {
            const response = await fetch(api_url3)
            const data = await response.json();
            addData(data);
        }
        getTemp();
        myTimerInit();
        function myTimerInit() {
            var myTimer = setInterval(function() {
            if (sinFuncionar == 0) {
                domos.clearLayers();
                fijas.clearLayers();
                out.clearLayers();
                getISS();
                getTemp();
            } else {
                domos.clearLayers();
                fijas.clearLayers();
                value = false;
                getTemp();
                clearInterval(myTimer);
                var flightNumber = 0;
                var myTimer2 = setInterval(function() {
                    if (flightNumber >= markers2.length) {
                        
                        flightNumber = 0;
                        map.flyTo([-33.2421833, -60.3440649], 14)
                        out.clearLayers();
                        getISS();
                        value = true;
                        getTemp();
                        clearInterval(myTimer2);
                        myTimerInit();
                    } else {
                        console.log("Flight number: " + flightNumber);
                        map.flyTo([markers2[flightNumber][0], markers2[flightNumber][1]], 18);
                    }

                    flightNumber++;
                }, 8000);

            }
        }, 60000);
        }
        
    </script>

@stop
