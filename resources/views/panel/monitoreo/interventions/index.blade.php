@extends('adminlte::page')

@section('title', 'Municipio VC')

@section('content_header')
    @can('panel.monitoreo.interventions.create')
        <a href="{{ route('panel.monitoreo.interventions.create') }}" class="btn btn-secondary float-right">Agregar
            intervención</a>
    @endcan
    <h1>Lista de intervenciones</h1>
@stop

@section('content')

    @livewire('panel.monitoreo.interventions-index')

@stop

@section('css')
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
@stop

@section('js')
    <script>
        $('.form-delete').submit(function(e) {
            e.preventDefault();

            Swal.fire({
                title: 'Estás seguro de eliminarlo?',
                text: "La intervención quedará desactivada pero no visible!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                cancelButtonText: 'Cancelar',
                confirmButtonText: 'Sí, eliminar!'
            }).then((result) => {
                if (result.value) {
                    // Swal.fire(
                    //     'Deleted!',
                    //     'Your file has been deleted.',
                    //     'success'
                    // )
                    //Send form
                    this.submit();
                }
            })

        })
    </script>
@stop
