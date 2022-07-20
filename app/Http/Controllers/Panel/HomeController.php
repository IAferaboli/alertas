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

        //Tiempo actividad servidores
        list($serv1, $serv2, $serv3) = timeServer();

        //Cantidad de cámaras en el sistema Monitoreo
        $cantCamaras = Camera::where('type', 0)->orWhere('type', 1)->count();
        $fueraDeServicio = Camera::where('status', 0)
            ->where('published', 1)
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
            $monthCountProm[] = ($count->total)/$yearsCount;
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
        
        return view('panel.index', compact('serv1', 'serv2', 'serv3', 'monthCount', 'monthCountLast', 'weather', 'tempServer', 'cantCamaras', 'fueraDeServicio', 'monthCountProm', 'fallasPorDia'));
    }
}
