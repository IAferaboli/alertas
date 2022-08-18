<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Models\Camera;
use App\Models\Flaw;
use App\Models\Intervention;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function index()
    {

        getCameras();

        //Cantidad de cámaras en el sistema Monitoreo
        $cantCamaras = Camera::where(function ($q) {
            $q->where('type', '0')
                ->orWhere('type', '1');
        })->count();
        $fueraDeServicio = Camera::where('status', 0)
            ->where(function ($q) {
                $q->where('type', '0')
                    ->orWhere('type', '1');
            })
            ->count();
        $mantenimiento = Camera::where(function ($q) {
            $q->where('type', '0')
                ->orWhere('type', '1');
        })
            ->where('maintenance', 1)
            ->count();
        $sinGrabar = Camera::where(function ($q) {
            $q->where('type', '0')
                ->orWhere('type', '1');
        })
            ->where('recording', 0)
            ->count();
        $desactivadas = Camera::where(function ($q) {
            $q->where('type', '0')
                ->orWhere('type', '1');
        })
            ->where('active', 0)
            ->count();

        //API CLIMA
        try {
            $weather = Http::get("https://api.openweathermap.org/data/2.5/weather?id=3832778&appid=" . env('OPENWEATHER_API') . "")->json();
            if ($weather) {
                foreach ($weather['weather'] as $key => $value) {
                    $weather['icono'] = $value['icon'];
                    $weather['clima'] = $value['main'];
                }

                switch ($weather['clima']) {
                    case "Clouds":
                        $weather['clima'] = "Nublado";
                        break;
                    case "Rain":
                        $weather['clima'] = "Lluvioso";
                        break;
                    case "Clear":
                        $weather['clima'] = "Despejado";
                        break;
                }
            }
        } catch (\Throwable $th) {
            //throw $th;
        }

        // Gráfico de Intervenciones
        $interventions = Intervention::whereYear('date', '>=', date('Y'))
            ->where('status', '=', 1)
            ->select(DB::raw('count(*) as total'), DB::raw('MONTH(date) AS mes'))
            ->groupBy('mes')
            ->orderBy('mes', 'asc')
            ->get();

        $monthCount = [];
        foreach ($interventions as $count) {
            $monthCount[] = $count->total;
        }

        $interventionsLast = Intervention::whereYear('date', '=', date('Y') - 1)
            ->where('status', '=', 1)
            ->select(DB::raw('count(*) as total'), DB::raw('MONTH(date) AS mes'))
            ->groupBy('mes')
            ->orderBy('mes', 'asc')
            ->get();

        $monthCountLast = [];
        foreach ($interventionsLast as $count) {
            $monthCountLast[] = $count->total;
        }


        $interventionsProm = Intervention::select(DB::raw('count(*) as total'), DB::raw('MONTH(date) AS mes'))
            ->where('status', '=', 1)
            ->groupBy('mes')
            ->orderBy('mes', 'asc')
            ->get();

        // Calcular cantidad de años almacenados
        $years = Intervention::select(DB::raw('YEAR(date) AS year'))
            ->groupBy('year')
            ->orderBy('year', 'asc')
            ->get();

        //Contar registros de years
        $yearsCount = count($years);

        $monthCountProm = [];
        foreach ($interventionsProm as $count) {
            $monthCountProm[] = ($count->total) / $yearsCount;
        }


        //SNMP Temperatura Servers
        $tempServer = getTemperatureDC();

        $flaws = Flaw::select(DB::raw('DayName(dateflaw) AS day'), DB::raw('count(*) AS total'))
            ->groupBy('day')
            ->get();

        $fallasPorDia = [];
        foreach ($flaws as $count) {
            $fallasPorDia[] = $count->total;
        }

        return view('panel.index', compact('desactivadas', 'mantenimiento', 'sinGrabar', 'monthCount', 'monthCountLast', 'weather', 'tempServer', 'cantCamaras', 'fueraDeServicio', 'monthCountProm', 'fallasPorDia'));
    }
}
