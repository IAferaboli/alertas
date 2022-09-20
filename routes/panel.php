<?php

use App\Http\Controllers\Mail\MailController;
use App\Http\Controllers\Panel\Administracion\AuditingController;
use App\Http\Controllers\Panel\Administracion\RoleController;
use App\Http\Controllers\Panel\Administracion\UserController;
use App\Http\Controllers\Panel\Agua\SensorController;
use App\Http\Controllers\Panel\HomeController;
use App\Http\Controllers\Panel\Monitoreo\CameraController;
use App\Http\Controllers\Panel\Monitoreo\FileController;
use App\Http\Controllers\Panel\Monitoreo\FlawController;
use App\Http\Controllers\Panel\Monitoreo\InterventionController;
use App\Http\Controllers\Panel\Monitoreo\MapController;
use App\Http\Controllers\Panel\Monitoreo\ReportController;
use App\Http\Controllers\Panel\TV\TvController;
use Illuminate\Support\Facades\Route;



Route::get('',[HomeController::class, 'index'])->middleware('can:panel.home')->name('panel.home');

//      --- MONITOREO ---

Route::get('reports/monitoreo', [ReportController::class, 'index'])->name('panel.reports.monitoreo');
Route::post('reports/monitoreo/interventions/pdf', [ReportController::class, 'pdfInterventions'])->name('panel.reports.monitoreo.interventions.pdf');
Route::post('reports/monitoreo/flaws/pdf', [ReportController::class, 'pdfFlaws'])->name('panel.reports.monitoreo.flaws.pdf');
Route::post('reports/monitoreo/files/pdf', [ReportController::class, 'pdfFiles'])->name('panel.reports.monitoreo.files.pdf');
Route::post('reports/monitoreo/concejo/pdf', [ReportController::class, 'pdfConcejo'])->name('panel.reports.monitoreo.concejo.pdf');

Route::resource('monitoreo/interventions', InterventionController::class)->except('show')->names('panel.monitoreo.interventions');
Route::resource('monitoreo/files', FileController::class)->except('show')->names('panel.monitoreo.files');
Route::resource('monitoreo/flaws', FlawController::class)->except('show')->names('panel.monitoreo.flaws');
Route::resource('monitoreo/cameras', CameraController::class)->names('panel.monitoreo.cameras');

Route::get('monitoreo/maps/camaras', [MapController::class,'cameras'])->name('panel.monitoreo.maps.index');

//      --- TV ---
Route::get('tv/map', [TvController::class,'map'])->name('panel.tv.map');
Route::get('tv/sensors', [TvController::class,'sensor'])->name('panel.tv.sensors');



//      --- AGUA ---
Route::resource('agua/sensors', SensorController::class)->names('panel.agua.sensors');

//      --- ADMINISTRACIÓN ---

Route::resource('administracion/users', UserController::class)->except('show')->names('panel.administracion.users');
Route::resource('administracion/roles', RoleController::class)->except('show')->names('panel.administracion.roles');
Route::get('administracion/auditing', [AuditingController::class, 'index'])->name('panel.administracion.auditing.index');

// Notification::route('telegram', '831187074')->notify(new TelegramPrueba);

//      --- CUENTA ---
Route::get('myaccount', function () {
    return view('panel.account.profile');
})->name('panel.myaccount');


//      --- EMAILS ---

Route::get('mail/intervencion', [MailController::class, 'interventionsMonitoreo'] );