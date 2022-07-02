<?php

namespace App\Http\Controllers\Panel\Monitoreo;

use App\Http\Controllers\Controller;
use App\Http\Livewire\Panel\Monitoreo\CamerasIndex;
use App\Models\Camera;
use Carbon\Carbon;
use Illuminate\Http\Request;

class CameraController extends Controller
{


    public function __construct()
    {
        $this->middleware('can:panel.monitoreo.cameras.index')->only('index');
    }

    public function index()
    {
        return view('panel.monitoreo.cameras');
    }

    public function show(Camera $camera)
    {

        $camera = Camera::find($camera->id);

        $flaws = $camera->flaws()->get();

        $minutosOut = 0;
        foreach ($flaws as $flaw) {
            $fecha_inicial = Carbon::parse($flaw->dateflaw . ' ' . $flaw->timeflaw);
            $fecha_final = Carbon::parse($flaw->datesolution . ' ' . $flaw->timesolution);
            $minutosOut += $fecha_final->diffInMinutes($fecha_inicial);
        }

        $fecha_inicial = $camera->created_at;
        $fecha_final = Carbon::now();
        $minutosCreacion = $fecha_final->diffInMinutes($fecha_inicial);
        $minutos = $minutosCreacion - $minutosOut;
        $porcentaje = ($minutos*100)/$minutosCreacion;

        //Solo dos decimales a porcentaje
        $porcentaje = number_format($porcentaje, 2);

        return view('panel.monitoreo.cameras.show', compact('camera', 'porcentaje'));
    }

    public function create()
    {
        # code...
    }

    public function store()
    {
        # code...
    }

    public function edit(Camera $camera)
    {
        # code...
    }

    public function update(Request $request, Camera $camera)
    {
        # code...
    }

    public function destroy(Camera $camera)
    {
        # code...
    }

}
