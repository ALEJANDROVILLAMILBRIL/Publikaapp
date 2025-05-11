<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Product extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'price',
        'quantity',
        'category_id'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    protected static function booted()
    {
        static::creating(function ($product) {
            $product->slug = Str::slug($product->name);
        });
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }
}