@extends('adminlte::page')

@section('title', 'Municipio VC')

@section('content_header')
    {{-- @can('panel.roles.create') --}}
        <a href="{{route('panel.administracion.users.create')}}" class="btn btn-secondary float-right">Nuevo usuario</a>
    {{-- @endcan --}}
    <h1>Lista de usuarios</h1>
@stop

@section('content')
    @livewire('panel.users-index')
@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('js')
    <script> console.log('Hi!'); </script>
@stop