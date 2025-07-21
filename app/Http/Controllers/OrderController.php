<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderItem;
use DB;

class OrderController extends Controller
{
    public function index($id) {
    try {
        $order = DB::table('orders as o')
            ->join('vendors as v', 'o.vendor_id', '=', 'v.id')
            ->where('o.id', $id)
            ->select('o.id', 'o.order_number', 'o.order_date', 'o.notes', 'v.company_name as vendor_name')
            ->first();

        if (!$order) {
            return response()->json([
                'message' => 'Order not found',
            ], 404);
        }

        $items = DB::table('order_items as oi')
            ->join('products as p', 'oi.product_id', '=', 'p.id')
            ->where('oi.order_id', $id)
            ->select('p.name as product_name', 'oi.quantity', 'oi.unit_price', 'oi.total_price')
            ->get();

        return response()->json([
            'message' => 'Order fetched successfully',
            'data' => [
                'id' => $order->id,
                'order_number' => $order->order_number,
                'order_date' => $order->order_date,
                'notes' => $order->notes,
                'vendor_name' => $order->vendor_name,
                'items' => $items
            ]
        ], 200);

    } catch (\Exception $e) {
        return response()->json([
            'message' => 'Order fetch failed',
            'error' => $e->getMessage(),
        ], 500);
    }
}


    public function store(Request $request) {
        $validated = $request->validate([
            'vendor_id' => 'required|exists:vendors,id',
            //'ordered_by' => 'required|exists:users,id',
            'notes' => 'nullable|string',
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.unit_price' => 'required|numeric|min:0',
        ]);

        DB::beginTransaction();
        try {
            $order = Order::create([
                'vendor_id' => $validated['vendor_id'],
                'order_number' => 'ORD-' . strtoupper(uniqid()),
                'order_date' => now(),
                'notes' => $validated['notes'] ?? null,
            ]);

            foreach($validated['items'] as $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item['product_id'],
                    'quantity' => $item['quantity'],
                    'unit_price' => $item['unit_price'],
                    'total_price' => $item['quantity'] * $item['unit_price'],
                ]);
            }

            DB::commit();
            return response()->json([
                'message' => 'Order created successfully',
                'data' => $order,
            ], 201);
        }
        catch (\Exception $e) {
        DB::rollBack();
        return response()->json([
            'message' => 'Order creation failed',
            'error' => $e->getMessage(),
        ], 500);
    }
    }
}
