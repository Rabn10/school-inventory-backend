<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Vendor;

class VendorController extends Controller
{

    public function index() {
        try {
            $vendors = Vendor::where("delete_status", 1)->get();
            return response()->json([
                'status' => 1,
                'data' => $vendors
            ]);
        }
        catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function store(Request $request) {
        try {
            $vendor = new Vendor();
            $vendor->company_name = $request->company_name;
            $vendor->address = $request->address;
            $vendor->phone = $request->phone;
            $vendor->email = $request->email;
            $vendor->contact_person = $request->contact_person;
            $vendor->website = $request->website;
            $vendor->save();
            return response()->json([
                'status' => 1,
                'message' => 'Vendor saved successfully.',
                'data' => $vendor
            ]);
        }
        catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function getOneVendor($id) {
        try{
            $vendor = Vendor::where("id", $id)->where("delete_status", 1)->first();
            return response()->json([
                'status' => 1,
                'data' => $vendor
            ]);
        }
        catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function update(Request $request, $id) {
        try{
            $vendor = Vendor::findOrFail($id);
            $vendor->company_name = $request->company_name;
            $vendor->address = $request->address;
            $vendor->phone = $request->phone;
            $vendor->email = $request->email;
            $vendor->contact_person = $request->contact_person;
            $vendor->website = $request->website;
            $vendor->save();
            return response()->json([
                'status' => 1,
                'message' => 'Vendor updated successfully.',
                'data' => $vendor
            ]);
        }
        catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function destroy($id) {
        try {
            $vendor = Vendor::findOrFail($id);
            $vendor->delete_status = 0;
            $vendor->save();
            return response()->json([
                'status' => 1,
                'message' => 'Vendor deleted successfully.',
                'data' => $vendor
            ]);
        }
        catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
