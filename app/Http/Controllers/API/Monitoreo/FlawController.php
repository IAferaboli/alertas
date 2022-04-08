<?php

namespace App\Http\Controllers\API\Monitoreo;

use App\Http\Controllers\Controller;
use App\Models\Camera;
use App\Models\Flaw;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Notifications\Notifiable;
use App\Notifications\TelegramNotification;

class FlawController extends Controller
{

    public function index($name = null)
    {
        return Flaw::latest()
            ->take(50)
            ->get();
    }

    public function store(Request $request)
    {
        $request = parse_ini_string($request, true);

        $fecha = new DateTime();
        $fecha->modify('-2 minute');
        $camera = Camera::where('name', $request['name'])->first();
        unset($request['name']);
        $request['dateflaw'] = $fecha->format('Y-m-d');
        $request['timeflaw'] = $fecha->format('H:i:s');
        $request['description'] = "Fuera de servicio";
        $request['camera_id'] = $camera->id;
        $request['datesolution'] = null;
        $request['timesolution'] = null;


        try {

            $flaw = Flaw::create($request);

            try {
                Arr::add($flaw, 'to',  env('TELEGRAM_ROTNIC'));
                Arr::add($flaw, 'content',  "*_echa: *" . $request['dateflaw'] . "\n*Hora: *" . $request['timeflaw'] . " \n*Cámara: * " . $camera->name . "\n*Estado: *" . $request['description']);

                $flaw->notify(new TelegramNotification);

                return response()->json([
                    'res' => $request,
                    'msg' => 'OK',
                ]);
            } catch (\Throwable $th) {
                return response()->json([
                    'res' => $request,
                    'msg' => 'Falla añadida - Error Telegram',
                ]);
            }

            
        } catch (\Throwable $th) {
            return response()->json([
                'msg' => 'Error al añadir falla',
            ]);
        }
    }


    public function show($id)
    {
    }

    public function update(Request $request, Flaw $flaw)
    {
        $request = parse_ini_string($request, true);

        $fecha = new DateTime();
        $camera = Camera::where('name', $request['name'])->first();
        unset($request['name']);

        $flaw = Flaw::where('camera_id', $camera->id)
            ->where('timesolution', null)
            ->first();

        $request['datesolution'] = $fecha->format('Y-m-d');
        $request['timesolution'] = $fecha->format('H:i:s');

        try {
            $flaw->update($request);

            try {
                Arr::add($flaw, 'to',  env('TELEGRAM_ROTNIC'));
                Arr::add($flaw, 'content',  "*Fecha:* " . $request['datesolution'] . " \n*Hora:* " . $request['timesolution'] . " \n*Cámara: * " . $camera->name . "\n*Estado: * Cámara restablecida");
                $flaw->notify(new TelegramNotification);

                return response()->json([
                    'res' => $request,
                    'msg' => 'OK',
                ]);
            } catch (\Throwable $th) {
                return response()->json([
                    'res' => $request,
                    'msg' => 'Falla añadida - Error Telegram',
                ]);
            }
        } catch (\Throwable $th) {
            return response()->json([
                'msg' => 'Error al añadir falla',
            ]);
        }
    }


    public function destroy($id)
    {
        //
    }
}
