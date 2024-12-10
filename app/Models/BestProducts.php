<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BestProducts extends Model
{
    use HasFactory;

    protected $table = 'bestproducts';

    protected $fillable = [
        'product_id',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}