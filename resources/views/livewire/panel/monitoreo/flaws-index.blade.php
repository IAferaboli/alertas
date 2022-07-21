<div>

    @if (session('info'))
        <div class="alert alert-success">
            <strong>{{ session('info') }}</strong>
        </div>
    @endif
    <div class="card">

        <div class="card-header">
            <div class="form-row">
                <div class="form-group col-md-4">

                    {{-- Generar un campo de fecha --}}
                    <label for="fecha">Filtrar por Fecha</label>
                    <input wire:model="fecha" type="date" class="form-control form-control-sm" id="fecha">

                </div>

                <div class="form-group col-md-4">
                    {{-- Filtrar por cámara select --}}
                    <label for="camara">Filtrar por cámara</label>
                    <select wire:model="camara" class="form-control form-control-sm" id="camara">
                        <option value="">Todas</option>
                        @foreach ($cameras as $key => $value)
                            <option value="{{ $key }}">{{ $value }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group col-md-4">
                    {{-- Filtrar por cámara select --}}
                    <label for="descriptionFiltro">Filtrar por cámara</label>
                    <select wire:model="descriptionFiltro" class="form-control form-control-sm" id="descriptionFiltro">
                        <option value="" selected>Todas</option>
                        <option value="Corte de energía eléctrica">Corte de energía eléctrica</option>
                        <option value="Corte de FO">Corte de FO</option>
                        <option value="Equipo quemado">Equipo quemado</option>
                        <option value="Mantenimiento programado">Mantenimiento programado</option>
                        <option value="Otros">Otros</option>
                        <option value="Problema de tercero">Problema de tercero</option>
                        <option value="Sin clasificar">Sin clasificar</option>
                        <option value="Sin identificar">Sin identificar</option>
                    </select>
                </div>

            </div>
            
            @can('panel.monitoreo.flaws.updatemultiple')
                <div class="form-row">
                    <div class="form-group col-md-10">
                        {{-- Filtrar por cámara select --}}
                        <select wire:model="description" class="form-control form-control-sm" id="camara">
                            <option value="" hidden selected>Seleccione opción...</option>
                            <option value="Corte de energía eléctrica">Corte de energía eléctrica</option>
                            <option value="Corte de FO">Corte de FO</option>
                            <option value="Equipo quemado">Equipo quemado</option>
                            <option value="Mantenimiento programado">Mantenimiento programado</option>
                            <option value="Otros">Otros</option>
                            <option value="Problema de tercero">Problema de tercero</option>
                            <option value="Sin clasificar">Sin clasificar</option>
                            <option value="Sin identificar">Sin identificar</option>
                        </select>
                    </div>
                    <div class="form-group col-md-2">
                        <button wire:click="actualizaDescripcion" class="btn btn-secondary btn-block btn-sm"><i
                                class="fas fa-fw fa-sync-alt"></i></button>
                    </div>
                </div>
            @endcan

        </div>

        @if ($flaws->count())
            <div class="card-body">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Día Falla</th>
                            <th>Hora Falla</th>
                            <th>Desc.</th>
                            <th>Cám.</th>
                            <th>Día Sol.</th>
                            <th>Hora Sol.</th>
                            <th colspan="3"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($flaws as $flaw)
                            <tr>
                                <td>{{ \Carbon\Carbon::parse($flaw->dateflaw)->format('d/m/Y') }}</td>
                                <td>{{ \Carbon\Carbon::parse($flaw->timeflaw)->format('H:i') }}</td>
                                <td>{{ $flaw->description }}</td>
                                <td>{{ $flaw->Camera->name }}
                                <td>
                                    @if ($flaw->datesolution)
                                        {{ \Carbon\Carbon::parse($flaw->datesolution)->format('d/m/Y') }}
                                    @endif
                                </td>
                                <td>
                                    @if ($flaw->timesolution)
                                        {{ \Carbon\Carbon::parse($flaw->timesolution)->format('H:i') }}
                                    @endif
                                </td>

                                <td width="10px">
                                    @can('panel.monitoreo.flaws.updatemultiple')
                                        <input wire:model="selectflaw.{{ $flaw->id }}" class="form-control selectflaw"
                                            type="checkbox" value="{{ $flaw->id }}">
                                    @endcan

                                </td>



                                <td width="10px">
                                    @can('panel.monitoreo.flaws.edit')
                                        <a class="btn btn-warning btn-xs"
                                            href="{{ route('panel.monitoreo.flaws.edit', $flaw) }}"><i
                                                class="fas fa-pen"></i></a>
                                    @endcan
                                </td>
                                <td width="10px">
                                    @can('panel.monitoreo.flaws.destroy')
                                        <form action="{{ route('panel.monitoreo.flaws.destroy', $flaw) }}"
                                            method="POST">
                                            @csrf
                                            @method('delete')
                                            <button class="btn btn-danger btn-xs" type="submit"><i
                                                    class="fas fa-trash"></i></button>
                                        </form>
                                    @endcan

                                </td>


                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="card-footer">
                {{ $flaws->links() }}
            </div>
        @else
            <div class="card-body">
                <strong>No hay registros.</strong>
            </div>
        @endif
    </div>

</div>
