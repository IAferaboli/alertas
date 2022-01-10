@extends('adminlte::page')

@section('title', 'Municipio VC')

@section('content_header')
    <h1>Crear intervención</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-body">
            {!! Form::open(['route' => 'panel.monitoreo.interventions.store']) !!}

                @include('panel.monitoreo.interventions.partials.form')

                {!! Form::button('Enviar intervención<i class="fas fa-paper-plane ml-3"></i> ', ['type' => 'submit', 'class' => 'btn btn-primary']) !!}
                {{-- {!! Form::submit('Enviar', ['class' => 'btn btn-primary']) !!} --}}
            {!! Form::close() !!}
        </div>
    </div>
@stop

