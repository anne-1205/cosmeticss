<?php
// filepath: c:\xampp2\htdocs\HMcosmetics\HMcosmetics\app\Models\User.php
namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;

class User extends Authenticatable implements MustVerifyEmail
{
    use Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'profile_photo',
        'role',
        'status', // Add this field
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function cartItems()
    {
        return $this->hasMany(Cart::class);
        
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }
}

