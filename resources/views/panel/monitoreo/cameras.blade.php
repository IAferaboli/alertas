@extends('adminlte::page')

@section('title', 'Municipio VC')

@section('content_header')
    <h1>Listado de cámaras</h1>
@stop

@section('content')

    <table id="cameras" class="table table-striped" style="width: 100%">
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Funcionamiento</th>
                <th>Grabación</th>
                <th>FPS</th>
                <th>Servidor</th>
                @can('panel.monitoreo.cameras.viewcamera')
                    <th></th>

                @endcan
            </tr>
        </thead>
        <tbody>

            @if ($cameras1 && $cameras2 && $cameras3)
                @foreach ($cameras1['Response']['Data']['Cameras'] as $camera)

                    <tr>
                        <td>{{ $camera['Name'] }}</td>

                        @if ($camera['Working'] == 'TRUE')
                            <td class="text-success">Funcionando</td>
                        @else
                            <td class="text-danger">Fuera de servicio</td>
                        @endif
                        @if ($camera['WrittingToDisk'] == 'TRUE')
                            <td class="text-success">Grabando</td>
                        @else
                            <td class="text-danger">Sin grabar</td>
                        @endif
                        <td>{{ $camera['RecordingFPS'] }}</td>
                        <td>Serv. 1</td>

                        @can('panel.monitoreo.cameras.viewcamera')

                            <td>
                                <a href="http://192.168.100.1:8601/Interface/Cameras/GetJPEGStream?Camera={{ $camera['Name'] }}&AuthUser={{ env('DIGIFORT_USER') }}&AuthPass={{ env('DIGIFORT_PASSWORD') }}"
                                    target="_blank" class="btn btn-secondary btn-xs @if (!$camera['Working'] == 'TRUE') disabled @endif">
                                    <i class="fas fa-video"></i></a>
                            </td>
                        @endcan

                    </tr>


                @endforeach

                @foreach ($cameras2['Response']['Data']['Cameras'] as $camera)
                    <tr>
                        <td>{{ $camera['Name'] }}</td>
                        @if ($camera['Working'] == 'TRUE')
                            <td class="text-success">Funcionando</td>
                        @else
                            <td class="text-danger">Fuera de servicio</td>
                        @endif
                        @if ($camera['WrittingToDisk'] == 'TRUE')
                            <td class="text-success">Grabando</td>
                        @else
                            <td class="text-danger">Sin grabar</td>
                        @endif
                        <td>{{ $camera['RecordingFPS'] }}</td>
                        <td>Serv. 2</td>
                        @can('panel.monitoreo.cameras.viewcamera')

                            <td>
                                <a href="http://192.168.100.2:8601/Interface/Cameras/GetJPEGStream?Camera={{ $camera['Name'] }}&AuthUser=api&AuthPass=DaxIcEc1eD835iKAkIzI"
                                    target="_blank" class="btn btn-secondary btn-xs @if (!$camera['Working'] == 'TRUE') disabled @endif">
                                    <i class="fas fa-video"></i></a>
                            </td>
                        </tr>
                    @endcan
                @endforeach

                @foreach ($cameras3['Response']['Data']['Cameras'] as $camera)
                    <tr>
                        <td>{{ $camera['Name'] }}</td>
                        @if ($camera['Working'] == 'TRUE')
                            <td class="text-success">Funcionando</td>
                        @else
                            <td class="text-danger">Fuera de servicio</td>
                        @endif
                        @if ($camera['WrittingToDisk'] == 'TRUE')
                            <td class="text-success">Grabando</td>
                        @else
                            <td class="text-danger">Sin grabar</td>
                        @endif
                        <td>{{ $camera['RecordingFPS'] }}</td>
                        <td>Serv. 3</td>
                        @can('panel.monitoreo.cameras.viewcamera')

                            <td>
                                <a href="http://192.168.100.3:8601/Interface/Cameras/GetJPEGStream?Camera={{ $camera['Name'] }}&AuthUser=api&AuthPass=DaxIcEc1eD835iKAkIzI"
                                    target="_blank" class="btn btn-secondary btn-xs @if (!$camera['Working'] == 'TRUE') disabled @endif">
                                    <i class="fas fa-video"></i></a>
                            </td>
                        @endcan

                    </tr>
                @endforeach

            @endif



        </tbody>
    </table>



@stop

@section('css')
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
@stop

@section('js')

    <script>
        $(document).ready(function() {
            $('#cameras').DataTable({
                language: {
                    url: "//cdn.datatables.net/plug-ins/1.10.15/i18n/Spanish.json"
                },
                order: [
                    [1, "asc"],
                    [0, "asc"]
                ],
                select: true,


            });
        });
    </script>

@stop
