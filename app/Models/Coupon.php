<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'discount_type',
        'discount_value',
        'min_order_amount',
        'max_discount_amount',
        'usage_limit',
        'used_count',
        'start_date',
        'expiry_date',
        'is_active',
    ];

    protected $casts = [
        'discount_value' => 'decimal:2',
        'min_order_amount' => 'decimal:2',
        'max_discount_amount' => 'decimal:2',
        'is_active' => 'boolean',
        'start_date' => 'date',
        'expiry_date' => 'date',
    ];

    public function isValidFor($amount)
    {
        if (!$this->is_active) {
            return false;
        }
        if ($this->expiry_date && $this->expiry_date->isPast()) {
            return false;
        }
        if ($this->usage_limit && $this->used_count >= $this->usage_limit) {
            return false;
        }
        if ($amount < $this->min_order_amount) {
            return false;
        }
        return true;
    }

    public function calculateDiscount($amount)
    {
        if (!$this->isValidFor($amount)) {
            return 0;
        }

        if ($this->discount_type === 'percent') {
            $discount = ($amount * $this->discount_value) / 100;
            if ($this->max_discount_amount && $discount > $this->max_discount_amount) {
                $discount = $this->max_discount_amount;
            }
            return round($discount, 2);
        }

        return min($amount, $this->discount_value);
    }
}
