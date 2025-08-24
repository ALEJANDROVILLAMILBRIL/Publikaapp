<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_number',
        'slug',
        'user_id',
        'total_amount',
        'payment_method',
        'payment_status',
        'paypal_order_id',
        'payment_details',
        'order_status',
        'notes',
        'latitude',
        'longitude',
    ];

    protected $casts = [
        'payment_details' => 'array'
    ];

    // Para usar slug en las rutas
    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function actions()
    {
        return $this->hasMany(OrderAction::class);
    }

    public static function generateOrderNumber()
    {
        do {
            $orderNumber = 'ORD-' . date('Ymd') . '-' . strtoupper(uniqid());
        } while (self::where('order_number', $orderNumber)->exists());

        return $orderNumber;
    }

    public static function generateSlug($orderNumber)
    {
        $slug = Str::slug($orderNumber);

        $originalSlug = $slug;
        $counter = 1;

        while (self::where('slug', $slug)->exists()) {
            $slug = $originalSlug . '-' . $counter;
            $counter++;
        }

        return $slug;
    }

    // Boot method para generar slug automáticamente
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($order) {
            if (empty($order->slug)) {
                $order->slug = self::generateSlug($order->order_number);
            }
        });
    }
}
