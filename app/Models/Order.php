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
    ];

    /**
     * Define the relationship to the user who placed the order.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}