<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Throwable;

class AuthController extends Controller
{
    public function register(Request $request)
    {

            $request->validate([
                'name' => 'required',
                'email' => 'required|email|max:255|unique:users',
                'password' => 'required|min:8',
            ]);
    
            $user = new User();
            $user->name = $request->name;
            $user->email = $request->email;
            $user->password = Hash::make($request->password);
            $user->save();

    
        return response()->json([
            'status' => 'ok',
            'message' => 'User Registered Successfully'
        ]);
    }



    public function login(Request $request)
    {

            $request->validate([
                'email' => 'required|email',
                'password' => 'required',
            ]);
    
            $user = User::where('email', $request['email'])->first();
    
            if (isset($user->id)) {
                if (Hash::check($request->password, $user->password)) {
                    $token = $user->createToken('auth_token')->plainTextToken;
                    return response()->json([
                        'status' => 'ok',
                        'message' => 'User Logged',
                        'access_token' => $token
                    ]);
                } else {
                    return response()->json(
                        [
                            'status' => 'error',
                            'message' => 'Incorrect Password',
                        ],
                        404
                    );
                }
            } else {
                return response()->json([
                    'status' => 'error',
                    'message' => 'No user found',
                ], 404);
            };

    }
    public function userInfo()
    {

        $user = auth()->user();

        return response ()->json([
            'status'=>'ok',
            'message' => 'User Info',
            'data' => $user
       ]);
    
    }


    public function userUpdateOptionalInfo(Request $request, $id)
    {

        $user = User::findOrFail($id);
        
        $user->update($request->all());
        
        return response()->json([
            'status'=>'ok',
            'message' => 'User Updated',
            'data' => $user
        ]);

   
    }


    public function logout(Request $request)
    {
            $request->user()->tokens()->delete();

        return response()->json(
            [
                'status'=>'ok',
                'message' => 'Logged out'
            ]
        );
    }
}
