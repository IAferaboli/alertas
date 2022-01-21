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

        // $user = User::find(auth()->user()->id);
        // $audits = $user->audits()->get();

        // $flaw = Flaw::find(1);
        // $audits = $flaw->audits()->with('user')->get();

        $audits = Audit::where('user_id', auth()->user()->id)
                ->take(10)
                ->orderBy('created_at', 'desc')                
                ->get();
        // $audits = $user->audits()->take(10)->orderBy('id', 'desc')->get();
        // return $audits;
        return view('panel.administracion.auditing.index', compact('audits'));
    }
}
