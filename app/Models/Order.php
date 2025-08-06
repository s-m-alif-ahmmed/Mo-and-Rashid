<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'country_id',
        'name',
        'address',
        'apartment',
        'city',
        'postal_code',
        'contact',
        'total',
        'status',
        'all_terms',
        'tracking_id',
    ];

    // Define the relationship with the User model
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Define the relationship with the OrderDetail model
    public function orderDetails()
    {
        return $this->hasMany(OrderDetail::class);
    }


    public function productColor()
    {
        return $this->belongsTo(ProductColor::class, 'product_color_id');
    }

    public function productSize()
    {
        return $this->belongsTo(ProductSize::class, 'product_size_id');
    }

    public function country()
    {
        return $this->belongsTo(Country::class, 'country_id');
    }

}
