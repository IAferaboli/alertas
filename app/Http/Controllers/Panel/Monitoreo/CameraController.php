<?php

namespace App\Http\Controllers\Panel\Monitoreo;

use App\Http\Controllers\Controller;
use App\Http\Livewire\Panel\Monitoreo\CamerasIndex;
use App\Models\Camera;

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
}
