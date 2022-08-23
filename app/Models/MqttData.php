<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MqttData extends Model
{
    use HasFactory;

    public function device()
    {
        return $this->belongsTo(WaterSensor::class, 'topic_id', 'topic');
    }

}
