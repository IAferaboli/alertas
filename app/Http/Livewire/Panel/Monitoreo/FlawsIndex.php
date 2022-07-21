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
    public $description;
    public $descriptionFiltro;
    public $selectflaw = [];

    protected $paginationTheme = "bootstrap";

    public function actualizaDescripcion()
    {
        foreach ($this->selectflaw as $selected) {
            $flaw = Flaw::find($selected);

            $flaw->description = $this->description;
            $flaw->update();
        }

        return redirect()->route('panel.monitoreo.flaws.index')->with('info', 'Fallas actualizadas exitosamente.');

    }

    public function render()
    {


        if ($this->camara != null) {
            $flaws = Flaw::where('dateflaw', 'LIKE' , '%' . $this->fecha . '%')
            ->where('camera_id', '=',  $this->camara)
            ->where('description', 'LIKE' , '%' . $this->descriptionFiltro . '%')
            ->orderByDesc('dateflaw')
            ->orderByDesc('timeflaw')
            ->paginate();
        }else {
            $flaws = Flaw::where('dateflaw', 'LIKE' , '%' . $this->fecha . '%')
            ->where('description', 'LIKE' , '%' . $this->descriptionFiltro . '%')
            ->orderByDesc('dateflaw')
            ->orderByDesc('timeflaw')
            ->paginate();
        }

        $cameras = Camera::orderBy('name','asc')->pluck('name', 'id');

        return view('livewire.panel.monitoreo.flaws-index', compact('flaws', 'cameras'));
    }
}
