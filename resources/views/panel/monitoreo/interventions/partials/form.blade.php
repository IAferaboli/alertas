<div class="row">
    <div class="col col-12 col-md-8">
        <div class="form-row">
            <div class="form-group col-md-4">
                {!! Form::label('date', 'Fecha') !!}
                {!! Form::date('date', null, ['class' => 'form-control']) !!}

                @error('date')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group col-md-4">
                {!! Form::label('hour', 'Hora') !!}
                {!! Form::time('hour', null, ['class' => 'form-control']) !!}

                @error('hour')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group col-md-4">
                {!! Form::label('camera_id', 'Cámara') !!}

                {!! Form::select('camera_id', $cameras, null, ['class' => 'form-control']) !!}

                @error('camera_id')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
        </div>
        <div class="form-group">
            {!! Form::label('detail', 'Detalle') !!}
            {!! Form::textarea('detail', null, [
                'class' => 'form-control',
                'placeholder' => 'Ingrese detalle de la intervención',
                'rows' => 2,
            ]) !!}

            @error('detail')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
    </div>
    <div class="col col-12 col-md-4">
        <x-adminlte-card title="Anexar registros fílmicos" theme="blue" theme-mode="outline"
            header-class="text-uppercase rounded-bottom border-info" collapsible="collapsed">

            <div class="form-row">
                <div class="form-group col-md-12">
                    {!! Form::label('archivedate', 'Fecha') !!}
                    {!! Form::datetimeLocal('archivedate', null, ['class' => 'form-control']) !!}

                    @error('archivedate')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-12">
                    {!! Form::label('archive_camera_id', 'Cámara') !!}

                    {!! Form::select('archive_camera_id', $cameras, null, ['class' => 'form-control']) !!}

                    @error('archive_camera_id')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
            </div>
        </x-adminlte-card>
    </div>
</div>
