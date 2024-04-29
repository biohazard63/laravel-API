<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::all();
        return response()->json($products, 200);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:255',
            'description' => 'required',
            'price' => 'required|numeric',
            'stock' => 'required|numeric',
            'image' => 'required|url', // Valide que l'image est une URL
        ]);

        $product = new Product([
            'name' => $request->get('name'),
            'description' => $request->get('description'),
            'price' => $request->get('price'),
            'stock' => $request->get('stock'),
            'image' => $request->get('image'), // Stocke l'URL de l'image
        ]);

        $product->save();

        $category = Category::find(1);
        $product->categories()->attach($category);
        return response()->json($product, 201);
    }

    public function update(Request $request, Product $product)
    {
        $request->validate([
            'name' => 'required|max:255',
            'description' => 'required',
            'price' => 'required|numeric',
            'stock' => 'required|numeric',
            'image' => 'url', // Valide que l'image est une URL
        ]);

        $product->update([
            'name' => $request->get('name'),
            'description' => $request->get('description'),
            'price' => $request->get('price'),
            'stock' => $request->get('stock'),
            'image' => $request->get('image'), // Met à jour l'URL de l'image
        ]);

        $product->categories()->sync([$request->get('category_id')]);

        return response()->json($product, 200);
    }

    public function destroy(Product $product)
    {
        $product->delete();

        return response()->json(null, 204);
    }
    public function show(Product $product)
{
    return response()->json($product, 200);
}
}
