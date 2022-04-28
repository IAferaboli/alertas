<div>
    <div class="card">
        <div class="card-header">
            <div class="form-row">

                <div class="col-12 col-md-4">
                    <label for="name">Filtrar por Nombre</label>
                    <input wire:model="name" placeholder="Buscar por nombre" class="form-control form-control-sm"
                        type="text" id="name">
                </div>

                <div class="col-12 col-md-3">
                    <label for="type">Filtrar por Tipo</label>
                    <select wire:model="type" class="form-control form-control-sm" id="type">
                        <option value="">Seleccione opción</option>
                        <option value="0">Domos</option>
                        <option value="1">Fijas</option>
                        <option value="2">Server</option>
                    </select>
                </div>

                <div class="col-12 col-md-3">
                    <label for="status">Filtrar por Estado</label>
                    <select wire:model="status" class="form-control form-control-sm" id="status">
                        <option value="">Seleccione estado</option>
                        <option value="1">Activas</option>
                        <option value="0">Inactivas</option>
                    </select>
                </div>

                <div class="col-12 col-md-2">
                    <label for="cant">Cámaras por página</label>
                    <select wire:model="cant" class="form-control form-control-sm" id="cant">
                        <option value="">15</option>
                        <option value="25">25</option>
                        <option value="50">50</option>
                        <option value="100">100</option>
                    </select>
                </div>


            </div>

        </div>

        @if ($cameras->count())
            <div class="card-body">

                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Nombre</th>
                            <th class="text-center">Estado</th>
                            <th>Desc.</th>
                            <th>Serv.</th>
                            <th>Últ. Act.</th>
                            <th colspan="3" class="text-center">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($cameras as $camera)
                            <tr>
                                <td>{{ $camera->name }}</td>
                                <td class="text-center">

                                    @if ($camera->maintenance == 1)
                                        <span class="badge badge-warning">Mantenimiento</span>
                                    @elseif ($camera->status == 1)
                                        <span class="badge badge-success">Activa</span>
                                    @else
                                        <span class="badge badge-danger">Inactiva</span>
                                    @endif
                                </td>
                                <td>{{ $camera->description }}</td>
                                <td>Serv. {{ $camera->server }}</td>
                                <td><i class="fas fa-clock"></i> {{ $camera->updated_at->diffForHumans() }}</td>

                                @can('panel.monitoreo.cameras.viewcamera')
                                    <td width="5px">
                                        @if ($camera->type == 0 || $camera->type == 1)
                                            <a href="http://192.168.100.{{ $camera->server }}:8601/Interface/Cameras/GetJPEGStream?Camera={{ $camera->name }}&AuthUser={{ env('DIGIFORT_USER') }}&AuthPass={{ env('DIGIFORT_PASSWORD') }}"
                                                target="_blank"
                                                class="btn btn-secondary btn-xs @if ($camera->status == 0) disabled @endif">
                                                <i class="fas fa-video"></i></a>
                                        @endif
                                    </td>
                                @endcan
                                @can('panel.monitoreo.cameras.navigator')
                                    <td width="5px">

                                        <a href="http://{{ $camera->addressip }}" target="_blank"
                                            class="btn btn-secondary btn-xs">
                                            <i class="fab fa-chrome"></i></a>

                                    </td>
                                @endcan
                                @can('panel.monitoreo.cameras.maintenance')
                                    <td width="5px">
                                        @if ($camera->status != 0)
                                            <form action="" method="POST">
                                                @csrf

                                                <button
                                                    class="btn @if ($camera->maintenance == 0) btn-warning @else btn-success @endif  btn-xs"
                                                    type="submit"><i class="fas fa-wrench"></i></button>
                                            </form>
                                        @endif

                                    </td>
                                @endcan
                            </tr>
                        @endforeach
                    </tbody>
                </table>


            </div>
            <div class="card-footer">
                {{ $cameras->links() }}
            </div>
        @else
            <div class="card-body">
                <strong>No hay dispositivos.</strong>
            </div>
        @endif
    </div>
</div>
