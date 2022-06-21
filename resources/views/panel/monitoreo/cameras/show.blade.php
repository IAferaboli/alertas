@extends('adminlte::page')

@section('title', 'Municipio VC')

@section('content_header')
    <a href="{{ route('panel.monitoreo.cameras.index') }}" class="btn btn-secondary float-right">
        VOLVER</a>
    <h1>Información detallada de cámara: <strong class="ml-2"> {{ $camera->name }} - @if ($camera->status == -1)
                <span class="badge badge-warning">Mantenimiento</span>
            @elseif ($camera->status == 1)
                <span class="badge badge-success">Activa</span>
            @else
                <span class="badge badge-danger">Inactiva</span>
            @endif
        </strong></h1>
@stop

@section('css')
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.0.2/dist/leaflet.css" />


    <style>
        #map {
            width: 100%;
            height: 100%;
            box-shadow: 5px 5px 5px #888;
        }
    </style>
@stop

@section('content')
    <div>
        <div class="card">


            <div class="card-body">

                <div class="row">

                    <div class="col col-12 col-lg-6">

                        <div class="row">
                            <div class="col col-12 col-lg-12">
                                <x-adminlte-info-box title="Nombre" text="{{ $camera->name }}" icon="fas fa-sm fa-video"
                                    icon-theme="info" />
                            </div>
                            <div class="col col-12 col-lg-12">
                                <x-adminlte-info-box title="Dirección IP" text="{{ $camera->addressip }}"
                                    icon="fab fa-sm fa-internet-explorer" icon-theme="info" />
                            </div>
                        </div>
                        <div class="row">
                            <div class="col col-12 col-lg-12">
                                <x-adminlte-info-box title="Descripción" text="{{ $camera->description }}"
                                    icon="fas fa-sm fa-info" icon-theme="info" />
                            </div>
                        </div>



                    </div>

                    <div class="col col-12 col-lg-6">

                        <div id="map"></div>

                    </div>

                </div>

                <div class="row mt-2">
                    <div class="col col-12 col-lg-6">
                        <div class="row">
                            <div class="col col-12 col-lg-12">
                                <x-adminlte-info-box title="Última modificación"
                                    text="{{ $camera->updated_at->diffForHumans() }}" icon="fas fa-sm fa-clock"
                                    icon-theme="info" />
                            </div>
                            <div class="col col-12 col-lg-12">
                                <x-adminlte-info-box title="Cantidad de intervenciones"
                                    text="{{ $camera->interventions->count() }}" icon="fas fa-sm fa-eye"
                                    icon-theme="info" />
                            </div>
                            <div class="col col-12 col-lg-12">
                                @if ($camera->interventions->count() > 0)
                                    <x-adminlte-info-box title="Última intervención"
                                        text="{{ $camera->interventions->last()->created_at->diffForHumans() }}"
                                        icon="fas fa-sm fa-calendar" icon-theme="info" />
                                @else
                                    <x-adminlte-info-box title="Última intervención" text="No hay intervenciones"
                                        icon="fas fa-sm fa-calendar" icon-theme="info" />
                                @endif

                            </div>
                        </div>
                    </div>

                    <div class="col col-12 col-lg-6 ">
                        <div class="card">
                            <div class="card-body  text-center">
                                <img class="img-fluid"
                                    src="http://192.168.100.{{ $camera->server }}:8601/Interface/Cameras/GetSnapshot?Camera={{ $camera->name }}&AuthUser={{ env('DIGIFORT_USER') }}&AuthPass={{ env('DIGIFORT_PASSWORD') }}"
                                    alt="Captura Cámara">
                            </div>
                        </div>

                    </div>
                </div>

                <div class="row mt-2">
                    <div class="col col-12 col-md-6 ">
                        <div class="card">
                            <div class="card-header">
                                <h5>Últimas 3 fallas</h5>
                            </div>
                            <div class="card-body">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th scope="col">Fecha - Hora (Falla)</th>
                                            <th scope="col">Solución</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($camera->flaws->sortByDesc('id')->take(3) as $flaw)
                                            <tr>
                                                <td>{{ $flaw->created_at->subMinutes(2)->format('d/m/y - h:m') }}</td>
                                                <td>{{ ($flaw->updated_at)->diffForHumans($flaw->created_at->subMinutes(2))}}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="col col-12 col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <canvas id="porcentajeChart" width="800" height="450"></canvas>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>
    </div>



@stop

@section('js')
    <script src="https://unpkg.com/leaflet@1.0.2/dist/leaflet.js"></script>
    <script src="https://unpkg.com/chart.js@2.8.0/dist/Chart.bundle.js"></script>


    <script>
        var map = L.map('map', {
            center: new L.LatLng({{ $camera->lat }}, {{ $camera->lng }}),
            zoom: 17
        });

        L.marker([{{ $camera->lat }}, {{ $camera->lng }}], {
            draggable: true
        }).addTo(map);
        L.tileLayer('http://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: 'Dirección de Tecnología y Sistemas - <a href="http://villaconstitucion.gob.ar" target="_blank">Municipio de Villa Constitución</a>',
            maxZoom: 18
        }).addTo(map);




        //Gráfico de estado

        new Chart(document.getElementById("porcentajeChart"), {
            type: 'pie',
            data: {
                labels: ["Funcionamiento", "Sin funcionar"],
                datasets: [{
                    backgroundColor: ["#3e95cd", "#8e5ea2"],
                    data: [{{ $porcentaje }}, {{ 100 - $porcentaje }}]
                }]
            },
            options: {
                title: {
                    display: true,
                    text: 'Porcentaje de funcionamiento desde {{ $camera->created_at->format('d/m/Y') }}'
                }
            }
        });
    </script>
@stop
