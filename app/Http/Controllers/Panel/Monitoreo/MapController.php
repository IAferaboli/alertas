<?php

namespace App\Http\Controllers\Panel\Monitoreo;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MapController extends Controller
{


    public function __construct()
    {
        $this->middleware('can:panel.monitoreo.maps.index')->only('cameras');

    }


    public function cameras()
    {
        getCameras();
        
        return view('panel.monitoreo.maps.index');
    }
}
