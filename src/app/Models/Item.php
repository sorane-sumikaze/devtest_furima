<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;
    protected $fillable = [
        'seller_id',
        'image',
        'item_name',
        'brand_name',
        'price',
        'description',
        'condition',
        'sold',
    ];

    protected $casts = [
        'sold' => 'boolean',
    ];

    public function seller()
    {
        return $this->belongsTo(User::class, 'seller_id');
    }

    public function purchase()
    {
        return $this->hasOne(Purchase::class);
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'item_category');
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
