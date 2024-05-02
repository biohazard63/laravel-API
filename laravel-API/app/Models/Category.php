<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
/**
 * @OA\Schema(
 *     schema="Category",
 *     required={"name"},
 *     @OA\Property(
 *         property="name",
 *         type="string",
 *         description="The name of the category"
 *     ),
 * )
 */
class Category extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    public function products()
    {
        return $this->belongsToMany(Product::class);
    }
}
