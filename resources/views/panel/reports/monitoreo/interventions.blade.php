@extends('adminlte::page')

@section('title', 'Municipio VC')

@section('content_header')
    <h1>Reportes Monitoreo</h1>
@stop

@section('content')

    @if (session('info'))
    <div class="alert alert-success">
        <strong>{{session('info')}}</strong>
    </div>
    @endif
    <div class="row">
        <div class="col-md-6 col-12">
            <div class="card">
                <div class="card-header">Intervenciones</div>
                <div class="card-body">
                    {!! Form::open(['route' => 'panel.reports.monitoreo.interventions.pdf']) !!}
                    @csrf
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                {!! Form::label('dateinInterventions', 'Fecha inicio') !!}
                                {!! Form::date('dateinInterventions', null, ['class' => 'form-control']) !!}
                        
                                @error('dateinInterventions')
                                    <span class="text-danger">{{$message}}</span>
                                @enderror
                            </div>
                        
                            <div class="form-group col-md-6">
                                {!! Form::label('dateoutInterventions', 'Fecha fin') !!}
                                {!! Form::date('dateoutInterventions', null, ['class' => 'form-control']) !!}
                        
                                @error('dateoutInterventions')
                                    <span class="text-danger">{{$message}}</span>
                                @enderror
                            </div>          
                            
                        </div>
                        
                        {!! Form::submit('Generar reporte', ['class'=> 'btn btn-primary btn-block']) !!}
        
                    {!! Form::close() !!}
        
                </div>
            </div>
        </div>
        <div class="col-md-6 col-12">
            <div class="card">
                <div class="card-header">Fallas</div>
                <div class="card-body">
                    {!! Form::open(['route' => 'panel.reports.monitoreo.interventions.pdf']) !!}
                    @csrf
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                {!! Form::label('dateinFlaws', 'Fecha inicio') !!}
                                {!! Form::date('dateinFlaws', null, ['class' => 'form-control']) !!}
                        
                                @error('dateinFlaws')
                                    <span class="text-danger">{{$message}}</span>
                                @enderror
                            </div>
                        
                            <div class="form-group col-md-6">
                                {!! Form::label('dateoutFlaws', 'Fecha fin') !!}
                                {!! Form::date('dateoutFlaws', null, ['class' => 'form-control']) !!}
                        
                                @error('dateoutFlaws')
                                    <span class="text-danger">{{$message}}</span>
                                @enderror
                            </div>          
                            
                        </div>
                        
                        {{-- {!! Form::submit('Generar reporte', ['class'=> 'btn btn-primary btn-block hidden']) !!} --}}
        
                    {!! Form::close() !!}
        
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6 col-12">
            <div class="card">
                <div class="card-header">Concejo</div>
                <div class="card-body">
                    {!! Form::open(['route' => 'panel.reports.monitoreo.interventions.pdf']) !!}
                    @csrf
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                {!! Form::label('dateinConcejo', 'Fecha inicio') !!}
                                {!! Form::date('dateinConcejo', null, ['class' => 'form-control']) !!}
                        
                                @error('dateinConcejo')
                                    <span class="text-danger">{{$message}}</span>
                                @enderror
                            </div>
                        
                            <div class="form-group col-md-6">
                                {!! Form::label('dateoutConcejo', 'Fecha fin') !!}
                                {!! Form::date('dateoutConcejo', null, ['class' => 'form-control']) !!}
                        
                                @error('dateoutConcejo')
                                    <span class="text-danger">{{$message}}</span>
                                @enderror
                            </div>          
                            
                        </div>
                        
        
                    {!! Form::close() !!}
        
                </div>
            </div>
        </div>
        <div class="col-md-6 col-12">
            <div class="card">
                <div class="card-header">Expedientes</div>
                <div class="card-body">
                    {!! Form::open(['route' => 'panel.reports.monitoreo.interventions.pdf']) !!}
                    @csrf
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                {!! Form::label('dateinFiles', 'Fecha inicio') !!}
                                {!! Form::date('dateinFiles', null, ['class' => 'form-control']) !!}
                        
                                @error('dateinFiles')
                                    <span class="text-danger">{{$message}}</span>
                                @enderror
                            </div>
                        
                            <div class="form-group col-md-6">
                                {!! Form::label('dateoutFiles', 'Fecha fin') !!}
                                {!! Form::date('dateoutFiles', null, ['class' => 'form-control']) !!}
                        
                                @error('dateoutFiles')
                                    <span class="text-danger">{{$message}}</span>
                                @enderror
                            </div>          
                            
                        </div>
                        
                        {{-- {!! Form::submit('Generar reporte', ['class'=> 'btn btn-primary btn-block hidden']) !!} --}}
        
                    {!! Form::close() !!}
        
                </div>
            </div>
        </div>
    </div>
    
@stop
