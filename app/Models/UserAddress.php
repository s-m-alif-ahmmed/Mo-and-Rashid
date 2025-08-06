<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserAddress extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'country_id',
        'contact',
        'first_name',
        'last_name',
        'address',
        'apartment',
        'city',
        'postal_code',
    ];

    public function user()
    {
        return $this->belongsTo(user::class);
    }

}
