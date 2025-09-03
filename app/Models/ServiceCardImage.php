<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceCardImage extends Model
{
    use HasFactory;

    protected $fillable = [
        'service_card_id',
        'path', // '/images/carousel/.../1.jpg'
        'alt',
        'order',
    ];

    public function card()
    {
        return $this->belongsTo(ServiceCard::class, 'service_card_id');
    }
}
