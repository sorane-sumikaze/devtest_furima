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

    protected $fillable = [
        'user_name',
        'email',
        'password',
        'email_verified',
        'profile_image',
        'post_code',
        'address',
        'building',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified' => 'boolean',
        'password' => 'hashed',
    ];

    public function hasVerifiedEmail(): bool
    {
        return (bool) $this->email_verified;
    }

    public function markEmailAsVerified(): bool
    {
        return $this->forceFill(['email_verified' => true])->save();
    }

    public function items()
    {
        return $this->hasMany(Item::class, 'seller_id');
    }

    public function purchases()
    {
        return $this->hasMany(Purchase::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function likes()
    {
        return $this->hasMany(Like::class);
    }
}
