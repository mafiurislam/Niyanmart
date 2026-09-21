<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_number',
        'user_id',
        'customer_name',
        'customer_phone',
        'customer_email',
        'house_flat',
        'street_area',
        'city',
        'state',
        'pincode',
        'landmark',
        'address_type',
        'subtotal',
        'discount',
        'coupon_code',
        'delivery_charge',
        'total',
        'payment_method',
        'payment_status',
        'transaction_id',
        'order_status',
        'notes',
        'expected_delivery_date',
    ];

    protected $casts = [
        'subtotal' => 'decimal:2',
        'discount' => 'decimal:2',
        'delivery_charge' => 'decimal:2',
        'total' => 'decimal:2',
        'expected_delivery_date' => 'datetime',
    ];

    public static function generateOrderNumber()
    {
        return 'NM' . rand(10000000, 99999999);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function trackings()
    {
        return $this->hasMany(OrderTracking::class)->orderBy('tracked_at', 'asc');
    }

    public function getStatusStepAttribute()
    {
        return match ($this->order_status) {
            'placed' => 1,
            'confirmed' => 2,
            'packed' => 3,
            'out_for_delivery' => 4,
            'delivered' => 5,
            default => 1,
        };
    }

    public function getFormattedStatusAttribute()
    {
        return match ($this->order_status) {
            'placed' => 'Order Placed',
            'confirmed' => 'Confirmed',
            'packed' => 'Packed / Processing',
            'out_for_delivery' => 'Out for Delivery',
            'delivered' => 'Delivered',
            'cancelled' => 'Cancelled',
            'returned' => 'Returned',
            default => ucfirst($this->order_status),
        };
    }

    public function getPaymentMethodNameAttribute()
    {
        return match ($this->payment_method) {
            'cod' => 'Cash on Delivery',
            'upi' => 'UPI',
            'gpay' => 'Google Pay',
            'phonepe' => 'PhonePe',
            'card' => 'Credit / Debit Card',
            default => strtoupper($this->payment_method),
        };
    }
}
