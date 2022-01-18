<?php

use App\Http\Controllers\Panel\HomeController;
use App\Models\Intervention;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

/*Route::get('/', function () {
    return view('welcome');
    //Mail::to("rotilinicolas@gmail.com")->send(new TestMail("NIco"));
});*/

Route::middleware(['auth:sanctum', 'verified'])->get('/', [HomeController::class,'index'])->name('dashboard');


Route::get('/test', function()
{
	$date = new Carbon('now');
	$date = $date->format('Y-m-d');
	$interventions = Intervention::where('date', $date)->get();
	$beautymail = app()->make(Snowfire\Beautymail\Beautymail::class);
	$beautymail->send('emails.welcome', compact('interventions','date'), function($message)
	{
		
		$message
			// ->from('bar@example.com')
			->to(['rotilinicolas@gmail.com','niko.tetrikoo@gmail.com'])
			->subject("Parte diario del día $this->date - Monitoreo");
	});

});

