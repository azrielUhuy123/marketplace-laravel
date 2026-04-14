<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Shipment extends Model
{
    //
    protected $fillable = [
        'order_id',
        'logistic_id',
        'status',
        'tracking_code',
        'shipped_at',
        'delivered_at',
    ];
    
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function logistic()
    {
        return $this->belongsTo(User::class, 'logistic_id');
    }
}
