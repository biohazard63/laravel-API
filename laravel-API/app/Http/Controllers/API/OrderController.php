<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\User;
use App\Models\Product;
use App\Models\OrderProduct;
use Illuminate\Http\Request;


class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::all();
        return response()->json($orders);
    }

    public function store(Request $request)
    {
        $order = Order::create($request->only(['customer_name', 'total_amount']));

        if ($request->has('products')) {
            foreach ($request->input('products') as $product) {
                $order->products()->attach($product['id'], ['quantity' => $product['quantity']]);
            }
        }
        $order->updateProductStocks();

        return response()->json($order, 201);
    }

    public function getUserOrders($name)
    {
        $user = User::where('name', $name)->first();

        if ($user) {
            $orders = $user->orders;
            return response()->json($orders);
        } else {
            return response()->json(['message' => 'User not found'], 404);
        }
    }
public function show($name)
{
    $user = User::where('name', $name)->first();
    if ($user) {
        $orders = Order::where('customer_name', $name)->get();
        $user->orders = $orders; // Attach the orders to the user
        return response()->json($user);
    } else {
        return response()->json(['message' => 'User not found'], 404);
    }
}

    public function update(Request $request, Order $order)
    {
        $order->update($request->all());
        return response()->json($order);
    }

    public function destroy(Order $order)
    {
        $order->delete();
        return response()->json(null, 204);
    }

    public function addProduct(Request $request, Order $order)
    {
        $product_id = $request->input('product_id');
        $quantity = $request->input('quantity');

        $order->products()->attach($product_id, ['quantity' => $quantity]);

        return response()->json(['message' => 'Product added to the order successfully']);
    }
}
