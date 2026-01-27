<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    protected $fillable = [
        'order_id',
        'product_id',
        'qty',
        'price',
        'player_data'
    ];

    public function product()
    {
        // Ini biar ID Player tetep muncul bareng nama produknya meski barangnya udah diapus admin
        return $this->belongsTo(Product::class)->withTrashed();
    }
}
