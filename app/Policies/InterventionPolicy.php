<?php

namespace App\Policies;

use App\Models\Intervention;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class InterventionPolicy
{
    use HandlesAuthorization;

       //function author
       public function author(User $user, Intervention $intervention)
       {   
           if ($user->id == $intervention->user_id || auth()->user()->roles->pluck('name')->contains('Supervisor de Monitoreo')) {
               return true;
           } else {
               return false;
           }
       }
}
