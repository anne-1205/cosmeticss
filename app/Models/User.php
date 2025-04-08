<?php
// filepath: c:\xampp2\htdocs\HMcosmetics\HMcosmetics\app\Models\User.php
namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Support\Facades\Log;

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

    /**
     * Check if the user is active.
     */
    public function isActive()
    {
        return $this->status === 'active';
    }

    public function markEmailAsVerified()
    {
        if ($this->email_verified_at) {
            Log::info('Email already verified for user: ' . $this->id);
            return false;
        }

        $this->forceFill([
            'email_verified_at' => $this->freshTimestamp(),
        ])->save();

        // Debugging: Log or dump a message
        Log::info('Email verified for user: ' . $this->id);

        return true;
    }
}

