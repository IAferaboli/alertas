<?php

namespace App\Mail\Panel\Monitoreo;

use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class InterventionsMailable extends Mailable
{
    use Queueable, SerializesModels;

    public $interventions;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($interventions)
    {
        $this->interventions = $interventions;    
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $date = new Carbon('now');
	    $date = $date->format('d/m/Y');
        return $this->subject("Parte diario del día $date - Monitoreo")->view('emails.monitoreo.interventions', compact('date'));
    }
}
