<?php

namespace App\Http\Controllers\Panel\Monitoreo;

use App\Http\Controllers\Controller;

class CameraController extends Controller
{


    public function __construct()
    {
        $this->middleware('can:panel.monitoreo.cameras.index')->only('index');
    }

    public function index()
    {
        $cameras1 = listCameras(1);
        $cameras2 = listCameras(2);
        $cameras3 = listCameras(3);

        return view('panel.monitoreo.cameras', compact('cameras1','cameras2','cameras3'));
    }
}
