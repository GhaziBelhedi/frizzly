<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Order extends Model
{
    protected $fillable = [
        'customer_name', 'customer_email', 'customer_phone',
        'product_id', 'quantity', 'total',
        'status', 'payment_status', 'notes',
    ];

    protected $casts = [
        'total' => 'decimal:2',
    ];

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function getStatusColorAttribute(): array
    {
        return match($this->status) {
            'pending'   => ['color' => '#F97316', 'bg' => '#FEF3EA'],
            'confirmed' => ['color' => '#4DA3FF', 'bg' => '#EBF4FF'],
            'shipped'   => ['color' => '#8E6CFF', 'bg' => '#F0ECFF'],
            'delivered' => ['color' => '#2ECC71', 'bg' => '#E8FAF0'],
            'cancelled' => ['color' => '#EF4444', 'bg' => '#FEF2F2'],
            default     => ['color' => '#94A3B8', 'bg' => '#F8FAFC'],
        };
    }

    public function getPaymentColorAttribute(): array
    {
        return match($this->payment_status) {
            'paid'     => ['color' => '#2ECC71', 'bg' => '#E8FAF0'],
            'pending'  => ['color' => '#F97316', 'bg' => '#FEF3EA'],
            'failed'   => ['color' => '#EF4444', 'bg' => '#FEF2F2'],
            'refunded' => ['color' => '#8E6CFF', 'bg' => '#F0ECFF'],
            default    => ['color' => '#94A3B8', 'bg' => '#F8FAFC'],
        };
    }
}
