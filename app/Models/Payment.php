<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $fillable = [
        'order_id',
        'method',
        'status',
        'amount',
        'reference_number',
        'ewallet_provider',
        'paid_at',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'paid_at' => 'datetime',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function getMethodLabelAttribute()
    {
        return match ($this->method) {
            'cod' => 'Cash on Delivery (COD)',
            'online_banking' => 'Online Banking',
            'ewallet' => 'E-Wallet' . ($this->ewallet_provider ? " ({$this->ewallet_provider})" : ''),
            default => $this->method,
        };
    }

    public function getStatusLabelAttribute()
    {
        return match ($this->status) {
            'pending' => 'Menunggu Bayaran',
            'paid' => 'Telah Dibayar',
            'failed' => 'Gagal',
            'refunded' => 'Dikembalikan',
            default => $this->status,
        };
    }
}
