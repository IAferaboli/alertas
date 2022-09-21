<?php

namespace App\Http\Livewire\Panel\Tv;

use GuzzleHttp\Client;
use Livewire\Component;

class SensorsIndex extends Component
{
    public $downIs, $upIs;

    public function mount()
    {
        $client = new Client();
        $response = $client->post('http://monitoreo.intranet.villaconstitucion.gob.ar/zabbix/api_jsonrpc.php', [
            'json' => [
               'jsonrpc' => '2.0',
               'method' => 'history.get',
               'params' => [
                    'output' => 'extend',
                    'history' => 0,
                    'hostids' => '10105',
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
    }

    public function render()
    {
        return view('livewire.panel.tv.sensors-index');
    }

    public function internetServices()
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
                        'hostids' => '10105',
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
            $this->downIs = "No calcula";
            $this->upIs = "No calcula";
        }
        

        
    }
}
