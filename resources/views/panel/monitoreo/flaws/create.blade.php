@extends('adminlte::page')

@section('title', 'Municipio VC')

@section('content_header')
    <h1>Crear falla</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-body">
            {!! Form::open(['route' => 'panel.monitoreo.flaws.store']) !!}

                @include('panel.monitoreo.flaws.partials.form')

                {!! Form::button('Añadir falla<i class="fas fa-paper-plane ml-3"></i> ', ['type' => 'submit', 'class' => 'btn btn-primary']) !!}
                {{-- {!! Form::submit('Enviar', ['class' => 'btn btn-primary']) !!} --}}
            {!! Form::close() !!}
        </div>
    </div>
@stop
