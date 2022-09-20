<?php

namespace App\Http\Controllers\Panel\TV;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TvController extends Controller
{

    public function __construct()
    {
        $this->middleware('can:panel.tv.map')->only('map');
        $this->middleware('can:panel.tv.sensors')->only('sensor');

    }

    public function map()
    {
        return view('panel.tv.map');
    }

    public function sensor()
    {
        return view('panel.tv.sensor');
    }
}
