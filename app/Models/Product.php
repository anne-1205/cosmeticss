<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'category_id', // Changed from 'category'
        'price',
        'stock',
        'image'
    ];
public function images()
{
    return $this->hasMany(ProductImage::class);
}

public function orderItems()
{
    return $this->hasMany(OrderItem::class);
}

}