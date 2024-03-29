<?php

use App\Http\Controllers\API\DataCenter\EtherflowerController;
use App\Http\Controllers\API\DataCenter\MqttController;
use App\Http\Controllers\API\Monitoreo\CameraController;
use App\Http\Controllers\API\Monitoreo\FlawController;
use App\Http\Controllers\API\Monitoreo\RecordController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

//      --- MONITOREO / Fallas de cámaras ---

Route::get('monitoreo/fallas', [FlawController::class,'index']);
Route::post('monitoreo/fallas/down', [FlawController::class,'store']);
Route::post('monitoreo/fallas/up', [FlawController::class,'update']);

//      --- MONITOREO / Fallas de grabación de cámaras ---
Route::get('monitoreo/grabacion', [RecordController::class, 'index']);
Route::post('monitoreo/grabacion/down', [RecordController::class, 'store']);
Route::post('monitoreo/grabacion/up', [RecordController::class, 'update']);


Route::get('monitoreo/camaras', [CameraController::class,'index']);
Route::get('monitoreo/camaras/{status}', [CameraController::class,'index']);

Route::get('datacenter/temperatura', [EtherflowerController::class,'index']);
Route::get('datacenter/mqttdata/{topic}',[MqttController::class, 'presion']);