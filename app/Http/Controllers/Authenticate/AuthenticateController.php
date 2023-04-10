<?php

namespace App\Http\Controllers\Authenticate;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthenticateController extends Controller
{
    public function login(Request $request)
    {
    
        try {
            $validator = Validator::make($request->all(), [
                'email' => 'required',
                'password' => 'required|numeric|min:1',
               
            ]);
    
            if ($validator->fails()) {
                return response()->json([
                    'status_code' => 401,
                    'errors' => $validator->errors()
                ]);
            }
         
            $credentials = request(['email', 'password']);
          
            if (!Auth::attempt($credentials)) {
                
                return response()->json([
                    'status_code' => 500,
                    'message' => 'Unauthorized'
                ]);
            }
        
            $user = User::where('email', $request->email)->first();
        
            if (!Hash::check($request->password, $user->password, [])) {
                throw new \Exception('Error in Login');
            }

            $tokenResult = $user->createToken('authToken')->plainTextToken;

            return response()->json([
                'status_code' => 200,
                'access_token' => $tokenResult,
                'token_type' => 'Bearer',
            ]);
        } catch (\Exception $error) {
            return response()->json([
                'status_code' => 500,
                'message' => 'Error in Login',
                'error' => $error,
            ]);
        }
    }
}
