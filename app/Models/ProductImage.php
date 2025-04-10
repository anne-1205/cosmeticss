<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductImage extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'image_path',
        'alt_text',
        'sort_order'
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function images()
{
    return $this->hasMany(ProductImage::class);
}
}