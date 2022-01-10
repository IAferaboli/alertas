<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Camera extends Model
{
    use HasFactory;
    protected $guarded = ['id','created_at', 'updated_at'];

    protected $hidden = ['created_at', 'updated_at'];

    public function interventions()
    {
        return $this->hasMany(Intervention::class);
    }

    public function flaws()
    {
        return $this->hasMany(Flaw::class);
    }
}
