@extends('adminlte::page')

@section('title', 'Municipio VC')

@section('content_header')
    <h1>Reporte intervenciones</h1>
@stop

@section('content')

    @if (session('info'))
    <div class="alert alert-success">
        <strong>{{session('info')}}</strong>
    </div>
    @endif
    <div class="card">
        <div class="card-body">
            {!! Form::open(['route' => 'panel.reports.monitoreo.interventions.pdf']) !!}
            @csrf
                <div class="form-row">
                    <div class="form-group col-md-6">
                        {!! Form::label('datein', 'Fecha inicio') !!}
                        {!! Form::date('datein', null, ['class' => 'form-control']) !!}
                
                        @error('datein')
                            <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>
                
                    <div class="form-group col-md-6">
                        {!! Form::label('dateout', 'Fecha fin') !!}
                        {!! Form::date('dateout', null, ['class' => 'form-control']) !!}
                
                        @error('dateout')
                            <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>          
                    
                </div>
                
                {!! Form::submit('Generar reporte', ['class'=> 'btn btn-primary btn-block']) !!}

            {!! Form::close() !!}

        </div>
    </div>
@stop
