<?php

namespace App\Http\Livewire\Panel\Monitoreo;

use App\Models\Camera;
use Livewire\Component;
use Livewire\WithPagination;

class CamerasIndex extends Component
{

    use WithPagination;

    public $name, $status, $type, $cant;
    
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
}
