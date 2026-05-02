<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function store(Request $request)
{
    $request->validate([
        'items' => 'required|array',
        'items.*.product_id' => 'required|exists:products,id',
        'items.*.quantity' => 'required|integer|min:1',
    ]);

    DB::beginTransaction();

    try {
        $total = 0;

        $order = Order::create([
            'user_id' => $request->user()->id,
            'total_price' => 0
        ]);

        foreach ($request->items as $item) {

            $product = Product::findOrFail($item['product_id']);

            // stock check
            if ($product->stock < $item['quantity']) {
                throw new \Exception("Insufficient stock for product ID {$product->id}");
            }

            $subtotal = $product->price * $item['quantity'];
            $total += $subtotal;

            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $product->id,
                'quantity' => $item['quantity'],
                'price' => $product->price
            ]);

            $product->stock -= $item['quantity'];
            $product->save();
        }

        $order->update([
            'total_price' => $total
        ]);

        DB::commit();

        return response()->json([
            'message' => 'Order created successfully',
        ]);

    } catch (\Exception $e) {

        DB::rollBack();

        return response()->json([
            'message' => 'Order failed',
            'error' => $e->getMessage()
        ], 500);
    }
}
}