<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Camera extends Model
{
    protected $fillable = [
        'name',
        'rtsp_url',
        'preview',
        'views_today',
        'views_online',
        'views_total',
    ];
}
