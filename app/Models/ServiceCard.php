<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceCard extends Model
{
    use HasFactory;

    protected $fillable = [
        'page', // slug страницы, например: 'network', 'cctv', 'fire-alarm'
        'title',
        'order',
    ];

    public function images()
    {
        return $this->hasMany(ServiceCardImage::class)->orderBy('order');
    }
}
