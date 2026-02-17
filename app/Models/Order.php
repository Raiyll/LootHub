<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use SoftDeletes;
    protected $guarded = [];
    // Ini bagian yang harus ditambahin/dibenerin
    protected $fillable = [
        'user_id',
        'invoice_number', 
        'total_price', 
        'pay_amount', 
        'change_amount'
    ];

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }
}