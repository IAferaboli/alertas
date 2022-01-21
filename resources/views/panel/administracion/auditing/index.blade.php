@extends('adminlte::page')

@section('title', 'Municipio VC')

@section('content_header')
    <h1>Auditoría de {{ auth()->user()->name }}</h1>
@stop

@section('content')

    @if (session('info'))
        <div class="alert alert-success">
            <strong>{{ session('info') }}</strong>
        </div>
    @endif
    <div class="card">
        <div class="card-header">
            Últimos 10 movimientos
        </div>
        <div class="card-body">
            {{-- <table class="table table-striped">
                <thead>
                    <tr>
                        <th>IP</th>
                        <th>Evento</th>
                        <th>Modelo</th>
                        <th>ID de modelo</th>
                        <th>Fecha</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($audits as $audit)
                        <tr class="disabled">
                            <td>{{ $audit->ip_address}}</td>
                            <td>{{ $audit->event }}</td>
                            <td>{{ $audit->auditable_type }}</td>
                            <td>{{ $audit->auditable_id }}</td>
                            <td>{{ $audit->created_at }}</td>
                            <td></td>

                        </tr>
                    @endforeach
                </tbody>
            </table> --}}

            <table class="table table-condensed">
                <thead>
                    <tr>
                        <th>Accion</th>
                        <th>IP</th>
                        <th>Evento</th>
                        <th>Modelo</th>
                        <th>ID de modelo</th>
                        <th>Fecha</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($audits as $audit)
                        <tr class="sub-container">
                            <td><button type="button" class="btn btn-xs btn-success exploder">
                                    <i class="fas fa-plus-square"></i></span>
                                </button></td>
                            <td>{{ $audit->ip_address }}</td>
                            <td>{{ $audit->event }}</td>
                            <td>{{ $audit->auditable_type }}</td>
                            <td>{{ $audit->auditable_id }}</td>
                            <td>{{ $audit->created_at }}</td>
                        </tr>


                        <tr class="explode hide">
                            <td colspan="6" style="background: #CCC; display: none;">
                                <table class="table table-condensed">
                                    <thead>
                                        <tr>
                                            @foreach ($audit->old_values as $key => $value)
                                                <th>{{ $key }}</th>
                                            @endforeach
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            @foreach ($audit->old_values as $key => $value)
                                                <td>{{ $value }}</td>
                                            @endforeach
                                        </tr>
                                    </tbody>
                                </table>

                                <table class="table table-condensed">
                                    <thead>
                                        <tr>
                                            @foreach ($audit->new_values as $key => $value)
                                                <th>{{ $key }}</th>
                                            @endforeach
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            @foreach ($audit->new_values as $key => $value)
                                                <td>{{ $value }}</td>
                                            @endforeach
                                        </tr>
                                    </tbody>
                                </table>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
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
