<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use SoftDeletes;
    
    protected $fillable = ['category_id', 'name', 'game_name', 'price', 'stock', 'image'];

    public function category() {
        return $this->belongsTo(Category::class, 'category_id');
    }
}