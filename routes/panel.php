<?php

use App\Http\Controllers\Mail\MailController;
use App\Http\Controllers\Panel\Administracion\AuditingController;
use App\Http\Controllers\Panel\Administracion\RoleController;
use App\Http\Controllers\Panel\Administracion\UserController;
use App\Http\Controllers\Panel\HomeController;
use App\Http\Controllers\Panel\Monitoreo\CameraController;
use App\Http\Controllers\Panel\Monitoreo\FileController;
use App\Http\Controllers\Panel\Monitoreo\FlawController;
use App\Http\Controllers\Panel\Monitoreo\InterventionController;
use App\Http\Controllers\Panel\Monitoreo\MapController;
use App\Http\Controllers\Panel\Monitoreo\ReportController;
use Illuminate\Support\Facades\Route;



Route::get('',[HomeController::class, 'index'])->middleware('can:panel.home')->name('panel.home');

//      --- MONITOREO ---

Route::get('reports/monitoreo', [ReportController::class, 'interventions'])->name('panel.reports.monitoreo');
Route::post('reports/monitoreo/interventions/pdf', [ReportController::class, 'pdfInterventions'])->name('panel.reports.monitoreo.interventions.pdf');
Route::get('monitoreo/cameras', [CameraController::class, 'index'])->name('panel.monitoreo.cameras.index');

Route::resource('monitoreo/interventions', InterventionController::class)->except('show')->names('panel.monitoreo.interventions');
Route::resource('monitoreo/files', FileController::class)->except('show')->names('panel.monitoreo.files');
Route::resource('monitoreo/flaws', FlawController::class)->except('show')->names('panel.monitoreo.flaws');

Route::get('monitoreo/maps/camaras', [MapController::class,'cameras'])->name('panel.monitoreo.maps.index');
Route::get('monitor', function () {
    return view('panel.monitoreo.maps.index2');
});


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
            