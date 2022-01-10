<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Flaw extends Model
{
    use HasFactory;

    protected $guarded = ['id','created_at', 'updated_at'];


    protected $hidden = [
        'created_at',
    ];

    public function camera()
    {
        return $this->belongsTo(Camera::class);
    }
}
