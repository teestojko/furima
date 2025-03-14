<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'points',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function sentMessages()
    {
        return $this->hasMany(Message::class, 'sender_id');
    }

    public function receivedMessages()
    {
        return $this->hasMany(Message::class, 'receiver_id');
    }

    public function favoriteProducts()
    {
        return $this->belongsToMany(Product::class, 'favorites', 'user_id', 'product_id')
        ->withTimestamps();
    }

        public function notifications()
    {
        return $this->hasMany(Notification::class);
    }

    public function reportedItems()
    {
        return $this->hasMany(Report::class, 'reported_user_id');
    }

    public function coupons()
    {
        return $this->hasMany(Coupon::class)->whereNotNull('user_id')->where('is_active', true);
    }

    public function reports()
    {
        return $this->hasMany(Report::class, 'reporter_user_id');
    }

    public function addPoints($points)
    {
        $this->points += $points;
        $this->save();
    }

}
