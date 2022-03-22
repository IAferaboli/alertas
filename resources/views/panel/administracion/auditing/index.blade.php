@extends('adminlte::page')

@section('title', 'Municipio VC')

@section('content_header')
    <h1>Auditoría de usuario</h1>
@stop

@section('content')

    @livewire('panel.administracion.audits-index')

@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('js')
    <script>
        $(".exploder").click(function() {

            $(this).toggleClass("btn-success btn-danger");

            $(this).children("i").toggleClass("fa-plus-square fa-minus-square");

            $(this).closest("tr").next("tr").toggleClass("hide");

            if ($(this).closest("tr").next("tr").hasClass("hide")) {
                $(this).closest("tr").next("tr").children("td").slideUp();
            } else {
                $(this).closest("tr").next("tr").children("td").slideDown(350);
            }
        });
    </script>

@stop
