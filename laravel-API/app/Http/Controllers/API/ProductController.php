<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
/**
 * @OA\Info(
 *     title="Your API Title",
 *     version="1.0.0",
 *     description="A description of your API",
 *     @OA\Contact(
 *         email="support@example.com"
 *     ),
 * )
 */


class ProductController extends Controller
{
    /**
     * @return \Illuminate\Http\JsonResponse
     */
    /**
     * @OA\Get(
     *     path="/api/products",
     *     tags={"Products"},
     *     summary="Get list of products",
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *     ),
     * )
     */

    public function index()
    {
        $products = Product::all();
        return response()->json($products, 200);
    }

    public function indexC()
{
    return Product::with('categories')->get();
}

    /**
     * @OA\Post(
     *     path="/api/products",
     *     tags={"Products"},
     *     summary="Create a new product",
     *     @OA\RequestBody(
     *         description="Product data",
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/Product")
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Successful operation",
     *     ),
     * )
     */

public function store(Request $request)
{
    $request->validate([
        'name' => 'required|max:255',
        'description' => 'required',
        'price' => 'required|numeric',
        'stock' => 'required|numeric',
        'image' => 'required|image',
    ]);

    $imagePath = $request->file('image')->store('product_images', 'public');

    // Use the asset function to generate a URL for the image
    $imageUrl = asset('storage/' . $imagePath);

    $product = new Product([
        'name' => $request->get('name'),
        'description' => $request->get('description'),
        'price' => $request->get('price'),
        'stock' => $request->get('stock'),
        'image' => $imageUrl, // Use the generated URL instead of the path
    ]);

    $product->save();

    $category = Category::find(1);
    $product->categories()->attach($category);
    return response()->json($product, 201);
}
    /**
 * @OA\Put(
 *     path="/api/products/{product}",
 *     tags={"Products"},
 *     summary="Update a product",
 *     @OA\Parameter(
 *         name="product",
 *         in="path",
 *         description="ID of the product",
 *         required=true,
 *     ),
 *     @OA\RequestBody(
 *         description="Product data",
 *         required=true,
 *         @OA\JsonContent(ref="#/components/schemas/Product")
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Successful operation",
 *     ),
 * )
 */
public function update(Request $request, Product $product)
{
    $request->validate([
        'name' => 'required|max:255',
        'description' => 'required',
        'price' => 'required|numeric',
        'stock' => 'required|numeric',
        'image' => 'url',
    ]);

    $product->update([
        'name' => $request->get('name'),
        'description' => $request->get('description'),
        'price' => $request->get('price'),
        'stock' => $request->get('stock'),
        'image' => $request->get('image'),
    ]);

    $product->categories()->sync([$request->get('category_id')]);

    return response()->json($product, 200);
}
    /**
 * @OA\Post(
 *     path="/api/upload",
 *     tags={"Upload"},
 *     summary="Upload an image",
 *     @OA\RequestBody(
 *         description="Image data",
 *         required=true,
 *         @OA\MediaType(
 *             mediaType="multipart/form-data",
 *             @OA\Schema(
 *                 @OA\Property(
 *                     property="image",
 *                     description="Image file",
 *                     type="string",
 *                     format="binary"
 *                 )
 *             )
 *         )
 *     ),
 *     @OA\Response(
 *         response=201,
 *         description="Successful operation",
 *     ),
 * )
 */
    public function upload(Request $request)
    {
        $request->validate([
            'image' => 'required|image',
        ]);

        $imagePath = $request->file('image')->store('product_images', 'public');

        // Use the asset function to generate a URL for the image
        $imageUrl = asset('storage/' . $imagePath);

        return response()->json(['url' => $imageUrl], 201);
    }
/**
     * @param Product $product
     * @return \Illuminate\Http\JsonResponse
     */
/**
     * @OA\Delete(
     *     path="/api/products/{product}",
     *     tags={"Products"},
     *     summary="Delete a product",
     *     @OA\Parameter(
     *         name="product",
     *         in="path",
     *         description="ID of the product",
     *         required=true,
     *     ),
     *     @OA\Response(
     *         response=204,
     *         description="Successful operation",
     *     ),
     * )
     */
    public function destroy(Product $product)
    {
        $product->delete();

        return response()->json(null, 204);
    }

    /**
     * @param Product $product
     * @return \Illuminate\Http\JsonResponse
     */
/**
     * @OA\Get(
     *     path="/api/products/{product}",
     *     tags={"Products"},
     *     summary="Get a product",
     *     @OA\Parameter(
     *         name="product",
     *         in="path",
     *         description="ID of the product",
     *         required=true,
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *     ),
     * )
     */
    public function show(Product $product)
{
    return response()->json($product, 200);
}
}
