<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductReviewLike extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'product_id',
        'product_review_id',
        'likes',
    ];
}
