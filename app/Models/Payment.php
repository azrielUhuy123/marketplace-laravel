<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    //
    protected $fillable = [
        'checkout_id',
        'method',
        'status',
    ];
    public function checkout()
    {
        return $this->belongsTo(Checkout::class);
    }
}
