@extends('adminlte::page')

@section('title', 'Municipio VC')

@section('content_header')
    @can('panel.monitoreo.interventions.create')
        <a href="{{ route('panel.monitoreo.interventions.create') }}" class="btn btn-secondary float-right">Agregar
            intervención</a>
    @endcan
    <h1>Lista de intervenciones</h1>
@stop

@section('content')

    @livewire('panel.monitoreo.interventions-index')

@stop

@section('css')
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
@stop

@section('js')

@stop
