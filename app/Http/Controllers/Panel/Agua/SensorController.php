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
        // $interventionsLast = Intervention::wheredat('date', '', date('Y') - 1)
        //     ->where('status', '=', 1)
        //     ->select(DB::raw('count(*) as total'), DB::raw('MONTH(date) AS mes'))
        //     ->groupBy('mes')
        //     ->orderBy('mes', 'asc')
        //     ->get();
            
        $hora = Carbon::now();
        $mqttdata = MqttData::where('topic_id', 'like', '%pm01sr01%')
                        // ->whereBetween('created_at', array($hora->format('Y-m-d H:i:s'),$hora->subHours(12)->format('Y-m-d H:i:s')))
                        ->get();
            return $mqttdata;
        return view('panel.agua.sensors.index');
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
