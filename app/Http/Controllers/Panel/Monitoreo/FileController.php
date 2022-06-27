<?php

namespace App\Http\Controllers\Panel\Monitoreo;

use App\Http\Controllers\Controller;
use App\Models\File;
use Illuminate\Http\Request;

class FileController extends Controller
{

    public function __construct()
    {
        $this->middleware('can:panel.monitoreo.files.index')->only('index');
        $this->middleware('can:panel.monitoreo.files.create')->only('create','store');
        $this->middleware('can:panel.monitoreo.files.edit')->only('edit', 'update');
        $this->middleware('can:panel.monitoreo.files.destroy')->only('destroy');
    }

    public function index()
    {
        $files = File::all()->count();
        return view('panel.monitoreo.files.index', compact('files'));
    }

    public function create()
    {
        return view('panel.monitoreo.files.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'datein' => 'required',
            'filenumber' => 'required',
            'init' => 'required',
            'notenumber' => 'required|unique:files',
            'datefilm' => 'required',
            'time' => 'required',
            'attach' => 'required',
            'dateout' => 'required',
        ]);

        $file = File::create($request->all());

        return redirect()->route('panel.monitoreo.files.index')->with('info', 'Expdte. agregado exitosamente');
    }

    public function edit(File $file)
    {
        return view('panel.monitoreo.files.edit', compact('file'));
    }


    public function update(Request $request, File $file)
    {
        $request->validate([
            'datein' => 'required',
            'filenumber' => 'required',
            'init' => 'required',
            'notenumber' => "required|unique:files,notenumber,$file->id",
            'datefilm' => 'required',
            'time' => 'required',
            'attach' => 'required',
            'dateout' => 'required',
        ]);

        $file->update($request->all());

        return redirect()->route('panel.monitoreo.files.edit', $file)->with('info', 'Expdte. actualizado exitosamente.');
    }

    public function destroy(File $file)
    {
        $file->delete();
        return redirect()->route('panel.monitoreo.files.index')->with('info', 'Expdte. eliminado exitosamente');
    }
}
