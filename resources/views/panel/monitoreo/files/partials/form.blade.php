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
        {!! Form::label('init', 'Iniciador') !!}
        {!! Form::text('init', null, ['class' => 'form-control', 'placeholder' => 'MPA/CRIA 1/AIC']) !!}

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
        {!! Form::label('datefilm', 'Fecha de registro fílmico') !!}
        {!! Form::date('datefilm', null, ['class' => 'form-control']) !!}

        @error('datefilm')
            <span class="text-danger">{{$message}}</span>
        @enderror
    </div>

    <div class="form-group col-md-3">
        {!! Form::label('time', 'Rango horario') !!}
        {!! Form::text('time', null, ['class' => 'form-control', 'placeholder' => 'hh:mm - hh:mm']) !!}

        @error('time')
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
