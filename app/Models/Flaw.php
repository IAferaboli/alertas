<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Auditable as AuditingAuditable;
use OwenIt\Auditing\Contracts\Auditable;


class Flaw extends Model implements Auditable
{
    use Notifiable;
    use HasFactory;
    use AuditingAuditable;

    protected $guarded = ['id','created_at', 'updated_at'];


    protected $hidden = [
        'created_at',
    ];

    public function camera()
    {
        return $this->belongsTo(Camera::class);
    }
}
