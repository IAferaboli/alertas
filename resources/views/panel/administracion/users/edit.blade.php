@extends('adminlte::page')

@section('title', 'Municipio VC')

@section('content_header')
    <h1>Editar rol de usuario</h1>
@stop

@section('content')

    @if (session('info'))
        <div class="alert alert-success">
            <strong>{{session('info')}}</strong>
        </div>
    @endif
    <div class="card">
        <div class="card-body">
          
            {!! Form::model($user, ['route'=>['panel.administracion.users.update', $user], 'method'=>'put']) !!}

           @include('panel.administracion.users.partials.form')

            {!! Form::submit('Asignar rol', ['class'=>'btn btn-primary mt-2']) !!}

            {!! Form::close() !!}

        </div>
    </div>
@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('js')
    <script> console.log('Hi!'); </script>
@stop