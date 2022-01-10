@extends('adminlte::page')

@section('title', 'Municipio VC')

@section('content_header')
    <h1>Agregar expediente</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-body">
            {!! Form::open(['route' => 'panel.monitoreo.files.store']) !!}

                @include('panel.monitoreo.files.partials.form')

                {!! Form::submit('Agregar expediente', ['class' => 'btn btn-primary']) !!}
            {!! Form::close() !!}
        </div>
    </div>
@stop
