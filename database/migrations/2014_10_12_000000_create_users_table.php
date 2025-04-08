<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('category_id'); 
            $table->string('name'); // This creates the relationship
            $table->decimal('price', 8, 2);
            $table->integer('stock');
            $table->string('image');
            $table->timestamps();
        });

        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('role')->default('user'); // Add role column
            $table->string('profile_photo')->nullable();
            $table->string('remember_token')->nullable();
            $table->string('status')->default('active'); // Add status column
            $table->timestamps();
        });

        DB::table('migrations')->insert([
            'migration' => '2014_10_12_000000_create_users_table',
            'batch' => 1
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
        Schema::dropIfExists('users');
    }
};