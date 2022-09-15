<div>
    @if (session('info'))
        <div class="alert alert-success">
            {{ session('info') }}
        </div>
    @endif
    <div class="card">
        <div class="card-header">
            <div class="form-row">
                <div class="form-group col-md-2">
                    <label for="datein">Fecha Ingreso</label>
                    <input type="date" wire:model="datein" class="form-control form-control-sm" name=""
                        id="datein">
                </div>
                <div class="form-group col-md-2">
                    <label for="filenumber">Expediente</label>
                    <input type="text" wire:model="filenumber" class="form-control form-control-sm" name=""
                        id="filenumber">
                </div>
                <div class="form-group col-md-2">
                    <label for="notenumber">Nº Nota </label>
                    <input type="text" wire:model="notenumber" class="form-control form-control-sm" name=""
                        id="notenumber">
                </div>
                <div class="form-group col-md-2">
                    <label for="init">Iniciador</label>
                    <input type="text" wire:model="init" class="form-control form-control-sm" name=""
                        id="init">
                </div>
                <div class="form-group col-md-2">
                    <label for="starttime">Fecha Registros</label>
                    <input type="date" wire:model="starttime" class="form-control form-control-sm" name=""
                        id="starttime">
                </div>
                <div class="form-group col-md-2">
                    <label for="month">Mes</label>
                    <input type="month" wire:model="month" class="form-control form-control-sm" name=""
                        id="month">
                </div>
            </div>

        </div>

        @if ($files->count())
            <div class="card-body">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Fecha ingreso</th>
                            <th>Nº Expediente</th>
                            <th>Nº Nota</th>
                            <th>Fecha salida</th>
                            <th colspan="3" class="text-center">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($files as $file)
                            <tr>
                                <td>{{ \Carbon\Carbon::parse($file->datein)->format('d/m/Y') }}</td>
                                <td>{{ $file->filenumber }}</td>
                                <td>{{ $file->notenumber }}</td>

                                <td>{{ \Carbon\Carbon::parse($file->dateout)->format('d/m/Y') }}</td>

                                <td width="10px">
                                    <button wire:click="showFile({{ $file }})"data-toggle="modal"
                                        data-target="#modalFiles" class="btn btn-secondary btn-xs" type=""><i
                                            class="fas fa-plus"></i></button>
                                </td>
                                <td width="10px">
                                    <a class="btn btn-warning btn-xs"
                                        href="{{ route('panel.monitoreo.files.edit', $file) }}"><i
                                            class="fas fa-pen"></i></a>
                                </td>
                                <td width="10px">
                                    <form action="{{ route('panel.monitoreo.files.destroy', $file) }}" method="POST">
                                        @csrf
                                        @method('delete')
                                        <button class="btn btn-danger btn-xs" type="submit"><i
                                                class="fas fa-trash"></i></button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="card-footer">
                {{ $files->links() }}
            </div>
        @else
            <div class="card-body">
                <strong>No hay registros.</strong>
            </div>
        @endif

    </div>

    {{-- Minimal --}}
    
    <x-adminlte-modal wire:ignore.self id="modalFiles" title="Expediente: {{ $expediente->filenumber }}">
        <div>
            <div class="row">
                <div class="col col-md-6">
                    <strong>Fecha Ingreso:</strong> {{ \Carbon\Carbon::parse($expediente->datein)->format('d/m/Y') }}
                </div>
                <div class="col col-md-6">
                    <strong>Fecha Salida:</strong> {{ \Carbon\Carbon::parse($expediente->dateout)->format('d/m/Y') }}   
                </div>
            </div>
            <div class="row">
                <div class="col col-md-6">
                    <strong>Iniciador:</strong> {{ $expediente->init }}   
                </div>
                <div class="col col-md-6">
                    <strong>Nº de Nota:</strong> {{ $expediente->notenumber }}
                </div>
            </div>

            <div class="row">
                <div class="col col-md-6">
                    <strong>Desde:</strong> {{ \Carbon\Carbon::parse($expediente->starttime)->format('d/m/Y - H:i') }}   
                </div>
                <div class="col col-md-6">
                    <strong>Hasta:</strong> {{ \Carbon\Carbon::parse($expediente->endtime)->format('d/m/Y - H:i') }}
                </div>
            </div>
        </div>
    </x-adminlte-modal>
</div>
