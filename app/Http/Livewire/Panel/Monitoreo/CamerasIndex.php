<?php

namespace App\Http\Livewire\Panel\Monitoreo;

use App\Models\Camera;
use App\Models\Flaw;
use App\Notifications\TelegramNotification;
use DateTime;
use Illuminate\Support\Arr;
use Livewire\Component;
use Livewire\WithPagination;

class CamerasIndex extends Component
{

    use WithPagination;

    public $name, $status, $type, $cant, $cameraEdit;
    
    public function updatingStatus()
    {
        $this->resetPage();
    }

    public function updatingType()
    {
        $this->resetPage();
    }

    public function updatingName()
    {
        $this->resetPage();
    }

    public function updatingCant(){
        $this->resetPage();
    }

    protected $paginationTheme = "bootstrap";

    public function render()
    {

        $cameras = Camera::whereNotNull('type')
            ->where([
                ['type', '>=', '0'],
                ['type', '<=', '2']
            ])
            ->where('name', 'like', '%' . $this->name . '%')
            ->where('type', 'like', '%' . $this->type . '%')
            ->where('status', 'like', '%' . $this->status . '%')
            ->orderBy('status', 'asc')
            ->orderBy('name', 'asc')
            ->paginate($this->cant);

        return view('livewire.panel.monitoreo.cameras-index', compact('cameras'));
    }

    public function update(Camera $camera)
    {
        $this->cameraEdit = $camera;
        
        if ($this->cameraEdit->status != -1) {
            $this->cameraEdit->status = -1;
            $this->cameraEdit->save();

            $flaw = Flaw::create([
                'camera_id' => $this->cameraEdit->id,
                'dateflaw' => date('Y-m-d'),
                'timeflaw' => date('H:i:s'),
                'description' => 'Mantenimiento programado',
                'datesolution' => null,
                'timesolution' => null,
            ]);

            Arr::add($flaw, 'to',  env('TELEGRAM_MONITOREO_FALLAS'));
            Arr::add($flaw, 'content',  "*Fecha: *" . $flaw['dateflaw'] . "\n*Hora: *" . $flaw['timeflaw'] . " \n*Cámara: * " . $this->cameraEdit->name . "\n*Descripción: *" . $this->cameraEdit->description . "\n*Estado: *" . $flaw['description']);

            $flaw->notify(new TelegramNotification);

        } else {
            $flaw = Flaw::where('camera_id', $camera->id)
                ->where('timesolution', null)
                ->first();

            $fecha = new DateTime();
            
            $flaw->datesolution = $fecha->format('Y-m-d');
            $flaw->timesolution = $fecha->format('H:i:s');
            $flaw->update();

            $this->cameraEdit->status = 1;
            $this->cameraEdit->save();

            Arr::add($flaw, 'to',  env('TELEGRAM_MONITOREO_FALLAS'));
            Arr::add($flaw, 'content',  "*Fecha: *" . $flaw['dateflaw'] . "\n*Hora: *" . $flaw['timeflaw'] . " \n*Cámara: * " . $this->cameraEdit->name . "\n*Descripción: *" . $this->cameraEdit->description . "\n*Estado: * Mantenimiento finalizado");

            $flaw->notify(new TelegramNotification);
        }
    }

}
