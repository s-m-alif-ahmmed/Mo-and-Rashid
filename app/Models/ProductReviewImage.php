<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductReviewImage extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'product_review_id',
        'product_id',
        'image',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function productReview()
    {
        return $this->belongsTo(ProductReview::class);
    }
}
