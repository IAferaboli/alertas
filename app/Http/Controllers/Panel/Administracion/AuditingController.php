<?php

namespace App\Http\Controllers\Panel\Administracion;

use App\Http\Controllers\Controller;
use App\Models\Flaw;
use App\Models\User;
use OwenIt\Auditing\Models\Audit;

class AuditingController extends Controller
{
    public function index()
    {

        $audits = Audit::where('user_id', auth()->user()->id)
                ->take(10)
                ->orderBy('created_at', 'desc')                
                ->get();
     
        return view('panel.administracion.auditing.index', compact('audits'));
    }
}
