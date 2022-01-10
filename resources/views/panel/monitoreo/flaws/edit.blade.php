@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Editar falla</h1>
@stop

@section('content')

    @if (session('info'))
        <div class="alert alert-success">
            <strong>{{session('info')}}</strong>
        </div>
    @endif
    
    <div class="card">

        <div class="card-body">

            {!! Form::model($flaw, ['route' => ['panel.monitoreo.flaws.update', $flaw], 'autocomplete' => 'off', 'method' => 'put']) !!}

                @include('panel.monitoreo.flaws.partials.form')

                {!! Form::button('Actualizar falla<i class="fas fa-sync-alt ml-3"></i>', ['type' => 'submit', 'class' => 'btn btn-primary']) !!}
                {{-- {!! Form::submit('Enviar', ['class' => 'btn btn-primary']) !!} --}}
            {!! Form::close() !!}
        </div>
    </div>
@stop