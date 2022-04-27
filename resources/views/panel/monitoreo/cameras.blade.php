@extends('adminlte::page')

@section('title', 'Municipio VC')

@section('content_header')
    <h1>Listado de dispositivos</h1>
@stop

@section('content')
    @livewire('panel.monitoreo.cameras-index')

@stop

@section('css')
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
@stop
