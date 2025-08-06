<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CredentialSetting extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'stripe_secret',
        'stripe_key',
        'paypal_sandbox_client_id',
        'paypal_sandbox_client_secret',
        'google_client_id',
        'google_client_secret_id',
    ];
}
