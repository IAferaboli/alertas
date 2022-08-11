<?php

namespace App\Http\Controllers\Mail;

use App\Http\Controllers\Controller;
use App\Mail\Panel\Monitoreo\InterventionsMailable;
use App\Models\Intervention;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;

class MailController extends Controller
{
    public function interventionsMonitoreo()
    {
        $date = new Carbon('now');
        $date = $date->format('Y-m-d');
        $interventions = Intervention::where('date', $date)->get();
        Mail::to('emonitoreo@villaconstitucion.gov.ar')
            ->bcc(['mjaime@villaconstitucion.gov.ar','alongo@villaconstitucion.gov.ar','rbianco@villaconstitucion.gov.ar','pflores@villaconstitucion.gov.ar','jorgerberti@gmail.com', 'lfarias@villaconstitucion.gov.ar'])
            ->send(new InterventionsMailable($interventions));
    }
}
