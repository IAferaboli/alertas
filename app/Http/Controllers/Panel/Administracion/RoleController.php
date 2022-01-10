<?php

namespace App\Http\Controllers\Panel\Administracion;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{

    public function __construct()
    {
        $this->middleware('can:panel.roles.index')->only('index');
        $this->middleware('can:panel.roles.create')->only('create', 'store');
        $this->middleware('can:panel.roles.edit')->only('edit', 'update');
        $this->middleware('can:panel.roles.destroy')->only('destroy');
    }

    public function index()
    {
        $roles = Role::all();
        return view('panel.administracion.roles.index', compact('roles'));
    }

    public function create()
    {
        $permissions = Permission::all();
        return view('panel.administracion.roles.create', compact('permissions'));
        
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'=>'required',
        ]);

        $role = Role::create($request->all());

        $role->permissions()->sync($request->permissions);

        return redirect()->route('panel.administracion.roles.edit', $role)->with('info', 'Rol generado exitosamente');
    }

    public function edit(Role $role)
    {
        $permissions = Permission::all();
        return view('panel.administracion.roles.edit', compact('role', 'permissions'));

    }

    public function update(Request $request, Role $role)
    {
        $request->validate([
            'name'=>'required',
        ]);

        $role->update($request->all());
        $role->permissions()->sync($request->permissions);

        return redirect()->route('panel.administracion.roles.edit', $role)->with('info', 'Rol actualizado exitosamente');
    }

    public function destroy(Role $role)
    {
        $role->delete();
        return redirect()->route('panel.administracion.roles.index', $role)->with('info', 'Rol eliminado exitosamente');

    }
}