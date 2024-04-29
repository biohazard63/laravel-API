<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
{
    $products = Product::all();
    return response()->json($products, 200);
}

    /**
     * Store a newly created resource in storage.
     */


    public function store(Request $request)
{
    $request->validate([
        'name' => 'required|max:255',
        'description' => 'required',
        'price' => 'required|numeric',
        // Ajoutez ici d'autres champs si nécessaire
    ]);

    $product = new Product([
        'name' => $request->get('name'),
        'description' => $request->get('description'),
        'price' => $request->get('price'),
        // Ajoutez ici d'autres champs si nécessaire
    ]);

    $product->save();

    return response()->json($product, 201);
}

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
{
    $request->validate([
        'name' => 'required|max:255',
        'description' => 'required',
        'price' => 'required|numeric',
        // Ajoutez ici d'autres champs si nécessaire
    ]);

    $product = Product::findOrFail($id);

    $product->update([
        'name' => $request->get('name'),
        'description' => $request->get('description'),
        'price' => $request->get('price'),
        // Ajoutez ici d'autres champs si nécessaire
    ]);

    return response()->json($product, 200);
}

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
{
    $product = Product::findOrFail($id);
    $product->delete();

    return response()->json(null, 204);
}
}
