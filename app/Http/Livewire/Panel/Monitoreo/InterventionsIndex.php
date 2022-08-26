<?php

namespace App\Http\Livewire\Panel\Monitoreo;

use App\Models\Camera;
use App\Models\Intervention;
use Livewire\Component;
use Livewire\WithPagination;

class InterventionsIndex extends Component
{
    use WithPagination;

    public $fecha;
    public $search;
    public $camara;

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingFecha()
    {
        $this->resetPage();
    }

    public function updatingCamara()
    {
        $this->resetPage();
    }
    
    protected $paginationTheme = "bootstrap";
    
    public function render()
    {


        if ($this->camara != null) {
            $interventions = Intervention::where('camera_id' , '=', $this->camara)
            ->where('date', 'LIKE' , '%' . $this->fecha . '%')
            ->where('detail', 'LIKE' , '%' . $this->search . '%')
            ->orderByDesc('date')
            ->orderByDesc('hour')
            ->paginate();
        } else{
            $interventions = Intervention::where('date', 'LIKE' , '%' . $this->fecha . '%')
            ->where('detail', 'LIKE' , '%' . $this->search . '%')
            ->orderByDesc('date')
            ->orderByDesc('hour')
            ->paginate();
        }

        $cameras = Camera::orderBy('name','asc')->pluck('name', 'id');

        return view('livewire.panel.monitoreo.interventions-index', compact('interventions', 'cameras'));
    }
}
