@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Ubicaciones de cámaras</h1>
@stop

@section('content')

    <div class="row position-fixed fixed-bottom ml-3 mr-3">
        <div class="col-lg-4 col-6">
            <!-- small box -->
            <div class="small-box bg-info">
                <div class="inner">
                    <h3>{{ cantCameras() }}</h3>

                    <p>Cámaras Totales</p>
                </div>
                <div class="icon">
                    <i class="ion ion-ios-videocam-outline"></i>
                </div>

            </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-4 col-6">
            <!-- small box -->
            <div class="small-box @if (statusCameras('FUERA') == 0) bg-success @else bg-danger @endif">
                <div class="inner">
                    <h3 id="statusCamera">{{ statusCameras('FUERA') }}</h3>

                    <p>Fuera de Servicio</p>
                </div>
                <div class="icon">
                    <i class="ion ion-minus-circled"></i>
                </div>
            </div>
        </div>
        <!-- ./col -->

        <!-- ./col -->
        <div class="col-lg-4 col-6">
            <!-- small box -->
            <div class="small-box @if (getLicenses() <= 10) bg-danger @else bg-info @endif">
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
        }

    </style>


@stop

@section('js')
    <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"
        integrity="sha512-XQoYMqMTK8LvdxXYG3nZ448hOEQiglfqkJs1NOQV44cWnUrBc8PkAOcXy20w0vlaXaVUearIOBhiXZ5V3ynxwA=="
        crossorigin=""></script>
    <script>
        const api_url = 'http://alertas.test/api/monitoreo/camaras';
        const api_url2 = 'http://alertas.test/api/monitoreo/camaras/0';
        var domos = L.layerGroup();
        var fijas = L.layerGroup();
        var out = L.layerGroup();
        var status = 0;


        async function getISS() {
            const response = await fetch(api_url)
            const response2 = await fetch(api_url2)
            const data = await response.json();
            const data2 = await response2.json();



            document.getElementById('statusCamera').innerHTML = data2;

            var markers = [];

            for (const camera of data) {
                markers.push([camera.name, camera.lat, camera.lng, camera.type, camera.status])
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
            center: [-33.233425, -60.324238],
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

        var value = true;
        setInterval(function() {
            if (value) {
                domos.clearLayers();
                fijas.clearLayers();
                value = false;
            } else {
                out.clearLayers();
                getISS();
                value = true;
            }
        }, 60000);
    </script>

@stop
