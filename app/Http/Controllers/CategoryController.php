<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;

class CategoryController extends Controller
{

    public function index() {
        try {
            $categories = Category::where("delete_status", 1)->get();
            return response()->json([
                'status' => 1,
                'data' => $categories
            ]);
        }
        catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function store(Request $request) {
        try {
            $category = new Category();
            $category->name = $request->name;
            $category->save();
            return response()->json([
                'status' => 1,
                'message' => 'Category saved successfully.',
                'data' => $category
            ]);
        }
        catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function update(Request $request, $id) {
        try {
            $category = Category::findOrFail($id);
            $category->name = $request->name;
            $category->save();
            return response()->json([
                'status' => 1,
                'message' => 'Category updated successfully.',
                'data' => $category
            ]);
        }
        catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function getOneCategory($id) {
        try {
            $category = Category::where("id", $id)->where("delete_status", 1)->first();
            return response()->json([
                'status' => 1,
                'data' => $category
            ]);
        }
        catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function destroy($id) {
        try {
            $category = Category::findOrFail($id);
            $category->delete_status = 0;
            $category->save();
            return response()->json([
                'status' => 1,
                'message' => 'Category deleted successfully.',
                'data' => $category
            ]);
        }
        catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
