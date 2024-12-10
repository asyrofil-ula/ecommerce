<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'price',
        'stock',
        'category_id',
        'image',
    ];


    public function category(){
        return $this->belongsTo(Category::class);
    }
    public function bestproduct(){
        return $this->hasMany(BestProducts::class);
    }

    public function orderDetails(){
        return $this->hasMany(OrderDetail::class);
    }

    public function cart() {
        return $this->hasMany(Cart::class);
    }
}
