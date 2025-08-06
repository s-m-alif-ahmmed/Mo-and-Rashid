<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Wishlist extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'product_id',
        'product_color_id',
        'product_size_id',

    ];

    // Wishlist.php
    public function user() {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function product() {
        return $this->belongsTo(Product::class, 'product_id');
    }

    public function color() {
        return $this->belongsTo(Color::class,'product_color_id');
    }


    public function size() {
        return $this->belongsTo(Size::class,'product_size_id');
    }
}
