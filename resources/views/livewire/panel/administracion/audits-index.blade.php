<div>
    @if (session('info'))
        <div class="alert alert-success">
            <strong>{{ session('info') }}</strong>
        </div>
    @endif
    <div class="card">
        <div class="card-header">
            <div class="form-row">
                @can('panel.administracion.audits.admin')
                    <div class="form-group col-md-6">

                        {{-- Generar un campo de fecha --}}
                        <label for="fecha">Filtrar por Fecha</label>
                        <input wire:model="fecha" type="date" class="form-control" id="fecha">

                    </div>
                    <div class="form-group col-md-6">
                        {{-- Filtrar por cámara select --}}
                        <label for="usuario">Filtrar por usuario</label>
                        <select wire:model="usuario" class="form-control">
                            <option value="" hidden selected>Nada</option>
                            <option value="0">Todos</option>
                            @foreach ($usuarios as $usuario)
                                <option value="{{ $usuario->id }}">{{ $usuario->name }}</option>
                            @endforeach
                        </select>
                    </div>
                @endcan
            </div>

        </div>

    @if ($audits->count())
        <div class="card-body">


            <table class="table table-condensed">
                <thead>
                    <tr>
                        <th>Accion</th>
                        <th>IP</th>
                        <th>Evento</th>
                        <th>Modelo</th>
                        <th>ID de modelo</th>
                        <th>Fecha</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($audits as $audit)
                        <tr class="sub-container">
                            <td><button type="button" class="btn btn-xs btn-success exploder">
                                    <i class="fas fa-plus-square"></i></span>
                                </button></td>
                            <td>{{ $audit->ip_address }}</td>
                            <td>{{ $audit->event }}</td>
                            <td>{{ $audit->auditable_type }}</td>
                            <td>{{ $audit->auditable_id }}</td>
                            <td>{{ $audit->created_at }}</td>
                        </tr>


                        <tr class="explode hide">
                            <td colspan="6" style="background: #CCC; display: none;">
                                <table class="table table-condensed">
                                    <thead>
                                        <tr>
                                            @foreach ($audit->old_values as $key => $value)
                                                <th>{{ $key }}</th>
                                            @endforeach
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            @foreach ($audit->old_values as $key => $value)
                                                <td>{{ $value }}</td>
                                            @endforeach
                                        </tr>
                                    </tbody>
                                </table>

                                <table class="table table-condensed">
                                    <thead>
                                        <tr>
                                            @foreach ($audit->new_values as $key => $value)
                                                <th>{{ $key }}</th>
                                            @endforeach
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            @foreach ($audit->new_values as $key => $value)
                                                <td>{{ $value }}</td>
                                            @endforeach
                                        </tr>
                                    </tbody>
                                </table>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="card-footer">
        </div>
    @else
        <div class="card-body">
            <strong>No hay registros.</strong>
        </div>
    @endif
    </div>
</div>
