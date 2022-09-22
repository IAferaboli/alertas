<?php

namespace App\Http\Livewire\Panel\Tv;

use GuzzleHttp\Client;
use Livewire\Component;

class SensorsIndex extends Component
{
    public $downIs, $upIs, $downFiberMuni, $upFiberMuni;

    public function mount()
    {
        $client = new Client();
        try {

            $response = $client->post('http://monitoreo.intranet.villaconstitucion.gob.ar/zabbix/api_jsonrpc.php', [
                'json' => [
                   'jsonrpc' => '2.0',
                   'method' => 'history.get',
                   'params' => [
                        'output' => 'extend',
                        'history' => 0,
                        'itemids' => ['23673','28306'],
                        'sortfield' => 'clock',
                        'sortorder' => 'DESC',
                        'limit' => 2,
                   ],
                   'auth' => env('TOKEN_ZABBIX'),
                   'id' => 1
                 ]
            ]);
            $data = json_decode($response->getBody());

            $this->downIs = round($data->result[0]->value/1000000, 2);
            $this->upIs = round($data->result[1]->value/1000000, 2);
        } catch (\Throwable $th) {
            $this->downIs = "Err";
            $this->upIs = "Err";
        }

        try {
            $response = $client->post('http://monitoreo.intranet.villaconstitucion.gob.ar/zabbix/api_jsonrpc.php', [
                'json' => [
                   'jsonrpc' => '2.0',
                   'method' => 'history.get',
                   'params' => [
                        'output' => 'extend',
                        'history' => 3,
                        'itemids' => ['28304','28305'],
                        'sortfield' => 'clock',
                        'sortorder' => 'DESC',
                        'limit' => 2,
                   ],
                   'auth' => env('TOKEN_ZABBIX'),
                   'id' => 1
                 ]
            ]);
            $data = json_decode($response->getBody());
            $this->downFiberMuni = round($data->result[1]->value/1000000, 2);
            $this->upFiberMuni = round($data->result[0]->value/1000000, 2);
        } catch (\Throwable $th) {
            $this->downFiberMuni = "Err";
            $this->upFiberMuni = "Err";
        }

    }

    public function render()
    {
        return view('livewire.panel.tv.sensors-index');
    }

    public function internetServices()
    {
        $client = new Client();

        //Internet Services
        try {
            $response = $client->post('http://monitoreo.intranet.villaconstitucion.gob.ar/zabbix/api_jsonrpc.php', [
                'json' => [
                   'jsonrpc' => '2.0',
                   'method' => 'history.get',
                   'params' => [
                        'output' => 'extend',
                        'history' => 0,
                        'itemids' => ['23673','28306'],
                        'sortfield' => 'clock',
                        'sortorder' => 'DESC',
                        'limit' => 2,
                   ],
                   'auth' => env('TOKEN_ZABBIX'),
                   'id' => 1
                 ]
            ]);

            $data = json_decode($response->getBody());
            $this->downIs = round($data->result[0]->value/1000000, 2);
            $this->upIs = round($data->result[1]->value/1000000, 2);
        } catch (\Throwable $th) {
            $this->downIs = "Err";
            $this->upIs = "Err";
        }


    }

    public function fibercorpMuni()
    {
        $client = new Client();
        try {
            $response = $client->post('http://monitoreo.intranet.villaconstitucion.gob.ar/zabbix/api_jsonrpc.php', [
                'json' => [
                   'jsonrpc' => '2.0',
                   'method' => 'history.get',
                   'params' => [
                        'output' => 'extend',
                        'history' => 3,
                        'itemids' => ['28304','28305'],
                        'sortfield' => 'clock',
                        'sortorder' => 'DESC',
                        'limit' => 2,
                   ],
                   'auth' => env('TOKEN_ZABBIX'),
                   'id' => 1
                 ]
            ]);
            $data = json_decode($response->getBody());
            $this->downFiberMuni = round($data->result[1]->value/1000000, 2);
            $this->upFiberMuni = round($data->result[0]->value/1000000, 2);
        } catch (\Throwable $th) {
            $this->downFiberMuni = "Err";
            $this->upFiberMuni = "Err";
        }
    }
}
