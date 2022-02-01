<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Notification
{
    use HasFactory;
    use Notifiable;

    public function setContent($content)
    {
        $this->content = $content;
    }

    public function setTo($to)
    {
        $this->to = $to;
    }

}
