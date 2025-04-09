<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description'];

    /**
     * Define the relationship to the products in this category.
     */
    public function products()
    {
        return $this->hasMany(Product::class);
    }
}