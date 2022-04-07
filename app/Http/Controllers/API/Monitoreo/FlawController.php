<?php

namespace App\Http\Controllers\API\Monitoreo;

use App\Http\Controllers\Controller;
use App\Http\Requests\Monitoreo\FlawRequest;
use App\Models\Camera;
use App\Models\Flaw;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
            Flaw::create($request);

            return response()->json([
                'res' => $request,
                'msg' => 'OK',
            ]);
            
        } catch (\Throwable $th) {
            return response()->json([
                'msg' => 'ERROR',
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
            return response()->json([
                'res' => $request,
                'msg' => 'JSON',
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'msg' => 'Error',
            ]);
        }
    }


    public function destroy($id)
    {
        //
    }
}
