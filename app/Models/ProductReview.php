<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductReview extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'product_id',
        'rating',
        'title',
        'review',
        'name',
        'email',
        'status',
    ];

    public function images()
    {
        return $this->hasMany(ProductReviewImage::class);
    }

    public function likes()
    {
        return $this->hasMany(ProductReviewLike::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
