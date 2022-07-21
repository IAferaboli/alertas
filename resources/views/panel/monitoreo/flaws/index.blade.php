@extends('adminlte::page')

@section('title', 'Municipio VC')

@section('content_header')
    @can('panel.monitoreo.flaws.create')
        <a href="{{ route('panel.monitoreo.flaws.create') }}" class="btn btn-secondary float-right">Agregar falla</a>
    @endcan
    <h1>Lista de fallas</h1>
@stop

@section('content')

    @livewire('panel.monitoreo.flaws-index')

@stop
