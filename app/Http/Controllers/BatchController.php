<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Batch;
use DB;

class BatchController extends Controller
{
    public function index() {
        try {
            $batch = DB::table('batches as b')
                    ->join('products as p', 'b.product_id', '=', 'p.id')
                    ->join('vendors as v', 'b.vendor_id', '=', 'v.id')
                    ->select('b.id','p.name as product_name', 'b.quantity','b.avaiable_quantity','b.received_date','v.company_name as vendor_name')
                    ->where('b.delete_status', 1)
                    ->get();
            return response()->json([
                'status' => 1,
                'data' => $batch
            ]);
        }
        catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function store(Request $request) {
        try {
            $batch = new Batch();
            $batch->product_id = $request->product_id;
            $batch->quantity = $request->quantity;
            $batch->avaiable_quantity = $request->avaiable_quantity;
            $batch->received_date = $request->received_date;
            $batch->vendor_id = $request->vendor_id;
            $batch->save();
            return response()->json([
                'status' => 1,
                'message' => 'Batch saved successfully.',
                'data' => $batch
            ]);
        }
        catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function getOneBatch ($id) {
        try {
            $batch = Batch::where("id", $id)->where("delete_status", 1)->first();
            return response()->json([
                'status' => 1,
                'data' => $batch
            ]);
        }
        catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function update(Request $request, $id) {
        try {
            $batch = Batch::findOrFail($id);
            $batch->product_id = $request->product_id;
            $batch->quantity = $request->quantity;
            $batch->avaiable_quantity = $request->avaiable_quantity;
            $batch->received_date = $request->received_date;
            $batch->vendor_id = $request->vendor_id;
            $batch->save();
            return response()->json([
                'status' => 1,
                'message' => 'Batch updated successfully.',
                'data' => $batch
            ]);
        }
        catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function destroy($id) {
        try {
            $batch = Batch::findOrFail($id);
            $batch->delete_status = 0;
            $batch->save();
            return response()->json([
                'status' => 1,
                'message' => 'Batch deleted successfully.',
                'data' => $batch
            ]);
        }
        catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
