<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CartItem extends Model
{
    //
    protected $fillable = [
        'cart_id',
        'product_id',
        'quantity',
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function items()
    {
        return $this->hasMany(CartItem::class);
    }
    public function product()
    {
        return $this->belongsTo(\App\Models\Product::class);
    }
        public function cart()
    {
        return $this->belongsTo(\App\Models\Cart::class);
    }
}
