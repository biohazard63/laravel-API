<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;

class CategoryController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/categories",
     *     tags={"Categories"},
     *     summary="Get list of categories",
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *     )
     * )
     */
    public function index()
    {
        $categories = Category::all();
        return response()->json($categories, 200);
    }

    /**
     * @OA\Post(
     *     path="/api/categories",
     *     tags={"Categories"},
     *     summary="Create a new category",
     *     @OA\RequestBody(
     *         description="Category data",
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/Category")
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Successful operation",
     *     )
     * )
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:255',
        ]);

        $category = new Category([
            'name' => $request->get('name'),
        ]);

        $category->save();

        return response()->json($category, 201);
    }

    /**
     * @OA\Get(
     *     path="/api/categories/{category}",
     *     tags={"Categories"},
     *     summary="Get a category",
     *     @OA\Parameter(
     *         name="category",
     *         in="path",
     *         description="ID of the category",
     *         required=true,
     *         @OA\Schema(
     *             type="integer"
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *     )
     * )
     */
    public function show(Category $category)
    {
        return response()->json($category, 200);
    }

    /**
     * @OA\Put(
     *     path="/api/categories/{category}",
     *     tags={"Categories"},
     *     summary="Update a category",
     *     @OA\Parameter(
     *         name="category",
     *         in="path",
     *         description="ID of the category",
     *         required=true,
     *         @OA\Schema(
     *             type="integer"
     *         )
     *     ),
     *     @OA\RequestBody(
     *         description="Category data",
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/Category")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *     )
     * )
     */
    public function update(Request $request, Category $category)
    {
        $request->validate([
            'name' => 'required|max:255',
        ]);

        $category->update([
            'name' => $request->get('name'),
        ]);

        return response()->json($category, 200);
    }

    /**
     * @OA\Delete(
     *     path="/api/categories/{category}",
     *     tags={"Categories"},
     *     summary="Delete a category",
     *     @OA\Parameter(
     *         name="category",
     *         in="path",
     *         description="ID of the category",
     *         required=true,
     *         @OA\Schema(
     *             type="integer"
     *         )
     *     ),
     *     @OA\Response(
     *         response=204,
     *         description="Successful operation",
     *     )
     * )
     */
    public function destroy(Category $category)
    {
        $category->delete();

        return response()->json(null, 204);
    }
}
