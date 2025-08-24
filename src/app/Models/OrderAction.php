<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderAction extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'action_type',
        'description',
        'phone_number',
        'email',
        'solved_by_user',
        'user_id',
        'solved_by_seller',
        'seller_id',
        'solved_by_admin',
        'admin_id',
        'solution_notes',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
