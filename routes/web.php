<?php

use App\Http\Controllers\Panel\HomeController;
use App\Http\Controllers\Panel\Monitoreo\ReportController;
use App\Models\Intervention;
use Carbon\Carbon;
use Illuminate\Support\Facades\Route;




Route::middleware(['auth:sanctum', 'verified'])->get('/', [HomeController::class,'index'])->name('dashboard');

Route::get('/email-monitoreo-intervencion', function()
{
	$date = new Carbon('now');
	$date = $date->format('Y-m-d');
	$interventions = Intervention::where('date', $date)->get();
	$beautymail = app()->make(Snowfire\Beautymail\Beautymail::class);
	$beautymail->send('emails.welcome', compact('interventions','date'), function($message)
	{
		$date = new Carbon('now');
		$date = $date->format('d/m/Y');
		$message
			// ->from('bar@example.com')
			->to(['emonitoreo@villaconstitucion.gov.ar'])
			->bcc(['mjaime@villaconstitucion.gov.ar','alongo@villaconstitucion.gov.ar','rbianco@villaconstitucion.gov.ar','pflores@villaconstitucion.gov.ar','jorgerberti@gmail.com'])
			->subject("Parte diario del día $date - Monitoreo");
	});

});

Route::get('reporte', [ReportController::class, 'pdfInterventions'])->name('reporte');