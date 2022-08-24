<?php

namespace App\Http\Controllers\API\DataCenter;

use App\Http\Controllers\Controller;
use App\Models\MqttData;
use Illuminate\Http\Request;

class MqttController extends Controller
{

    public function presion($topic)
    {
        $presion = MqttData::where('topic_id', 'like', '%' . $topic . '%')->orderBy('id', 'desc')->first();
        $presion = json_decode($presion->message, true);
        $presion['values']['Presion'] = round($presion['values']['Presion']/10, 2);

        return $presion;
    }
}
