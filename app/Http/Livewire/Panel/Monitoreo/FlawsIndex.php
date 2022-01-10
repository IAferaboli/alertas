<?php

namespace App\Http\Livewire\Panel\Monitoreo;

use App\Models\Camera;
use App\Models\Flaw;
use Livewire\Component;
use Livewire\WithPagination;

class FlawsIndex extends Component
{
    use WithPagination;

    public $fecha;
    public $camara;

    public function updatingSearch()
    {
        $this->resetPage();
    }
    
    protected $paginationTheme = "bootstrap";

    public function render()
    {

        if ($this->camara != null) {
            $flaws = Flaw::where('dateflaw', 'LIKE' , '%' . $this->fecha . '%')
            ->where('camera_id', 'LIKE' , '%' . $this->camara . '%')
            ->orderByDesc('dateflaw')
            ->orderByDesc('timeflaw')
            ->paginate();
        }else {
            $flaws = Flaw::where('dateflaw', 'LIKE' , '%' . $this->fecha . '%')
            ->orderByDesc('dateflaw')
            ->orderByDesc('timeflaw')
            ->paginate();
        }

        $cameras = Camera::orderBy('name','asc')->pluck('name', 'id');

        return view('livewire.panel.monitoreo.flaws-index', compact('flaws', 'cameras'));
    }
}
