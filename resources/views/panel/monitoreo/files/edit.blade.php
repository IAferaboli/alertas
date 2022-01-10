@extends('adminlte::page')

@section('title', 'Municipio VC')

@section('content_header')
    <h1>Editar expediente</h1>
@stop

@section('content')

    @if (session('info'))
        <div class="alert alert-success">
            <strong>{{session('info')}}</strong>
        </div>
    @endif
    
    <div class="card">
        <div class="card-body">
            {!! Form::model($file, ['route' => ['panel.monitoreo.files.update', $file], 'method'=>'put']) !!}

                @include('panel.monitoreo.files.partials.form')

                {!! Form::submit('Actualizar expediente', ['class' => 'btn btn-primary']) !!}
            {!! Form::close() !!}
        </div>
    </div>
@stop