<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Cart extends Model
{
    use HasFactory,softDeletes;

    protected $fillable = [
        'user_id',
        'product_id',
        'color_id',
        'size_id',
        'selling_price',
        'discount_price',
        'quantity',
    ];


    // Casts
    protected function casts(): array
    {
        return [
            'user_id'    => 'integer',
            'product_id' => 'integer',
            'color_id'   => 'integer',
            'size_id'    => 'integer',
            'selling_price'    => 'integer',
            'discount_price'    => 'integer',
            'quantity'   => 'integer',
        ];
    }


    //define relationship
    public function user()
    {
        return $this->belongsTo(User::class,'user_id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class,'product_id');
    }

    public function color()
    {
        return $this->belongsTo(Color::class,'color_id');
    }

    public function size()
    {
        return $this->belongsTo(Size::class,'size_id');
    }
}
