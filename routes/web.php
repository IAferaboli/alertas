<?php

use App\Http\Controllers\Mail\MailController;
use App\Http\Controllers\Panel\HomeController;
use App\Http\Controllers\Panel\Monitoreo\ReportController;
use App\Models\Intervention;
use App\Models\MqttData;
use App\Models\MqttDevice;
use App\Models\Notification;
use App\Notifications\TelegramPrueba;
use Carbon\Carbon;
use Illuminate\Support\Facades\Route;


Route::middleware(['auth:sanctum', 'verified'])->get('/', [HomeController::class,'index'])->name('dashboard');

//Envio email con intervenciones - CRON todos los días 23:59hs.
Route::get('email-monitoreo-intervencion', [MailController::class, 'interventionsMonitoreo']);

Route::get('reporte', [ReportController::class, 'pdfInterventions'])->name('reporte');

//Envio alerta (telegram y monitoreo) por temperatura alta de datacenter
Route::get('telegram-dc-temperatura', function () {
	
	$tempServer = getTemperatureDC();

	$notification = new Notification;
	$notification->setContent("*Temperatura del DC*: ".$tempServer/10);
	$notification->setTo(env('TELEGRAM_DATACENTER'));
	$message = "La temperatura de los servidores (". $tempServer/10 ."ºC) es elevada, por favor dar conocimiento INMEDIATO a su superior.";

	if ($tempServer >= 260) {
		$notification->notify(new TelegramPrueba);
		sendMessageToMonitoreo($message);
	}
	
});

//Recorro cámaras por si alguna no reportó
Route::get('recorro-camaras-digifort', function () {
	
});

Route::get('telegram-agua-presion', function () {

	$notification = new Notification;
	$mqttDevices = MqttDevice::all();
	foreach ($mqttDevices as $mqttDevice) {
		$pressure = getPressureWater($mqttDevice->topic);
		if($pressure['values']['Presion'] <= 0.6 || $pressure['values']['Presion'] >= 2.5){
			$notification->setContent("⚠ *ALERTA DE PRESIÓN* ⚠ \n\n*Sensor:* $mqttDevice->nombre \n*Presión:* ".$pressure['values']['Presion']);
			$notification->setTo(env('TELEGRAM_AGUA_PRESION'));
			$notification->notify(new TelegramPrueba);
		}
	}
	
});
