<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OrderDetail extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'order_id',
        'product_id',
        'selling_price',
        'discount_price',
        'quantity',
        'product_color_id',
        'product_size_id',
    ];

    public static function boot()
    {
        parent::boot();

        // Listen to the creating event
        self::creating(function ($orderDetail) {
            // Find the product
            $product = Product::find($orderDetail->product_id);

            // Check if the product exists and has enough stock
            if ($product && $product->quantity >= $orderDetail->quantity) {
                // Decrease the product stock
                $product->quantity -= $orderDetail->quantity;
                $product->save();
            } else {
                // Throw an exception or handle the error if stock is insufficient
                throw new \Exception("Insufficient stock for product ID: {$orderDetail->product_id}");
            }
        });

        // Optional: Listen to the deleting event to restore stock if an order detail is deleted
        self::deleting(function ($orderDetail) {
            $product = Product::find($orderDetail->product_id);

            if ($product) {
                // Increase the product stock
                $product->quantity += $orderDetail->quantity;
                $product->save();
            }
        });
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    // Define the relationship with the Order model
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function productColor()
    {
        return $this->belongsTo(Color::class, 'product_color_id');
    }

    public function productSize()
    {
        return $this->belongsTo(Size::class, 'product_size_id');
    }


}
