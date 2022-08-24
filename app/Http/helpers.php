<?php

use App\Models\Camera;
use App\Models\MqttData;
use Illuminate\Support\Facades\Http;
use Ndum\Laravel\Snmp;


function cantCameras()
{

    $count = 0;
    for ($i = 1; $i <= 3; $i++) {
        try {
            $xmlServer = simplexml_load_file("http://192.168.100.$i:8601/Interface/Cameras/GetCameras?Fields=Count&ResponseFormat=XML&AuthUser=admin&AuthPass=gda.adm");
            foreach ($xmlServer->Data->Cameras as $Cameras) {
                $count += $Cameras->Count;
            }
        } catch (\Throwable $th) {
            //throw $th;
        }
    }
    return $count;
}

function getLicenses()
{

    $total = 0;
    for ($i = 1; $i <= 3; $i++) {
        try {
            $xmlServer = simplexml_load_file("http://192.168.100.$i:8601/Interface/Server/GetLicenses?ResponseFormat=XML&AuthUser=admin&AuthPass=gda.adm");
            foreach ($xmlServer->Data->Summary->License as $License) {
                $total += $License->TotalObjects - $License->UsedObjects;
            }
        } catch (\Throwable $th) {
            //throw $th;
        }
    }

    return $total;
}

function statusCameras($type)
{

    $desactivedCount = 0;
    $outOfService = 0;
    for ($i = 1; $i <= 3; $i++) {
        try {
            
            $xmlServer = simplexml_load_file("http://192.168.100.$i:8601/Interface/Cameras/GetStatus?&Fields=Working,Active&ResponseFormat=XML&AuthUser=admin&AuthPass=gda.adm");
            foreach ($xmlServer->Data->Cameras->Camera as $Camera) {
                $active = $Camera->Active;
                if ($active == "FALSE") {
                    $desactivedCount++;
                }
                $working = $Camera->Working;
                if ($working == "FALSE") {
                    $outOfService++;
                }
            }
        } catch (\Throwable $th) {
            
        }
    }

    if ($type == "ACTIVE") {
        return $desactivedCount;
    } else {
        return $outOfService;
    }
}


function timeServer($server = null)
{
    try {
        $xmlServer = simplexml_load_file("http://192.168.100.$server:8601/Interface/Server/GetInfo?ResponseFormat=XML&AuthUser=admin&AuthPass=gda.adm");

        $time = $xmlServer->Data->Info->UpTime;

        return secondsToTime($time);
    } catch (\Throwable $th) {
        //throw $th;
        return "No hay datos";
    }

}


function secondsToTime($seconds)
{
    $dtF = new \DateTime('@0');
    $dtT = new \DateTime("@$seconds");
    return $dtF->diff($dtT)->format('%a d. - %h hs. - %i min.');
}

function listCameras($server)
{
    try {
        $responses = Http::get("http://192.168.100.$server:8601/Interface/Cameras/GetStatus?ResponseFormat=json&AuthUser=admin&AuthPass=gda.adm")->json();
        return $responses;
    } catch (\Throwable $th) {
    
    }
}


function getCameras()
{


    for ($i = 1; $i <= 3; $i++) {
        try {
            $responses = Http::get("http://192.168.100.$i:8601/Interface/Cameras/GetCameras?Fields=Name,%20Latitude,%20Longitude,%20ConnectionAddress,%20Description&ResponseFormat=JSON&AuthUser=admin&AuthPass=gda.adm")->json();

            foreach ($responses['Response']['Data']['Cameras'] as $response) {

                $camera = Camera::where('name', $response['Name'])->first();

                $responses2 = Http::get("http://192.168.100.$i:8601/Interface/Cameras/GetStatus?Cameras=" . $response['Name'] . "&ResponseFormat=JSON&AuthUser=admin&AuthPass=gda.adm")->json();
                $type = 0;
                if (Str::contains($response['Name'], 'Domo')) {
                    $type = 0;
                } else {
                    $type = 1;
                }

                foreach ($responses2['Response']['Data']['Cameras'] as $response2) {
                    if ($camera) {
                        if ($camera->lat != $response['Latitude'] || $camera->lng != $response['Longitude']  || $camera->status != $response2['Working'] || $camera->addressip != $response['ConnectionAddress'] || $camera->description != $response['Description'] || $camera->active != $response2['Active'] || $camera->recording != $response2['WrittingToDisk']) {
                            $camera->update([
                                'lat' => $response['Latitude'],
                                'lng' => $response['Longitude'],
                                'status' => $response2['Working'],
                                'active' => $response2['Active'],
                                'recording' => $response2['WrittingToDisk'],
                                'server' => $i,
                                'addressip' => $response['ConnectionAddress'],
                                'description' => $response['Description'],
                            ]);
                        }
                    } else {
                        Camera::create([
                            'name' => $response['Name'],
                            'lat' => $response['Latitude'],
                            'lng' => $response['Longitude'],
                            'status' => $response2['Working'],
                            'active' => $response2['Active'],
                            'recording' => $response2['WrittingToDisk'],
                            'server' => $i,
                            'type' => $type,
                            'addressip' => $response['ConnectionAddress'],
                            'description' => $response['Description'],
                        ]);
                    }
                }
            }
        } catch (\Throwable $th) {
            // throw $th;
        }
    }
}

function getTemperatureDC(){

    $snmp = new Snmp();

    try {
        $snmp->newClient(env('IP_TEMP_SERVER'), 2, 'mvc');
        $tempServer = $snmp->getValue(env('OID_TEMP_SERVER'));
    } catch (\Throwable $th) {
        $tempServer = 0;
    }
    
    return $tempServer;

}

function getPressureWater($topic_id){
    $pressure = MqttData::where('topic_id', 'like', '%'.$topic_id.'%')
                            ->orderBy('id', 'desc')
                            ->first();
    $pressure = json_decode($pressure->message, true);
    $pressure['values']['Presion'] = round($pressure['values']['Presion']/10, 2);

    return $pressure;
}

function sendMessageToMonitoreo($message){
    $responses = Http::get("http://192.168.100.1:8601/Interface/GlobalEvents/TriggerGlobalEvent?Event=Smart%20VC&OverrideOperatorMessage=$message&ResponseFormat=JSON&AuthUser=".env('DIGIFORT_USER')."&AuthPass=".env('DIGIFORT_PASSWORD'))->json();
    return $responses;
}


function comprueboEstadoCamaras($time){

    for ($i=1; $i <= 3; $i++) { 
        try {
            $responses = Http::get("http://192.168.100.$i:8601/Interface/Cameras/GetStatus?&ResponseFormat=json&AuthUser=".env('DIGIFORT_USER')."&AuthPass=".env('DIGIFORT_PASSWORD'))->json();

            if ($responses) {
                
                foreach ($responses['Response']['Data']['Cameras'] as $camera) {
                    # code...
                }
                
            }

        } catch (\Throwable $th) {
            //throw $th;
        }
    }
}