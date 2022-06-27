@extends('adminlte::page')

@section('title', 'Municipio VC')

@section('content_header')
    @can('panel.monitoreo.files.create')

        <a href="{{ route('panel.monitoreo.files.create') }}" class="btn btn-secondary float-right">Agregar expediente</a>
    @endcan
    <h1>Lista de expedientes ({{$files}})</h1>
@stop

@section('content')
    @livewire('panel.monitoreo.files-index')
@stop
