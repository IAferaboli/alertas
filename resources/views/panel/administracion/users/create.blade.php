@extends('adminlte::page')

@section('title', 'Municipio VC')

@section('content_header')
    <h1>Agregar usuario</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-body">
            {!! Form::open(['route' => 'panel.administracion.users.store']) !!}

                @include('panel.administracion.users.partials.form')

                {!! Form::submit('Agregar expediente', ['class' => 'btn btn-primary']) !!}
            {!! Form::close() !!}
        </div>
    </div>
@stop
