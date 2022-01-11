<?php

namespace App\Http\Controllers\API\Monitoreo;

use App\Http\Controllers\Controller;
use App\Http\Requests\Monitoreo\FlawRequest;
use App\Models\Camera;
use App\Models\Flaw;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FlawController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($name = null)
    {

            // return Flaw::where('datesolution', null)->get();
            return Flaw::all();
            // return Flaw::where('camera_id', ($camera->id))
            //     ->where('datesolution', NULL)
            //     ->count();
   
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(FlawRequest $request)
    {
        $array = $request->getContent();
        
        // $jsonCamera = json_encode($bodyContent);

        //parse request ini to json
        // $jsonCamera = json_decode($array, true);
        $contenido = parse_ini_string($array, true);
        
        // file_put_contents('filename.txt', print_r($jsonCamera, true));
        // $file = 'clientes.json';
        // file_put_contents($file, $input);

        return $contenido;
        // return response()->json([
        //     'res' => true,
        //     'msg' => 'JSON',
            
        // ]);
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
