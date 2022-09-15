<?php

namespace App\Http\Livewire\Panel\Monitoreo;

use App\Models\File;
use Carbon\Carbon;
use Livewire\Component;
use Livewire\WithPagination;


class FilesIndex extends Component
{

    use WithPagination;

    public $datein, $notenumber, $starttime, $filenumber, $init, $month;

    //Modal
    public $expediente;
    public function updatingDatein()
    {
        $this->resetPage();
    }

    public function updatingNotenumber()
    {
        $this->resetPage();
    }

    public function updatingStarttime()
    {
        $this->resetPage();
    }

    public function updatingFilenumber()
    {
        $this->resetPage();
    }

    public function updatingInit()
    {
        $this->resetPage();
    }

    public function updatingMonth()
    {
        $this->resetPage();
    }
    protected $paginationTheme = "bootstrap";

    public function showFile(File $file)
    {
        $this->expediente = $file;
    }

    public function mount()
    {
        $this->expediente = File::first();
    }
    public function render()
    {
        // if ($this->datefilm) {
        //     # code...
        //     $this->datefilm = Carbon::parse($this->datefilm)->format('Y-m-d');
        // }
        if($this->month){
            $files = File::where('datein', 'LIKE', '%' . $this->datein . '%')
            ->where('notenumber', 'LIKE', '%' . $this->notenumber . '%')
            ->whereDate('starttime', 'LIKE', '%' . $this->starttime . '%')
            ->where('filenumber', 'LIKE', '%' . $this->filenumber . '%')
            ->where('init', 'LIKE', '%' . $this->init . '%')
            ->whereMonth('datein',  Carbon::parse($this->month)->format('m'))
            ->whereYear('datein', Carbon::parse($this->month)->format('Y'))
            ->orderByDesc('datein')
            ->paginate();
        }else{
            $files = File::where('datein', 'LIKE', '%' . $this->datein . '%')
            ->whereDate('starttime', 'LIKE', '%' . $this->starttime . '%')
            ->where('notenumber', 'LIKE', '%' . $this->notenumber . '%')
            ->where('filenumber', 'LIKE', '%' . $this->filenumber . '%')
            ->where('init', 'LIKE', '%' . $this->init . '%')
            ->orderByDesc('datein')
            ->paginate();
        }
  
        return view('livewire.panel.monitoreo.files-index', compact('files'));
    }
}
