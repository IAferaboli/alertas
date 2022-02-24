<?php

use App\Models\Camera;
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


function timeServer()
{
    try {
        $xmlServer1 = simplexml_load_file("http://192.168.100.1:8601/Interface/Server/GetInfo?ResponseFormat=XML&AuthUser=admin&AuthPass=gda.adm");
        $xmlServer2 = simplexml_load_file("http://192.168.100.2:8601/Interface/Server/GetInfo?ResponseFormat=XML&AuthUser=admin&AuthPass=gda.adm");
        $xmlServer3 = simplexml_load_file("http://192.168.100.3:8601/Interface/Server/GetInfo?ResponseFormat=XML&AuthUser=admin&AuthPass=gda.adm");

        $time1 = $xmlServer1->Data->Info->UpTime;
        $time2 = $xmlServer2->Data->Info->UpTime;
        $time3 = $xmlServer3->Data->Info->UpTime;

        return array(secondsToTime($time1), secondsToTime($time2), secondsToTime($time3));
    } catch (\Throwable $th) {
        //throw $th;
        return array("No hay datos", "No hay datos", "No hay datos");
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
            $responses = Http::get("http://192.168.100.$i:8601/Interface/Cameras/GetCameras?Fields=Name,%20Latitude,%20Longitude&ResponseFormat=JSON&AuthUser=admin&AuthPass=gda.adm")->json();

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
                        if ($camera->lat != $response['Latitude'] || $camera->lng != $response['Longitude']  || $camera->status != $response2['Working']) {
                            $camera->update([
                                'lat' => $response['Latitude'],
                                'lng' => $response['Longitude'],
                                'status' => $response2['Working'],
                                'server' => $i,
                            ]);
                        }
                    } else {
                        Camera::create([
                            'name' => $response['Name'],
                            'lat' => $response['Latitude'],
                            'lng' => $response['Longitude'],
                            'status' => $response2['Working'],
                            'server' => $i,
                            'type' => $type

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
    $snmp->newClient(env('IP_TEMP_SERVER'), 2, 'mvc');
    $tempServer = $snmp->getValue(env('OID_TEMP_SERVER'));

    return $tempServer;
}

function sendMessageToMonitoreo($message){

    $responses = Http::get("http://192.168.100.1:8601/Interface/GlobalEvents/TriggerGlobalEvent?Event=Smart%20VC&OverrideOperatorMessage=$message&ResponseFormat=JSON&AuthUser=".env('DIGIFORT_USER')."&AuthPass=".env('DIGIFORT_PASSWORD'))->json();
    return $responses;

}
