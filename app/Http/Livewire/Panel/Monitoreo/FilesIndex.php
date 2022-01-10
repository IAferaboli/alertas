<?php

namespace App\Http\Livewire\Panel\Monitoreo;

use App\Models\File;
use Livewire\Component;
use Livewire\WithPagination;



class FilesIndex extends Component
{

    use WithPagination;

    public $search;

    public function updatingSearch()
    {
        $this->resetPage();
    }
    
    protected $paginationTheme = "bootstrap";
    public function render()
    {

        $files = File::where('datein', 'LIKE' , '%' . $this->search . '%')
                        ->orWhere('notenumber', 'LIKE' , '%' . $this->search . '%')
                        ->orWhere('datefilm', 'LIKE' , '%' . $this->search . '%')
                        ->orWhere('filenumber', 'LIKE' , '%' . $this->search . '%')
                        ->orderByDesc('datein')
                        ->paginate();

        return view('livewire.panel.monitoreo.files-index', compact('files'));
    }
}
