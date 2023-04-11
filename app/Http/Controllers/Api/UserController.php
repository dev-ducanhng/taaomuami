<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

/**
 * @group User
 *
 * Danh sách Api liên quan tới User 
 */
class UserController extends Controller
{
    public function index()
    {
        /**
         * Danh sách user 
         *
         * API này sẽ trả về thông tin hiển thị user 
         *
         * 
         * @return \Illuminate\Http\JsonResponse
         */
        try {
            $data = User::all();
            return response([
                'status_code' => 200,
                'data' => $data
            ]);
        } catch (\Exception $error) {
            return response()->json([
                'status_code' => 500,
                'error' => $error,
            ]);
        }
    }

    public function update(Request $request)
    {
        /**
         * Chỉnh sửa thông tin user  
         *
         * API này sẽ Chỉnh sửa thông tin user 
         *validator dữ liệu đầu vào 
          * @param Request $request
         * @return \Illuminate\Http\JsonResponse
         */
        $user = Auth::user()->id;

        $validator = Validator::make($request->all(), [
            'name' => 'required|min:1|max:25',
            'email' => 'email:rfc,dns',
            'password' => 'required|between:4,20|confirmed',
            'password_confirmation' => 'same:password'

        ]);

        if ($validator->fails()) {
            return response()->json([
                'status_code' => 401,
                'errors' => $validator->errors()
            ]);
        }

        try {
            $data = User::where('id', $user)
                ->update([
                    'name' => $request->name,
                    'email' => $request->email,
                    'password' => Hash::make($request->password)
                ]);
            return response([
                'status_code' => 200,
                'data' => $data
            ]);
        } catch (\Exception $error) {
            return response()->json([
                'status_code' => 500,
                'error' => $error,
            ]);
        }
    }
}
