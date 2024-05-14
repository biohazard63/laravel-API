<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_name',
        'total_amount'
    ];

    public function products()
    {
        return $this->belongsToMany(Product::class, 'order_product')
                    ->withPivot('quantity')
                    ->withTimestamps();
    }
    public function user()
{
    return $this->belongsTo(User::class, 'customer_name', 'name');
}
public function updateProductStocks()
{
    foreach ($this->products as $product) {
        $quantity = $product->pivot->quantity;

        $product->stock -= $quantity;
        $product->save();
    }
}
}
