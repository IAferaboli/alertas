<div>
    @if (session('info'))
        <div class="alert alert-success">
            {{ session('info') }}
        </div>
    @endif
    <div class="card">
        <div class="card-header">
            <div class="form-row">

                <div class="form-group col-md-3">

                    <label for="fecha">Filtrar por Fecha</label>
                    <input wire:model="fecha" type="date" class="form-control form-control-sm" id="fecha">

                </div>

                <div class="form-group col-md-5">
                    <label for="intervencion">Filtrar por intervención</label>
                    <input wire:model="search" id="intervencion" placeholder="Buscar por detalle" class="form-control form-control-sm">
                </div>

                <div class="form-group col-md-4">
                    <label for="camara">Filtrar por cámara</label>
                    <select wire:model="camara" id="camara" class="form-control form-control-sm">
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
                            <th>Fecha</th>
                            <th>Hora</th>
                            <th>Detalle</th>
                            <th colspan="4">Acción</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($interventions as $intervention)
                            <tr class="disabled">
                                <td @if ($intervention->status == 0) style="text-decoration:line-through" @endif>{{ \Carbon\Carbon::parse($intervention->date)->format('d/m/Y')}}</td>
                                <td @if ($intervention->status == 0) style="text-decoration:line-through" @endif>{{ \Carbon\Carbon::parse($intervention->hour)->format('H:i') }}</td>
                                <td @if ($intervention->status == 0) style="text-decoration:line-through" @endif>{{ $intervention->detail }} </td>
                                <td width="10px">
                                    @can('panel.monitoreo.interventions.edit')
                                        @if($intervention->status == 1)
                                        <a class="btn btn-warning btn-xs @if (($intervention->user_id == auth()->user()->id && $intervention->created_at == $intervention->updated_at) ||
    auth()->user()->roles->pluck('name')->contains('Supervisor de Monitoreo')) enabled @else disabled @endif"
                                            href="{{ route('panel.monitoreo.interventions.edit', $intervention) }}"><i
                                                class="fas fa-pen"></i></a>
                                        @endif
                                    @endcan
                                </td>
                                <td width="10px">
                                    @can('panel.monitoreo.interventions.destroy')
                                        <form
                                            action="{{ route('panel.monitoreo.interventions.destroy', $intervention->id) }}"
                                            method="POST" class="form-delete">
                                            @csrf
                                            @method('delete')
                                            <button class="btn @if ($intervention->status == 1) btn-danger @else btn-success @endif btn-xs" type="submit"><i
                                                    class="fas @if ($intervention->status == 1) fa-arrow-down @else fa-arrow-up @endif"></i></button>
                                        </form>
                                    @endcan
                                </td>
                                <td width="10px">
                                    
                                    @can('panel.monitoreo.interventions.viewrecord')
                                        @if ($intervention->camera->published == 1 && ((\Carbon\Carbon::parse($intervention->date))->diffInDays(now())) < 29 && $intervention->status == 1)
                                            <a class="btn btn-secondary btn-xs"
                                                href="http://192.168.100.{{ $intervention->camera->server }}:8601/Interface/Cameras/Playback/GetJPEGStream?Camera={{ $intervention->camera->name }}&StartDate={{ date('Y.m.d', strtotime($intervention->date)) }}&StartTime={{ date('H.i.s', strtotime($intervention->hour)) }}&EndDate={{ date('Y.m.d', strtotime($intervention->date)) }}&EndTime={{ date('H.i.s', strtotime($intervention->hour) + 60) }}&ResponseFormat=Text&AuthUser={{env('DIGIFORT_USER')}}&AuthPass={{env('DIGIFORT_PASSWORD')}}"
                                                target="_blank"><i class="fas fa-eye"></i></a>
                                        @endif
                                    @endcan
                                    
                                </td>
                                <td width="10px">
                                    @can('panel.monitoreo.interventions.viewrecord')
                                        @if (((\Carbon\Carbon::parse($intervention->date))->diffInDays(now())) < 29 && $intervention->status == 1 && $intervention->archivedate && $intervention->archive_camera_id)
                                            <a class="btn btn-secondary btn-xs"
                                                href="http://192.168.100.{{ $intervention->archive_camera->server }}:8601/Interface/Cameras/Playback/GetJPEGStream?Camera={{ $intervention->archive_camera->name }}&StartDate={{ date('Y.m.d', strtotime($intervention->archivedate)) }}&StartTime={{ date('H.i.s', strtotime($intervention->archivedate)) }}&EndDate={{ date('Y.m.d', strtotime($intervention->archivedate)) }}&EndTime={{ date('H.i.s', strtotime($intervention->archivedate) + 60) }}&ResponseFormat=Text&AuthUser={{env('DIGIFORT_USER')}}&AuthPass={{env('DIGIFORT_PASSWORD')}}"
                                                target="_blank"><i class="mx-1 fas fa-file-video"></i></a>
                                        @endif
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
