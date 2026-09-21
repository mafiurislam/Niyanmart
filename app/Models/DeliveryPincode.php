<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DeliveryPincode extends Model
{
    use HasFactory;

    protected $fillable = [
        'pincode',
        'city',
        'district',
        'state',
        'delivery_charge',
        'min_free_delivery',
        'estimated_time',
        'is_deliverable',
    ];

    protected $casts = [
        'delivery_charge' => 'decimal:2',
        'min_free_delivery' => 'decimal:2',
        'is_deliverable' => 'boolean',
    ];
}
