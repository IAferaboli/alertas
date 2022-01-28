<?php

namespace App\Http\Controllers\Panel\Monitoreo;

use App\Http\Controllers\Controller;
use App\Models\Intervention;
use App\Models\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ReportController extends Controller
{

    public function __construct()
    {
        $this->middleware('can:panel.reports.monitoreo')->only('index');
        $this->middleware('can:panel.reports.monitoreo.interventions')->only('pdfInterventions');
        $this->middleware('can:panel.reports.monitoreo.flaws')->only('pdfFlaws');
        $this->middleware('can:panel.reports.monitoreo.files')->only('pdfFiles');
        $this->middleware('can:panel.reports.monitoreo.concejo')->only('pdfConcejo');

    }
    public function index()
    {
        return view('panel.reports.monitoreo.index');
    }

    public function pdfInterventions(Request $request)
    {

        $request->validate([
            'dateinInterventions' => 'required',
            'dateoutInterventions' => 'required'
        ]);

        $interventions = Intervention::whereBetween('date',[$request->dateinInterventions, $request->dateoutInterventions])
                                    ->where('status', 1)
                                    ->get();

        $fpdf = new Pdf();
  
        $fpdf->AliasNbPages();
        $fpdf->AddPage();
        $fpdf->SetFont('Arial','BU',10);

        $fpdf->Cell(177,5,utf8_decode("Intervenciones y solicitudes"),0,0,'C');
        $fpdf->SetTextColor(255, 255, 255);

        $fpdf->Ln(10);
        $fpdf->SetFont('Arial','B',8);
        $fpdf->Cell(7,5,"",0,0,'C',0);
        $fpdf->Cell(20,5,"Fecha",0,0,'C',true);
        $fpdf->Cell(10,5,"Hora",0,0,'C',true);
        $fpdf->Cell(140,5,utf8_decode("Intervención"),0,0,'C', true);
        $fpdf->Ln(6);
        $fpdf->SetFont('Arial','',7);
        $fpdf->SetTextColor(0, 0, 0);

        foreach ($interventions as $intervention) {
            $fpdf->Cell(7,4,"",0,0,'C',0);
            $fpdf->Cell(20,4,$intervention['date'],'T',0,'C',0);
            $fpdf->Cell(10,4,$intervention['hour'],'T',0,'C',0);
            $fpdf->MultiCell(140,4,utf8_decode($intervention['detail']),'T','J', false);
            $fpdf->Ln(1);
        }

        $fpdf->Output(Carbon::now()->timestamp.'.pdf', 'D');
        exit;
        
    }
}
