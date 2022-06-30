<div class="form-row">

    <div class="form-group col-md-3">
        {!! Form::label('datein', 'Fecha de ingreso') !!}
        {!! Form::date('datein', null, ['class' => 'form-control']) !!}

        @error('datein')
            <span class="text-danger">{{$message}}</span>
        @enderror
    </div>

    <div class="form-group col-md-3">
        {!! Form::label('filenumber', 'Nº expediente') !!}
        {!! Form::text('filenumber', null, ['class' => 'form-control', 'placeholder' => 'A111']) !!}

        @error('filenumber')
            <span class="text-danger">{{$message}}</span>
        @enderror
    </div>

    
    <div class="form-group col-md-3">
        {{-- {!! Form::label('init', 'Iniciador') !!}
        {!! Form::text('init', null, ['class' => 'form-control', 'placeholder' => 'MPA/CRIA 1/AIC']) !!} --}}
        {!! Form::label('init', 'Iniciador') !!}

        {!! Form::select('init', ['AIC'=>'AIC', 'CRIA 1'=>'CRIA 1', 'CRIA 13'=>'CRIA 13','MPA' => 'MPA', 'Otros' => 'Otros'], null, ['class' => 'form-control', 'placeholder' => 'Seleccione opción...']) !!}
        @error('init')
            <span class="text-danger">{{$message}}</span>
        @enderror
    </div>

    <div class="form-group col-md-3">
        {!! Form::label('notenumber', 'Nº Nota') !!}
        {!! Form::text('notenumber', null, ['class' => 'form-control', 'placeholder' => '0-00000-00']) !!}

        @error('notenumber')
            <span class="text-danger">{{$message}}</span>
        @enderror
    </div>
</div>

<div class="form-row">

    <div class="form-group col-md-3">
        {!! Form::label('starttime', 'Desde') !!}
        {!! Form::datetimeLocal('starttime', null, ['class' => 'form-control']) !!}

        @error('starttime')
            <span class="text-danger">{{$message}}</span>
        @enderror
    </div>

    <div class="form-group col-md-3">
        {!! Form::label('endtime', 'Hasta') !!}
        {!! Form::datetimeLocal('endtime', null, ['class' => 'form-control']) !!}

        @error('endtime')
            <span class="text-danger">{{$message}}</span>
        @enderror
    </div>

    <div class="form-group col-md-3">
        {!! Form::label('attach', 'Material entregado') !!}
        {!! Form::text('attach', null, ['class' => 'form-control', 'placeholder' => 'DVD - Disco extraíble - etc']) !!}

        @error('attach')
            <span class="text-danger">{{$message}}</span>
        @enderror
    </div>

    <div class="form-group col-md-3">
        {!! Form::label('dateout', 'Fecha de entrega') !!}
        {!! Form::date('dateout', null, ['class' => 'form-control']) !!}

        @error('dateout')
            <span class="text-danger">{{$message}}</span>
        @enderror
    </div>


</div>
