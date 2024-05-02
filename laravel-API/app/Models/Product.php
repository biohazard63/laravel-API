<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @OA\Schema(
 *     schema="Product",
 *     required={"name", "description", "price", "stock", "image"},
 *     @OA\Property(
 *     property="name",
 *     type="string",
 *     description="The name of the product"
 *    ),
 *     @OA\Property(
 *     property="description",
 *     type="string",
 *     description="The description of the product"
 *   ),
 *     @OA\Property(
 *     property="price",
 *     type="number",
 *     format="float",
 *     description="The price of the product"
 *  ),
 *     @OA\Property(
 *     property="stock",
 *      type="integer",
 *     description="The stock of the product"
 * ),
 *     @OA\Property(
 *     property="image",
 *     type="string",
 *     description="The image of the product"
 * )
 * )
 */
class Product extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description', 'price', 'stock', 'image'];

    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }
}
