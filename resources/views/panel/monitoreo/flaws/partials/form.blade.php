<div class="form-row">

    <div class="form-group col-md-6">
        {!! Form::label('dateflaw', 'Fecha falla') !!}
        {!! Form::date('dateflaw', null, ['class' => 'form-control']) !!}

        @error('dateflaw')
            <span class="text-danger">{{$message}}</span>
        @enderror
    </div>

    <div class="form-group col-md-6">
        {!! Form::label('timeflaw', 'Hora falla') !!}
        {!! Form::time('timeflaw', null, ['class' => 'form-control']) !!}

        @error('timeflaw')
            <span class="text-danger">{{$message}}</span>
        @enderror
    </div>

    
</div>
<div class="form-row">

    <div class="form-group col-md-6">
        {!! Form::label('camera_id', 'Cámara') !!}

        {!! Form::select('camera_id', $cameras, null, ['class' => 'form-control']) !!}

        @error('camera_id')
            <span class="text-danger">{{$message}}</span>
        @enderror
    </div>
    
    <div class="form-group col-md-6">
        {!! Form::label('description', 'Motivo') !!}

        {!! Form::select('description', [
            'Corte de energía eléctrica'=>'Corte de energía eléctrica', 
            'Corte de FO'=>'Corte de FO',
            'Equipo quemado'=>'Equipo quemado',
            'Mantenimiento programado'=>'Mantenimiento programado',
            'Otros' => 'Otros',
            'Problema de tercero' => 'Problema de tercero', 
            'Sin clasificar'=>'Sin clasificar', 
            'Sin identificar'=>'Sin identificar'
                    ], null, ['class' => 'form-control', 'placeholder' => 'Seleccione opción...']) !!}



        @error('description')
            <span class="text-danger">{{$message}}</span>
        @enderror
    </div>
 
</div>

<div class="form-row">

    <div class="form-group col-md-6">
        {!! Form::label('datesolution', 'Fecha solución') !!}
        {!! Form::date('datesolution', null, ['class' => 'form-control']) !!}

        @error('datesolution')
            <span class="text-danger">{{$message}}</span>
        @enderror
    </div>

    <div class="form-group col-md-6">
        {!! Form::label('timesolution', 'Hora solución') !!}
        {!! Form::time('timesolution', null, ['class' => 'form-control']) !!}

        @error('timesolution')
            <span class="text-danger">{{$message}}</span>
        @enderror
    </div>

    
</div>

