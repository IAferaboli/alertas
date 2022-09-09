<?php

namespace App\Http\Controllers\Panel\Agua;

use App\Http\Controllers\Controller;
use App\Models\Intervention;
use App\Models\MqttData;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SensorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $mqttdata = MqttData::where('topic_id', 'like', '%pm01sr01%')
            ->whereBetween('created_at', [Carbon::now()->subHours(24)->format('Y-m-d H:i:s'), Carbon::now()->format('Y-m-d H:i:s')])
            ->get(['message', 'created_at']);

        foreach ($mqttdata as $data) {
            $label[] = $data->created_at->format('H:i');
            $presion[] = round(json_decode($data->message, true)['values']['Presion'] / 10, 2);
        }

        $dataSensor = MqttData::where('topic_id', 'like', '%pm01sr01%')
            ->orderBy('id', 'desc')
            ->first();
        $pm01sr01 = json_decode($dataSensor->message, true);
        $pm01sr01['values']['Presion'] = round($pm01sr01['values']['Presion'] / 10, 2);

        return view('panel.agua.sensors.index', compact('label', 'presion', 'pm01sr01', 'dataSensor'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
