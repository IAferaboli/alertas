<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Models\Intervention;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function index()
    {

        //Tiempo actividad servidores
        list($serv1, $serv2, $serv3) = timeServer();


        //API CLIMA
        try {
            $weather = Http::get("https://api.openweathermap.org/data/2.5/weather?id=3832778&appid=".env('OPENWEATHER_API')."")->json();
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

            ->select(DB::raw('count(*) as total'), DB::raw('MONTH(date) AS mes'))
            ->groupBy('mes')
            ->orderBy('mes', 'asc')
            ->get();

        $monthCount = [];
        foreach ($interventions as $count) {
            $monthCount[] = $count->total;
        }

        $interventionsLast = Intervention::whereYear('date', '=', date('Y') - 1)

            ->select(DB::raw('count(*) as total'), DB::raw('MONTH(date) AS mes'))
            ->groupBy('mes')
            ->orderBy('mes', 'asc')
            ->get();

        $monthCountLast = [];
        foreach ($interventionsLast as $count) {
            $monthCountLast[] = $count->total;
        }

        //SNMP Temperatura Servers
        $tempServer = getTemperatureDC();

        return view('panel.index', compact('serv1', 'serv2', 'serv3', 'monthCount', 'monthCountLast', 'weather', 'tempServer'));

    }
}
