<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Coupon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class CouponController extends Controller
{
    public function index()
    {
        $user = Auth::user()->id;
        try {
            $data = Coupon::select('name')->where('user_id', $user)->get();
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

    public function store(Request $request)
    {
        $user = Auth::user()->id;
        $validator = Validator::make($request->all(), [
            'name' => 'required|min:1|max:25',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status_code' => 401,
                'errors' => $validator->errors()
            ]);
        }
        try {
            $data = new Coupon();
            $data->name = $request->name;
            $data->value = $request->value;
            $data->user_id =  $user;
            $data->save();
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

    public function update(Request $request, $id)
    {
        $user = Auth::user()->id;
        $validator = Validator::make($request->all(), [
            'name' => 'required|min:1|max:25',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status_code' => 401,
                'errors' => $validator->errors()
            ]);
        }

        try {
            $data = Coupon::where('user_id', $user)->where('id', $id)
                ->update([
                    'name' => $request->name,
                    'value' => $request->value
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

    public function show($id)
    {
        $user = Auth::user()->id;
        try {
            $data = Coupon::select('*')->where('user_id', $user)->where('id', $id)->get();
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

    public function delete($id)
    {
        try {
            Coupon::where('id', $id)->delete();
            return response([
                'status_code' => 200,
                'message' => 'xoa thanh cong'
            ]);
        } catch (\Exception $error) {
            return response()->json([
                'status_code' => 500,
                'error' => $error,
            ]);
        }
    }
}
