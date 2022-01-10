<?php

namespace App\Http\Livewire\Panel;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\User;
 
class UsersIndex extends Component
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

        $users = User::where('name', 'LIKE' , '%' . $this->search . '%')
                        ->orWhere('email', 'LIKE' , '%' . $this->search . '%')
                        ->paginate();

        return view('livewire.panel.users-index', compact('users'));
    }
}
