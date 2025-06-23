<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Traits\SendEmail;
use Illuminate\Support\Str;

class AuthorizationController extends Controller
{
    use SendEmail;
    public function userRegister(Request $request)
    {
        try{
            // $this->validate($request, [
            //     'name' => 'required|string|max:255',
            //     'email' => 'required|string|email|max:255|unique:users',
            //     'password' => 'required|string|min:8',
            // ]);
            $token = Str::random(60); // Generate a random token
            $user = new User();
            $user->name = $request->input('name');
            $user->email = $request->input('email');
            $user->password = bcrypt($request->input('password'));
            $user->email_verification_token = $token; // Generate a random token
            $user->save();

            $this->sendEmail('email.VerifyEmail',$user->id, $user->email, $token, 'Email verification', $user->password,'rabin@gmail.com','rabin');
            return response()->json([
                'status' => 1,
                'message' => 'User registered successfully. Please check your email for verification.',
                'data' => $user
            ]);
        }
        catch (\Exception $e) {
            return response()->json(['error' => 'Registration failed: ' . $e->getMessage()], 500);
        }
    }
}
