@extends('adminlte::page')

@section('title', 'Municipio VC')

@section('content_header')
    @can('panel.roles.create')
        <a href="{{route('panel.administracion.roles.create')}}" class="btn btn-secondary float-right">Nuevo rol</a>
    @endcan
    <h1>Lista de roles</h1>
@stop

@section('content')

    @if (session('info'))
        <div class="alert alert-success">
            {{session('info')}}
        </div>
    @endif
    <div class="card">
        <div class="card-body">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Rol</th>
                        <th colspan="2"></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($roles as $role)
                        <tr>
                            <td>{{$role->id}}</td>
                            <td>{{$role->name}}</td>
                            <td width="10px">
                                @can('panel.roles.edit')
                                    <a href="{{route('panel.administracion.roles.edit', $role)}}" class="btn btn-sm btn-warning"><i class="fas fa-pen"></i></a>
                                @endcan
                            </td>
                            <td width="10px">
                                @can('panel.roles.destroy')
                                    <form action="{{route('panel.administracion.roles.destroy', $role)}}" method="POST">
                                        @csrf
                                        @method('delete')
                                        <button type="submit" class="btn btn-danger btn-sm"><i class="fas fa-trash"></i></button>
                                    </form>
                                @endcan
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@stop
