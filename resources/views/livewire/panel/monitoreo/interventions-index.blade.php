<div>
    @if (session('info'))
        <div class="alert alert-success">
            {{ session('info') }}
        </div>
    @endif
    <div class="card">
        <div class="card-header">
            {{-- <input wire:model="search" placeholder="Buscar por fecha, hora o detalle" class="form-control"> --}}
            <div class="form-row">

                <div class="form-group col-md-3">

                    {{-- Generar un campo de fecha --}}
                    <label for="fecha">Filtrar por Fecha</label>
                    <input wire:model="fecha" type="date" class="form-control" id="fecha">

                </div>

                <div class="form-group col-md-5">
                    <label for="hora">Filtrar por intervención</label>
                    <input wire:model="search" placeholder="Buscar por detalle" class="form-control">
                </div>

                <div class="form-group col-md-4">
                    {{-- Filtrar por cámara select --}}
                    <label for="camara">Filtrar por cámara</label>
                    <select wire:model="camara" class="form-control">
                        <option value="">Todas</option>
                        @foreach ($cameras as $key => $value)
                            <option value="{{ $key }}">{{ $value }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

        </div>

        @if ($interventions->count())
            <div class="card-body">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Fecha</th>
                            <th>Hora</th>
                            <th>Detalle</th>
                            <th colspan="3">Acción</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($interventions as $intervention)
                            <tr>
                                <td>{{ $intervention->id }}</td>
                                <td>{{ $intervention->date }}</td>
                                <td>{{ $intervention->hour }}</td>
                                <td>{{ $intervention->detail }} </td>
                                <td width="10px">
                                    @can('panel.monitoreo.interventions.edit')
                                        <a class="btn btn-warning btn-sm @if ($intervention->user_id != auth()->user()->id || $intervention->created_at != $intervention->updated_at) disabled @endif"
                                            href="{{ route('panel.monitoreo.interventions.edit', $intervention) }}"><i
                                                class="fas fa-pen"></i></a>
                                    @endcan
                                </td>
                                <td width="10px">
                                    @can('panel.monitoreo.interventions.destroy')
                                        <form
                                            action="{{ route('panel.monitoreo.interventions.destroy', $intervention->id) }}"
                                            method="POST">
                                            @csrf
                                            @method('delete')
                                            <button class="btn btn-danger btn-sm" type="submit"><i
                                                    class="fas fa-trash"></i></button>
                                        </form>

                                    @endcan
                                </td>
                                <td width="10px">
                                    @can('panel.monitoreo.interventions.viewrecord')
                                        {{-- Calcular dias entre dos fechas con Carbon --}}
                                            <a class="btn btn-secondary btn-sm"
                                                href="http://192.168.100.{{ $intervention->camera->server }}:8601/Interface/Cameras/Playback/GetJPEGStream?Camera={{ $intervention->camera->name }}&StartDate={{ date('Y.m.d', strtotime($intervention->date)) }}&StartTime={{ date('h.i.s', strtotime($intervention->hour)) }}&EndDate={{ date('Y.m.d', strtotime($intervention->date)) }}&EndTime={{ date('H.i.s', strtotime($intervention->hour) + 60) }}&ResponseFormat=Text"
                                                target="_blank"><i class="fas fa-eye"></i></a>


                                    @endcan
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="card-footer">
                {{ $interventions->links() }}
            </div>
        @else
            <div class="card-body">
                <strong>No hay registros.</strong>
            </div>
        @endif

    </div>


</div>
