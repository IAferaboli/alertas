<div>
    @if (session('info'))
        <div class="alert alert-success">
            {{ session('info') }}
        </div>
    @endif
    <div class="card">
        <div class="card-header">
            <input wire:model="search" placeholder="Buscar por fecha de ingreso, Nº exp, Nº nota o fecha de filmación"
                class="form-control">
        </div>

        @if ($files->count())
            <div class="card-body">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Fec. Ing.</th>
                            <th>Nº Exp</th>
                            <th>Inicia</th>
                            <th>Nº Nota</th>
                            <th>Desde</th>
                            <th>Hasta</th>
                            <th>Adj</th>
                            <th>Fec. Sal.</th>
                            <th colspan="2" class="text-center">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($files as $file)
                            <tr>
                                <td>{{ \Carbon\Carbon::parse($file->datein)->format('d/m/Y') }}</td>
                                <td>{{ $file->filenumber }}</td>
                                <td>{{ $file->init }}</td>
                                <td>{{ $file->notenumber }}</td>
                                <td>{{ \Carbon\Carbon::parse($file->starttime)->format('d/m/y H:i')}}</td>
                                <td>{{ \Carbon\Carbon::parse($file->endtime)->format('d/m/y H:i')}}</td>
                                <td>{{ $file->attach }}</td>
                                <td>{{ \Carbon\Carbon::parse($file->dateout)->format('d/m/Y') }}</td>

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
</div>
