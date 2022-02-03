<?php

namespace App\Http\Controllers\Panel\Monitoreo;

use App\Http\Controllers\Controller;
use App\Models\Camera;
use App\Models\File;
use App\Models\Flaw;
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
            'dateoutInterventions' => 'required|after_or_equal:dateinInterventions',
        ]);

        $interventions = Intervention::whereBetween('date', [$request->dateinInterventions, $request->dateoutInterventions])
            ->where('status', 1)
            ->orderBy('date', 'asc')
            ->orderBy('hour', 'asc')
            ->get();

        $fpdf = new Pdf();

        $fpdf->AliasNbPages();
        $fpdf->AddPage();
        $fpdf->SetFont('Arial', 'BU', 10);

        $fpdf->Cell(177, 5, utf8_decode("Intervenciones y solicitudes"), 0, 0, 'C');
        $fpdf->SetTextColor(255, 255, 255);

        $fpdf->Ln(10);
        $fpdf->SetFont('Arial', 'B', 8);
        $fpdf->Cell(7, 5, "", 0, 0, 'C', 0);
        $fpdf->Cell(20, 5, "Fecha", 0, 0, 'C', true);
        $fpdf->Cell(10, 5, "Hora", 0, 0, 'C', true);
        $fpdf->Cell(140, 5, utf8_decode("Intervención"), 0, 0, 'C', true);
        $fpdf->Ln(6);
        $fpdf->SetFont('Arial', '', 7);
        $fpdf->SetTextColor(0, 0, 0);

        foreach ($interventions as $intervention) {
            $fpdf->Cell(7, 4, "", 0, 0, 'C', 0);
            $fpdf->Cell(20, 4, $intervention->date, 'T', 0, 'C', 0);
            $fpdf->Cell(10, 4, $intervention->hour, 'T', 0, 'C', 0);
            $fpdf->MultiCell(140, 4, utf8_decode($intervention->detail), 'T', 'J', false);
            $fpdf->Ln(1);
        }

        $fpdf->Output(Carbon::now()->timestamp . '.pdf', 'D');
        exit;
    }

    public function pdfFlaws(Request $request)
    {

        $request->validate([
            'dateinFlaws' => 'required',
            'dateoutFlaws' => 'required|after_or_equal:dateinFlaws',
        ]);


        $flaws = Flaw::whereBetween('dateFlaw', [$request->dateinFlaws, $request->dateoutFlaws])
            ->orderBy('dateFlaw', 'ASC')
            ->orderBy('timeFlaw', 'ASC')
            ->get();

        $pdf = new PDF();
        $pdf->AliasNbPages();
        $pdf->AddPage();
        $pdf->SetFont('Arial', 'BU', 10);
        $pdf->Cell(177, 5, utf8_decode("Desperfectos y fallas"), 0, 0, 'C');
        $pdf->SetTextColor(255, 255, 255);
        $pdf->Ln(10);
        $pdf->SetFont('Arial', 'B', 8);
        $pdf->Cell(7, 5, "", 0, 0, 'C', 0);
        $pdf->Cell(20, 5, utf8_decode("Día"), 0, 0, 'C', true);
        $pdf->Cell(10, 5, "Hora", 0, 0, 'C', true);
        $pdf->Cell(55, 5, utf8_decode("Cámara"), 0, 0, 'C', true);
        $pdf->Cell(55, 5, utf8_decode("Descripción"), 0, 0, 'C', true);
        $pdf->Cell(20, 5, utf8_decode("Día sol."), 0, 0, 'C', true);
        $pdf->Cell(20, 5, utf8_decode("Hora sol."), 0, 0, 'C', true);
        $pdf->Ln(6);
        $pdf->SetFont('Arial', '', 7);
        $pdf->SetTextColor(0, 0, 0);

        foreach ($flaws as $flaw) {

            $pdf->Cell(7, 4, "", 0, 0, 'C', 0);
            $pdf->Cell(20, 4, $flaw->dateflaw, 'T', 0, 'C', 0);
            $pdf->Cell(10, 4, $flaw->timeflaw, 'T', 0, 'C', 0);
            $pdf->Cell(55, 4, $flaw->Camera->name, 'T', 0, 'C', 0);
            $pdf->Cell(55, 4, utf8_decode($flaw->description), 'T', 0, 'C', 0);
            $pdf->Cell(20, 4, $flaw->datesolution, 'T', 0, 'C', 0);
            $pdf->Cell(20, 4, $flaw->timesolution, 'T', 0, 'C', 0);
            $pdf->Ln(4);
        }

        $pdf->Output(Carbon::now()->timestamp . '.pdf', 'D');
        exit;
    }

    public function pdfFiles(Request $request)
    {
        $request->validate([
            'dateinFiles' => 'required',
            'dateoutFiles' => 'required|after_or_equal:dateinFiles',
        ]);

        $files = File::whereBetween('datein', [$request->dateinFiles, $request->dateoutFiles])
            ->orderBy('datein', 'ASC')
            ->get();

        $pdf = new PDF();
        $pdf->AliasNbPages();
        $pdf->AddPage();
        $pdf->SetFont('Arial', 'BU', 10);
        $pdf->Cell(177, 5, utf8_decode("Reporte - Solicitud de registros fílmicos"), 0, 0, 'C');
        $pdf->SetTextColor(255, 255, 255);
        $pdf->Ln(10);
        $pdf->SetFont('Arial', 'B', 8);
        $pdf->Cell(2, 5, "", 0, 0, 'C', 0);
        $pdf->Cell(30, 5, utf8_decode("Ingreso"), 0, 0, 'C', true);
        $pdf->Cell(30, 5, "Solicitante", 0, 0, 'C', true);
        $pdf->Cell(30, 5, utf8_decode("Fecha grab."), 0, 0, 'C', true);
        $pdf->Cell(30, 5, utf8_decode("Rango horario"), 0, 0, 'C', true);
        $pdf->Cell(40, 5, utf8_decode("Adjunto"), 0, 0, 'C', true);
        $pdf->Cell(30, 5, utf8_decode("Respondido"), 0, 0, 'C', true);
        //$pdf->Cell(140,5,utf8_decode("Intervención"),0,0,'C', true);
        $pdf->Ln(6);
        $pdf->SetFont('Arial', '', 7);
        $pdf->SetTextColor(0, 0, 0);

        foreach ($files as $file) {
            $pdf->Cell(2, 4, "", 0, 0, 'C', 0);
            $pdf->Cell(30, 4, $file->datein, 'T', 0, 'C', 0);
            $pdf->Cell(30, 4, $file->init, 'T', 0, 'C', 0);
            $pdf->Cell(30, 4, $file->datefilm, 'T', 0, 'C', 0);
            $pdf->Cell(30, 4, $file->time, 'T', 0, 'C', 0);
            $pdf->Cell(40, 4, utf8_decode($file->attach), 'T', 0, 'C', 0);
            $pdf->Cell(30, 4, $file->dateout, 'T', 0, 'C', 0);
            $pdf->Ln(4);
        }

        $pdf->Output(Carbon::now()->timestamp . '.pdf', 'D');
        exit;
    }

    public function pdfConcejo(Request $request)
    {
        $request->validate([
            'dateinConcejo' => 'required',
            'dateoutConcejo' => 'required|after_or_equal:dateinConcejo',
        ]);

        $flaws = Flaw::whereBetween('dateFlaw', [$request->dateinConcejo, $request->dateoutConcejo])
            ->orderBy('dateFlaw', 'ASC')
            ->orderBy('timeFlaw', 'ASC')
            ->get();

        $interventions = Intervention::whereBetween('date', [$request->dateinConcejo, $request->dateoutConcejo])
            ->where('status', 1)
            ->orderBy('date', 'asc')
            ->orderBy('hour', 'asc')
            ->get();

        $cameras = Camera::where('published', 1)
            ->orderBy('name', 'ASC')
            ->get();

        $files = File::whereBetween('datein', [$request->dateinConcejo, $request->dateoutConcejo])
            ->orderBy('datein', 'ASC')
            ->get();

        $pdf = new PDF();
        // Creo fallas
        $pdf->AliasNbPages();
        $pdf->AddPage();
        $pdf->SetFont('Arial', 'BU', 10);
        $pdf->Cell(177, 5, utf8_decode("Desperfectos y fallas"), 0, 0, 'C');
        $pdf->SetTextColor(255, 255, 255);
        $pdf->Ln(10);
        $pdf->SetFont('Arial', 'B', 8);
        $pdf->Cell(7, 5, "", 0, 0, 'C', 0);
        $pdf->Cell(20, 5, utf8_decode("Día"), 0, 0, 'C', true);
        $pdf->Cell(10, 5, "Hora", 0, 0, 'C', true);
        $pdf->Cell(55, 5, utf8_decode("Cámara"), 0, 0, 'C', true);
        $pdf->Cell(55, 5, utf8_decode("Descripción"), 0, 0, 'C', true);
        $pdf->Cell(20, 5, utf8_decode("Día sol."), 0, 0, 'C', true);
        $pdf->Cell(20, 5, utf8_decode("Hora sol."), 0, 0, 'C', true);
        $pdf->Ln(6);
        $pdf->SetFont('Arial', '', 7);
        $pdf->SetTextColor(0, 0, 0);

        foreach ($flaws as $flaw) {
            $pdf->Cell(7, 4, "", 0, 0, 'C', 0);
            $pdf->Cell(20, 4, $flaw->dateflaw, 'T', 0, 'C', 0);
            $pdf->Cell(10, 4, $flaw->timeflaw, 'T', 0, 'C', 0);
            $pdf->Cell(55, 4, $flaw->Camera->name, 'T', 0, 'C', 0);
            $pdf->Cell(55, 4, utf8_decode($flaw->description), 'T', 0, 'C', 0);
            $pdf->Cell(20, 4, $flaw->datesolution, 'T', 0, 'C', 0);
            $pdf->Cell(20, 4, $flaw->timesolution, 'T', 0, 'C', 0);
            $pdf->Ln(4);
        }

        //Creo intervenciones
        $pdf->AddPage();
        $pdf->SetFont('Arial', 'BU', 10);
        $pdf->Cell(177, 5, utf8_decode("Intervenciones y solicitudes"), 0, 0, 'C');
        $pdf->SetTextColor(255, 255, 255);
        $pdf->Ln(10);
        $pdf->SetFont('Arial', 'B', 8);
        $pdf->Cell(7, 5, "", 0, 0, 'C', 0);
        $pdf->Cell(20, 5, "Fecha", 0, 0, 'C', true);
        $pdf->Cell(10, 5, "Hora", 0, 0, 'C', true);
        $pdf->Cell(140, 5, utf8_decode("Intervención"), 0, 0, 'C', true);
        $pdf->Ln(6);
        $pdf->SetFont('Arial', '', 7);
        $pdf->SetTextColor(0, 0, 0);
        foreach ($interventions as $intervention) {
            $pdf->Cell(7, 4, "", 0, 0, 'C', 0);
            $pdf->Cell(20, 4, $intervention->date, 'T', 0, 'C', 0);
            $pdf->Cell(10, 4, $intervention->hour, 'T', 0, 'C', 0);
            $pdf->MultiCell(140, 4, utf8_decode($intervention->detail), 'T', 'J', false);
            $pdf->Ln(1);
        }

        //Creo cámaras
        $pdf->AddPage();
        $pdf->SetFont('Arial', 'BU', 10);
        $pdf->Cell(177, 5, utf8_decode("Cámaras y su estado al día de la fecha"), 0, 0, 'C');
        $pdf->SetTextColor(255, 255, 255);
        $pdf->Ln(10);
        $pdf->SetFont('Arial', 'B', 8);
        $pdf->Cell(50, 5, "", 0, 0, 'C', 0);
        $pdf->Cell(40, 5, "Nombre", 0, 0, 'C', true);
        $pdf->Cell(40, 5, "Estado", 0, 0, 'C', true);
        $pdf->Ln(6);
        $pdf->SetFont('Arial', '', 7);
        $pdf->SetTextColor(0, 0, 0);
        foreach ($cameras as $camera) {
            $pdf->Cell(50, 4, "", 0, 0, 'C', 0);
            $pdf->Cell(40, 4, $camera->name, 'T', 0, 'C', 0);
            $pdf->Cell(40, 4, ($camera->status == 1 ? 'Funcionando' : 'Sin funcionar'), 'T', 0, 'C', 0);
            $pdf->Ln(4);
        }

        // Creo solicitudes de registros fílmicos
        $pdf->AddPage();
        $pdf->SetFont('Arial', 'BU', 10);
        $pdf->Cell(177, 5, utf8_decode("Reporte - Solicitud de registros fílmicos"), 0, 0, 'C');
        $pdf->SetTextColor(255, 255, 255);
        $pdf->Ln(10);
        $pdf->SetFont('Arial', 'B', 8);
        $pdf->Cell(2, 5, "", 0, 0, 'C', 0);
        $pdf->Cell(30, 5, utf8_decode("Ingreso"), 0, 0, 'C', true);
        $pdf->Cell(30, 5, "Solicitante", 0, 0, 'C', true);
        $pdf->Cell(30, 5, utf8_decode("Fecha grab."), 0, 0, 'C', true);
        $pdf->Cell(30, 5, utf8_decode("Rango horario"), 0, 0, 'C', true);
        $pdf->Cell(40, 5, utf8_decode("Adjunto"), 0, 0, 'C', true);
        $pdf->Cell(30, 5, utf8_decode("Respondido"), 0, 0, 'C', true);
        //$pdf->Cell(140,5,utf8_decode("Intervención"),0,0,'C', true);
        $pdf->Ln(6);
        $pdf->SetFont('Arial', '', 7);
        $pdf->SetTextColor(0, 0, 0);
        foreach ($files as $file) {
            $pdf->Cell(2, 4, "", 0, 0, 'C', 0);
            $pdf->Cell(30, 4, $file->datein, 'T', 0, 'C', 0);
            $pdf->Cell(30, 4, $file->init, 'T', 0, 'C', 0);
            $pdf->Cell(30, 4, $file->datefilm, 'T', 0, 'C', 0);
            $pdf->Cell(30, 4, $file->time, 'T', 0, 'C', 0);
            $pdf->Cell(40, 4, utf8_decode($file->attach), 'T', 0, 'C', 0);
            $pdf->Cell(30, 4, $file->dateout, 'T', 0, 'C', 0);
            $pdf->Ln(4);
        }

        $pdf->Output(Carbon::now()->timestamp . '.pdf', 'D');
        exit;
    }
}
