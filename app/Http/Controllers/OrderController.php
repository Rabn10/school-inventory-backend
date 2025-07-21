<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderItem;
use DB;

class OrderController extends Controller
{
    public function index()
    {
        try {
            $orders = DB::table('orders as o')
                ->join('vendors as v', 'o.vendor_id', '=', 'v.id')
                ->select('o.id', 'o.order_number', 'o.order_date', 'o.notes','o.satus as status', 'v.company_name as vendor_name')
                ->get();

            if ($orders->isEmpty()) {
                return response()->json([
                    'message' => 'No orders found',
                ], 404);
            }

            $orderIds = $orders->pluck('id');

            // Get all items for the orders
            $items = DB::table('order_items as oi')
                ->join('products as p', 'oi.product_id', '=', 'p.id')
                ->whereIn('oi.order_id', $orderIds)
                ->select('oi.order_id', 'p.name as product_name', 'oi.quantity', 'oi.unit_price', 'oi.total_price')
                ->get()
                ->groupBy('order_id');

            // Append items to each order
            $ordersWithItems = $orders->map(function ($order) use ($items) {
                return [
                    'id' => $order->id,
                    'order_number' => $order->order_number,
                    'order_date' => $order->order_date,
                    'notes' => $order->notes,
                    'status' => $order->status,
                    'vendor_name' => $order->vendor_name,
                    'items' => $items->get($order->id)?->values() ?? []
                ];
            });

            return response()->json([
                'message' => 'Orders fetched successfully',
                'data' => $ordersWithItems
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
