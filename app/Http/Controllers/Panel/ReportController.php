<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Models\Intervention;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade as PDF;

class ReportController extends Controller
{
    public function interventions()
    {
        return view('panel.reports.monitoreo.interventions');
    }

    public function pdfInterventions(Request $request)
    {
        $interventions = Intervention::whereBetween('date',[$request->datein, $request->dateout])
        ->orderBy('date')
        ->get();
        // return view('panel.reports.monitoreo.pdfinterventions', compact('interventions','request'));
        $pdf = PDF::loadView('panel.reports.monitoreo.pdfinterventions', compact('interventions','request'));
        return $pdf->download('interventions.pdf');
        
    }
}
