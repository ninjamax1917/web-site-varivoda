<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ViewSession extends Model
{
    protected $fillable = [
        'user_id',
        'camera_id',
        'protocol',
        'started_at',
        'last_seen_at',
        'ip',
        'ua',
    ];
    protected $casts = [
        'started_at' => 'datetime',
        'last_seen_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function camera()
    {
        return $this->belongsTo(Camera::class);
    }
}
