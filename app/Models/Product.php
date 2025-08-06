<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'description',
        'discount_price',
        'selling_price',
        'quantity',
        'product_slug',
        'category_id',
        'brand_id',
        'status',
    ];

    public function images()
    {
        return $this->hasMany(ProductImage::class);
    }

    public function productColors()
    {
        return $this->hasMany(ProductColor::class);
    }

    public function productSizes()
    {
        return $this->hasMany(ProductSize::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }
}
