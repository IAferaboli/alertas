<?php

namespace App\Http\Controllers\API\Monitoreo;

use App\Http\Controllers\Controller;
use App\Http\Requests\Monitoreo\FlawRequest;
use App\Models\Flaw;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class DownCameraController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(FlawRequest $request)
    {
        Log::info('Request');

        // if (request()->isXml()) {
        //     $data = request()->xml();
        //     // Flaw::create($data);
        //     file_put_contents('filename.txt', print_r($data, true));
        //     return response()->json([
        //         'res' => true,
        //         'msg' => "escrito",
        //     ]);
        // } else {

            $bodyContent = $request->getContent();
            $input = file_get_contents('php://input');
            // $jsonCamera = json_encode($bodyContent);
            $contenido = parse_ini_string($bodyContent, true);
            // $array_limitado = explode('=', $bodyContent);
            file_put_contents('filename.txt', print_r($contenido, true));
            // $file = 'clientes.json';
            // file_put_contents($file, $input);


            return response()->json([
                'res' => true,
                'msg' => 'JSON',
            ]);
        // }



        // $request->request->add([
        //     'dateflaw' => ,
        //     'timeflaw' => 'value',
        //     'description' => 'Fuera de servicio'

        // ]); //add request

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
