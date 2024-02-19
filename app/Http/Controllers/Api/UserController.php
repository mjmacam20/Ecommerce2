<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Models\User;
use App\Models\Vendor;
use App\Models\Cart;
use Validator;
use Session;
use Hash;
use Auth;


class UserController extends Controller
{
 
    public function test($id=null){
        return $id?Vendor::find($id):Vendor::all(); 
    }

    public function register(Request $request)
{
    $validator = Validator::make($request->all(), [
        'name' => 'required|string|max:100',
        'email' => 'required|email|unique:users',
        'password' => 'required|min:8|max:100',
        'mobile' => 'required|numeric|digits:11',
        'age' => 'required|min:2|max:100',
        'gender' => 'required',
        'status' => 'required|in:0,1',
    ]);

    if ($validator->fails()) {
        return response()->json([
            'message' => 'Validation failed',
            'status' => 'failed',
            'errors' => $validator->messages(),
        ], 422);
    }

    if (User::where('email', $request->email)->first()) {
        return response()->json([
            'message' => 'Email already exists',
            'status' => 'failed',
        ], 200);
    }

    $user = User::create([
        'name' => $request->name,
        'email' => $request->email,
        'password' => Hash::make($request->password),
        'mobile' => $request->mobile,
        'age' => $request->age,
        'gender' => $request->gender,
        'status' => $request->status,
    ]);

    if ($user->status == 0) {
        // Send activation email
        $email = $request->email;
        $messageData = [
            'name' => $request->name,
            'mobile' => $request->mobile,
            'email' => $request->email,
            'code' => base64_encode($request->email),
        ];
        Mail::send('emails.confirmation', $messageData, function ($message) use ($email) {
            $message->to($email)->subject('Confirm your account.');
        });

        return response([
            'message' => 'Registration Success. Please confirm your email to activate your account.',
            'status' => 'success',
        ], 201);
    }

    return response()->json([
        'message' => 'Registration Success',
        'status' => 'success',
        'user' => $user,
    ], 201);
}
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $user = User::where('email', $request->email)->first();

        if ($user && Hash::check($request->password, $user->password)) {
            if ($user->status == 0) {
                return response([
                    'message' => 'You account is not activated. Please confirm your account to activate',
                    'status' => 'inactive',
                ], 401);
            }

            $token = $user->createToken('api-token')->plainTextToken;

            return response([
                'message' => 'Login Success',
                'status' => 'success',
                'token' => $token,
                'user' => $user, // Include user details if needed
            ], 200);
        }

        return response([
            'message' => 'Invalid credentials.',
            'status' => 'failed',
        ], 401);
    }


    public function logout(Request $request){
        $request->user()->currentAccessToken()->delete();
        return response([
            'message' => 'Logout Success',
            'status' => 'success'
        ], 200);
    }
    
    public function get(Request $request){
        $loggeduser = auth()->user();
        $request->user()->currentAccessToken()->delete();
        return response([
            'user' => $loggeduser,
            'message' => 'User Data',
            'status' => 'success'
        ], 200);
    }
    public function change_password(Request $request){
        $request->validate([
            'password' => 'required|confirmed',
        ]);
        $loggeduser = auth()->user();
        $loggeduser->password = Hash::make($request->password);
        $loggeduser->save();
        return response([
            'message' => 'Password Changed Successfully',
            'status' => 'success'
        ], 200);
    }

}

