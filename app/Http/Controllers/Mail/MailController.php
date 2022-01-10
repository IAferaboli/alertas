<?php

namespace App\Http\Controllers\Mail;

use App\Http\Controllers\Controller;
use App\Mail\Panel\Monitoreo\InterventionsMailable;
use App\Models\Intervention;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class MailController extends Controller
{
    public function interventionsMonitoreo()
    {
        $interventions = Intervention::where('date', '2019-05-01')->get();

        Mail::to('rotilinicolas@gmail.com')->send(new InterventionsMailable($interventions));
        
        return "Enviado";
    }
}
