<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'amount',
        'payment_method',
        'status',
        'payment_date'
    ];

    protected $casts = [
        'payment_date' => 'datetime'
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function markAsPaid()
    {
        $this->status = 'paid';
        $this->payment_date = now();
        $this->save();
        
        $this->order->status = 'completed';
        $this->order->save();
    }
}