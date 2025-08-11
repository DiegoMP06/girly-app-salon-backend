<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    protected $fillable = [
        'service',
        'image',
        'description',
        'price',
        'category_service_id',
    ];

    public function category()
    {
        return $this->belongsTo(CategoryService::class, 'category_service_id');
    }
}
