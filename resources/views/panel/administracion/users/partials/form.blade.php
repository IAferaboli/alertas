<div class="form-row">
    <div class="form-group col-12 col-md-3">
        {!! Form::label('name', 'Nombre y Apellido') !!}
        {!! Form::text('name', null, ['class' => 'form-control', 'placeholder' => 'Ingrese el nombre del usuario']) !!}

        @error('name')
            <small class="text-danger">{{ $message }}</small>
        @enderror
    </div>
    <div class="form-group col-12 col-md-3">
        {!! Form::label('username', 'Usuario') !!}
        {!! Form::text('username', null, ['class' => 'form-control', 'placeholder' => 'Ingrese el nombre de usuario']) !!}

        @error('username')
            <small class="text-danger">{{ $message }}</small>
        @enderror
    </div>

    <div class="form-group  col-12 col-md-3">
        {!! Form::label('email', 'E-Mail') !!}
        {!! Form::email('email', null, ['class' => 'form-control', 'placeholder' => 'Ingrese el email del usuario']) !!}

        @error('email')
            <small class="text-danger">{{ $message }}</small>
        @enderror
    </div>

    <div class="form-group col-12 col-md-3">
        {!! Form::label('password', 'Contraseña') !!}
        {!! Form::password('password', ['class' => 'form-control']) !!}


        @error('password')
            <small class="text-danger">{{ $message }}</small>
        @enderror
    </div>

</div>



<h2 class="h5">Lista de roles</h2>

@foreach ($roles as $role)
    <div>
        <label>
            {!! Form::checkbox('roles[]', $role->id, null, ['class' => 'mr-1']) !!}
            {{ $role->name }}
        </label>
    </div>
@endforeach
