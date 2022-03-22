<?php

namespace App\Http\Livewire\Panel\Administracion;

use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;
use OwenIt\Auditing\Models\Audit;

class AuditsIndex extends Component
{

    use WithPagination;

    public $fecha;
    public $usuario;

    public function updatingFecha()
    {
        $this->resetPage();
    }

    public function updatingUsuario()
    {
        $this->resetPage();
    }

    protected $paginationTheme = "bootstrap";

    public function render()
    {

        $usuarios = User::orderBy('name')->get();

        if ($this->usuario != 0) {
            $audits = Audit::where('user_id', $this->usuario)
                ->where('created_at', 'LIKE', '%' . $this->fecha . '%')
                ->orderBy('created_at', 'desc')
                ->paginate();
        } else if ($this->usuario == null) {
            $audits = Audit::where('user_id', auth()->user()->id)
                ->take(10)
                ->orderBy('created_at', 'desc')
                ->paginate();
        } else {
            $audits = Audit::where('created_at', 'LIKE', '%' . $this->fecha . '%')
                ->orderBy('created_at', 'desc')
                ->paginate();
        }


        return view('livewire.panel.administracion.audits-index', compact('usuarios', 'audits'));
    }
}
