<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Intervention extends Model
{
    use Notifiable;
    use HasFactory;
    protected $guarded = ['id','created_at', 'updated_at'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function camera()
    {
        return $this->belongsTo(Camera::class);
    }
}