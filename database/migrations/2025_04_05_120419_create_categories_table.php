<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCategoriesTable extends Migration
{
    public function up()
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->timestamps();
        });

        \App\Models\Category::create(['name' => 'lips']);
        \App\Models\Category::create(['name' => 'face']);
        \App\Models\Category::create(['name' => 'eyeshadow']);
        \App\Models\Category::create(['name' => 'skin care']);
    }

    public function down()
    {
        Schema::dropIfExists('categories');
    }
}