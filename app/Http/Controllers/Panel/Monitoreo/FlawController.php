<?php

namespace App\Http\Controllers\Panel\Monitoreo;

use App\Http\Controllers\Controller;
use App\Models\Camera;
use App\Models\Flaw;
use Illuminate\Http\Request;

class FlawController extends Controller
{
  

    public function __construct()
    {
        $this->middleware('can:panel.monitoreo.flaws.index')->only('index');
        $this->middleware('can:panel.monitoreo.flaws.create')->only('create','store');
        $this->middleware('can:panel.monitoreo.flaws.edit')->only('edit', 'update');
        $this->middleware('can:panel.monitoreo.flaws.destroy')->only('destroy');
    }

    public function index()
    {
        $flaws = Flaw::orderBy('dateflaw','desc')
                    ->orderBy('timeflaw','desc')
                    ->get();
        return view('panel.monitoreo.flaws.index', compact('flaws'));
    }

    
    public function create()
    {
        $cameras = Camera::orderBy('name')
                    ->pluck('name', 'id');
        return view('panel.monitoreo.flaws.create', compact('cameras'));
    }

  
    public function store(Request $request)
    {
        $request->validate([
            'dateflaw' => 'required',
            'timeflaw' => 'required',
            'description' => 'required',
            'camera_id' => 'required'
           
        ]);

        $flaw = Flaw::create($request->all());

        return redirect()->route('panel.monitoreo.flaws.index')->with('info', 'Falla agregada exitosamente');
    }

    public function edit(Flaw $flaw)
    {
        $cameras = Camera::orderBy('name')
                    ->pluck('name', 'id');

        return view('panel.monitoreo.flaws.edit', compact('flaw', 'cameras'));
    }

    public function update(Request $request, Flaw $flaw)
    {
        $request->validate([
            'dateflaw' => 'required',
            'timeflaw' => 'required',
            'description' => 'required',
            'camera_id' => 'required',
            'datesolution' => 'required',
            'timesolution' => 'required',
        ]);

        // return $request->all();

        $flaw->update($request->all());

        return redirect()->route('panel.monitoreo.flaws.edit', $flaw)->with('info', 'La falla se actualizó exitosamente.');
    }


    public function destroy(Flaw $flaw)
    {
        $flaw->delete();
        return redirect()->route('panel.monitoreo.flaws.index')->with('info', 'Falla eliminada correctamente');
    }
}
