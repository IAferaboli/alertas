@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Ubicaciones de cámaras</h1>
@stop

@section('content')

    <div class="row position-fixed fixed-bottom ml-3 mr-3">
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

            </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box @if (statusCameras('FUERA') == 0) bg-success @else bg-danger @endif">
                <div class="inner">
                    <h3>{{ statusCameras('FUERA') }}</h3>

                    <p>Fuera de Servicio</p>
                </div>
                <div class="icon">
                    <i class="ion ion-minus-circled"></i>
                </div>
            </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box @if (statusCameras('ACTIVE') == 0) bg-success @else bg-danger @endif">
                <div class="inner">
                    <h3>{{ statusCameras('ACTIVE') }}</h3>

                    <p>Cámaras Desactivadas</p>
                </div>
                <div class="icon">
                    <i class="ion ion-minus-circled"></i>
                </div>
            </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-6">
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

        const mymap = L.map('issMap').setView([0, 0], 6);
        const attribution =
            '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors';

        const tileUrl = 'https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png';
        const tiles = L.tileLayer(tileUrl, {
            attribution
        });
        tiles.addTo(mymap);

        const api_url = 'http://alertas.test/api/monitoreo/camaras';

        let firstTime = true;


        async function getISS() {
            const response = await fetch(api_url);
            const data = await response.json();

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
                    } else {
                        icon = domeIcon
                    }
                } else {
                    if (markers[i][3] === 1) {
                        icon = fixedOutIcon
                    } else {
                        icon = domeOutIcon
                    }
                }


                marker = new L.marker([markers[i][1], markers[i][2]], {
                        icon: icon
                    })

                    .bindPopup("Nombre: " + markers[i][0])
                    .addTo(mymap);
            }

            console.log(markers)

        }

        mymap.setView([-33.233425, -60.324238], 13);
        getISS();
        setInterval(getISS, 10000)
    </script>

@stop
