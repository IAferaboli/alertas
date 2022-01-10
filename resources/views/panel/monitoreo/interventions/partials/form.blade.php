<div class="form-row">

    <div class="form-group col-md-4">
        {!! Form::label('date', 'Fecha') !!}
        {!! Form::date('date', null, ['class' => 'form-control']) !!}

        @error('date')
            <span class="text-danger">{{$message}}</span>
        @enderror
    </div>

    <div class="form-group col-md-4">
        {!! Form::label('hour', 'Hora') !!}
        {!! Form::time('hour', null, ['class' => 'form-control']) !!}

        @error('hour')
            <span class="text-danger">{{$message}}</span>
        @enderror
    </div>

    <div class="form-group col-md-4">
        {!! Form::label('camera_id', 'Cámara') !!}

        {!! Form::select('camera_id', $cameras, null, ['class' => 'form-control']) !!}

        @error('camera_id')
            <span class="text-danger">{{$message}}</span>
        @enderror
    </div>
</div>
<div class="form-group">
    {!! Form::label('detail', 'Detalle') !!}
    {!! Form::textarea('detail', null, ['class' => 'form-control', 'placeholder'=>'Ingrese detalle de la intervención', 'rows'=>2]) !!}

    @error('detail')
            <span class="text-danger">{{$message}}</span>
    @enderror
</div>


