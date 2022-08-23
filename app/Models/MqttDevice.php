<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MqttDevice extends Model
{
    use HasFactory;

    public function data()
    {
        return $this->hasMany(MQTTData::class, 'topic_id', 'topic');
    }
}
