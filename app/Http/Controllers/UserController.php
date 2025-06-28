<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function update(Request $request,$id)
    {
        try{
            // Get the authenticated user's ID
            $authUserId = Auth::id();

            // Check if the authenticated user is trying to update their own details
            if ($authUserId != $id) {
                return response()->json(['error' => 'Unauthorized.'], 403);
            }

            $user = User::findOrFail($id);
            $user->name = $request->name;
            $user->email = $request->email;
            $user->save();

            return response()->json([
                'message' => 'User updated successfully.',
                'user' => $user
            ]);
        }
        catch(\Exception $e){
            return response()->json(['error' => 'An error occurred while updating the user.'], 500);
        }
    }

    public function getOneUser($id) {
        try {
            $user = User::findOrFail($id);
            return response()->json([
                'message' => 'User retrieved successfully.',
                'user' => $user
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'User not found.'], 404);
        }
    }

    public function changePassword(Request $request){
        $validator = Validator::make($request->all(), [
            'current_password' => 'required',
            'password' => 'required|min:8',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 0,
                'errors' => $validator->errors()
            ], 422);
        }
        try {
            $user = User::where('id', Auth::id())->first();
            if(!$user) {
                return response()->json([
                    'status' => 0,
                    'message' => 'No data found'
                ]);
            }

            $currentPassword = Hash::Check($request->current_password, $user->password);
            if(!$currentPassword) {
                return response()->json([
                    'status' => 0,
                    'message' => 'Current password is incorrect'
                ]);
            }

            $currentPasswordValidator = Hash::check($request->password, $user->password);
            if($currentPasswordValidator) {
                return response()->json([
                    'status' => 0,
                    'message' => 'New password cannot be the same as the current password'
                ]);
            }

            $user->password = Hash::make($request->password);
            $user->save();

            return response()->json([
                'status' => 1,
                'message' => 'Password changed successfully'
            ]);
        }
        catch (\Exception $e) {
            return response()->json(['error' => 'An error occurred while changing the password.'], 500);
        }
    }
}
