<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'order_number',
        'receipt_number',
        'user_id',
        'subtotal',
        'shipping_fee',
        'total',
        'status',
        'shipping_address',
        'recipient_name',
        'phone',
        'notes',
        'guest_email',
        'guest_name',
    ];

    public function isGuest(): bool
    {
        return is_null($this->user_id);
    }

    public function getCustomerName()
    {
        return $this->user ? $this->user->name : $this->guest_name;
    }

    public function getCustomerEmail()
    {
        return $this->user ? $this->user->email : $this->guest_email;
    }

    protected $casts = [
        'subtotal' => 'decimal:2',
        'shipping_fee' => 'decimal:2',
        'total' => 'decimal:2',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function payment()
    {
        return $this->hasOne(Payment::class);
    }

    public static function generateOrderNumber()
    {
        $date = now()->format('Ymd');
        $lastOrder = static::where('order_number', 'like', "KD-{$date}-%")
            ->orderBy('order_number', 'desc')
            ->first();

        $num = $lastOrder ? intval(substr($lastOrder->order_number, -4)) + 1 : 1;
        return "KD-{$date}-" . str_pad($num, 4, '0', STR_PAD_LEFT);
    }

    public static function generateReceiptNumber()
    {
        $date = now()->format('Ymd');
        $lastOrder = static::where('receipt_number', 'like', "RCP-{$date}-%")
            ->orderBy('receipt_number', 'desc')
            ->first();

        $num = $lastOrder ? intval(substr($lastOrder->receipt_number, -4)) + 1 : 1;
        return "RCP-{$date}-" . str_pad($num, 4, '0', STR_PAD_LEFT);
    }

    /**
     * Calculate shipping fee based on payment method.
     * COD = RM5, Online Banking / E-Wallet = RM8
     */
    public static function calculateShippingFee(string $paymentMethod, float $subtotal): float
    {
        if ($subtotal > 100) {
            return 0.00;
        }
        return $paymentMethod === 'cod' ? 5.00 : 8.00;
    }

    public function getStatusLabelAttribute()
    {
        return match ($this->status) {
            'pending' => 'Menunggu',
            'to_pay' => 'Belum Bayar',
            'to_ship' => 'Sedang Diproses',
            'to_receive' => 'Dalam Penghantaran',
            'arrived' => 'Telah Sampai',
            'completed' => 'Selesai',
            'cancelled' => 'Dibatalkan',
            default => $this->status,
        };
    }

    public function getStatusColorAttribute()
    {
        return match ($this->status) {
            'pending', 'to_pay' => '#f39c12',
            'to_ship' => '#3498db',
            'to_receive' => '#9b59b6',
            'arrived' => '#2ecc71',
            'completed' => '#27ae60',
            'cancelled' => '#e74c3c',
            default => '#95a5a6',
        };
    }
}
