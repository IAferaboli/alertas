@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Editar intervención</h1>
@stop

@section('content')

    @if (session('info'))
        <div class="alert alert-success">
            <strong>{{session('info')}}</strong>
        </div>
    @endif
    
    <div class="card">
        <div class="card-body">

            {!! Form::model($intervention, ['route'=>['panel.monitoreo.interventions.update', $intervention],'autocomplete'=>'off', 'method'=>'put']) !!}

                @include('panel.monitoreo.interventions.partials.form')

                {!! Form::button('Actualizar intervención<i class="fas fa-sync-alt ml-3"></i>', ['type' => 'submit', 'class' => 'btn btn-primary']) !!}
                {{-- {!! Form::submit('Enviar', ['class' => 'btn btn-primary']) !!} --}}
            {!! Form::close() !!}
        </div>
    </div>
@stop