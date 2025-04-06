<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'subtotal',
        'shipping',
        'total',
        'status',
        'shipping_address',
        'contact_number',
        'notes',
        'payment_method',
        'billing_address'
    ];

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

   
}