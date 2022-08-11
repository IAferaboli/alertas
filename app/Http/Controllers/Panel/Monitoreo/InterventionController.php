<?php

namespace App\Http\Controllers\Panel\Monitoreo;

use App\Http\Controllers\Controller;
use App\Models\Camera;
use App\Models\Intervention;
use App\Notifications\TelegramPrueba;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class InterventionController extends Controller
{

    public function __construct()
    {
        $this->middleware('can:panel.monitoreo.interventions.index')->only('index');
        $this->middleware('can:panel.monitoreo.interventions.create')->only('create', 'store');
        $this->middleware('can:panel.monitoreo.interventions.edit')->only('edit', 'update');
        $this->middleware('can:panel.monitoreo.interventions.destroy')->only('destroy');
    }

    public function index()
    {
        $interventions = Intervention::all();
     
        $cameras = Camera::orderBy('name', 'asc')->pluck('name', 'id');
        return view('panel.monitoreo.interventions.index', compact('interventions', 'cameras'));
    }

    public function create()
    {
        $cameras = Camera::orderBy('name', 'asc')->pluck('name', 'id');
        return view('panel.monitoreo.interventions.create', compact('cameras'));
    }


    public function store(Request $request)
    {

        $request->validate([
            'detail' => 'required|max:750',
            'date' => 'required|before_or_equal:today',
            'hour' => 'required',
            'camera_id' => 'required'
        ]);

        $intervention = Intervention::create(array_merge($request->all(), ['user_id' => auth()->id(), 'status' => 1]));
        $camera = Camera::where('id', $request->camera_id)->first();
        $camera->update([
            'countintervention' => $camera->countintervention + 1,
        ]);

        Arr::add($intervention, 'to',  env('TELEGRAM_MONITOREO_INTERVENCIONES'));
        Arr::add($intervention, 'content',  "*Fecha:* $request->date \n*Hora:* $request->hour \n*Intervención: * $request->detail");

        $intervention->notify(new TelegramPrueba);

        return redirect()->route('panel.monitoreo.interventions.index')->with('success', 'La intervención se agregó exitosamente.');
    }

    public function edit(Intervention $intervention)
    {

        $this->authorize('author', $intervention);

        $cameras = Camera::orderBy('name', 'asc')->pluck('name', 'id');
        return view('panel.monitoreo.interventions.edit', compact('intervention', 'cameras'));
    }

    public function update(Request $request, Intervention $intervention)
    {
        $request->validate([
            'detail' => 'required|max:750',
            'date' => 'required|before_or_equal:today',
            'hour' => 'required',
            'camera_id' => 'required'
        ]);

        $intervention->update($request->all());

        return redirect()->route('panel.monitoreo.interventions.index', $intervention)->with('success', 'La intervención se actualizó exitosamente.');
    }

    public function destroy(Intervention $intervention)
    {

        // $intervention->delete();
        $intervention->update([
            'status' => 0,
        ]);
        return redirect()->route('panel.monitoreo.interventions.index')->with('success', 'La intervención se anuló exitosamente.');
    }
}
