<?php

namespace App\Http\Controllers\Panel\Administracion;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

use Spatie\Permission\Models\Role;

class UserController extends Controller
{

    public function __construct()
    {
        $this->middleware('can:panel.users.index')->only('index');
        $this->middleware('can:panel.users.edit')->only('edit', 'update');
    }

    public function index()
    {
        return view('panel.administracion.users.index');
    }

    public function create()
    {
        $roles = Role::all();
        return view('panel.administracion.users.create', compact('roles'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'username'=>'required|unique:users',
            'email' => 'required|email|unique:users',
            'password' => 'required',
        ]);

        $request['password'] = bcrypt($request->password);
        
        $user = User::create($request->all());

        $user->roles()->sync($request->roles);

        return redirect()->route('panel.administracion.users.edit', $user)->with('info', 'Usuario generado exitosamente');
    }

    public function edit(User $user)
    {
        $roles = Role::all();
        return view('panel.administracion.users.edit', compact('user','roles'));
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required',
            'username'=>"required|unique:users,username,$user->id",
            'email' => "required|unique:users,email,$user->id",
        ]);

        if ($request->password == null){
            $user->update($request->except('password'));
        } else {
            $request['password'] = bcrypt($request->password);
            $user->update($request->all());
        }

        $user->roles()->sync($request->roles);
        return redirect()->route('panel.administracion.users.index', $user)->with('info', 'Se actualizó el usuario correctamente');
    }

}
