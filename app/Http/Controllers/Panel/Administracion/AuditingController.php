<?php

namespace App\Http\Controllers\Panel\Administracion;

use App\Http\Controllers\Controller;


class AuditingController extends Controller
{
    public function index()
    {
     
        return view('panel.administracion.auditing.index');
    }
}
