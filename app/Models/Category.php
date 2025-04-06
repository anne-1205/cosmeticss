<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = ['name'];
}

\App\Models\Category::firstOrCreate(['name' => 'Lips']);
\App\Models\Category::firstOrCreate(['name' => 'Face']);
\App\Models\Category::firstOrCreate(['name' => 'Eyeshadow']);
\App\Models\Category::firstOrCreate(['name' => 'Skin Care']);
