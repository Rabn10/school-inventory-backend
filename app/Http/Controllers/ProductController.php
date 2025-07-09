<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class ProductController extends Controller
{

    public function index() {
        try {
            $products = Product::where("delete_status", 1)->get();
            return response()->json([
                'status' => 1,
                'data' => $products
            ]);
        }
        catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function store(Request $request)
    {
        try {
            $product = new Product();
            $product->name = $request->name;
            $product->price = $request->price;
            $product->category_id = $request->category_id;
            $product->description = $request->description;
            $product->save();
            return response()->json([
                'status' => 1,
                'message' => 'Product saved successfully.',
                'data' => $product
            ]);
        }
        catch(\Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function update(Request $request, $id) {
        try {
            $product = Product::findOrFail($id);
            $product->name = $request->name;
            $product->price = $request->price;
            $product->category_id = $request->category_id;
            $product->description = $request->description;
            $product->save();
            return response()->json([
                'status' => 1,
                'message' => 'Product updated successfully.',
                'data' => $product
            ]);
        }
        catch(\Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function getOneProduct($id) {
        try {
            $product = Product::where("id", $id)->where("delete_status",1)->first();
            return response()->json([
                'status' => 1,
                'data' => $product
            ]);
        }
        catch(\Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function destroy($id) {
        try {
            $product = Product::findOrFail($id);
            $product->delete_status = 0;
            $product->save();
             return response()->json([
                'status' => 1,
                'message' => 'Product deleted successfully.',
                'data' => $product
            ]);
        }
        catch(\Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ], 500);
        }

    }
}
