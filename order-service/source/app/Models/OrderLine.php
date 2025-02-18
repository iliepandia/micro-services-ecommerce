<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderLine extends Model
{
    protected $fillable = [
        'product_id',
        'quantity',
        'tax',
        'discount_percentage',
    ];

    /** @use HasFactory<\Database\Factories\OrderLineFactory> */
    use HasFactory;
}
