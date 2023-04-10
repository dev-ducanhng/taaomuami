<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    public function index()
    {

        try {

            $dataProduct = Product::all();
            return response([
                'status_code' => 200,
                'data' => $dataProduct
            ]);
            
        } catch (\Exception $error) {
            return response()->json([
                'status_code' => 500,
                'error' => $error,
            ]);
        }
    }

    public function show(Request $request, $id)
    {
        try {
            $dataProduct = Product::select('*')->where('id',  $id)->get();
            return response([
                'status_code' => 200,
                'data' => $dataProduct
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
        $validator = Validator::make($request->all(), [
            'name' => 'required|min:1|max:25',
            'user_id' => 'required|numeric|min:1'

        ]);

        if ($validator->fails()) {
            return response()->json([
                'status_code' => 401,
                'errors' => $validator->errors()
            ]);
        }

        try {
            $dataProduct = new Product();
            $dataProduct->name = $request->name;
            $dataProduct->user_id = $request->user_id;

            $dataProduct->save();

            return response([
                'status_code' => 200,
                'data' => $dataProduct
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
            $dataProduct = Product::where('id', $id)
                ->update([
                    'name' => $request->name,
                ]);
            return response([
                'status_code' => 200,
                'data' => $dataProduct
            ]);
        } catch (\Exception $error) {
            return response()->json([
                'status_code' => 500,
                'error' => $error,
            ]);
        }
    }

    public function delete(Request $request, $id)

    {
        try {
            $dataProduct = Product::find($id);
            if ($dataProduct) {
                $dataProduct->delete();
            }

            return response([
                'status_code' => 200,
                'message' => 'xóa thanh cong '

            ]);
        } catch (\Exception $error) {
            return response()->json([
                'status_code' => 500,
                'error' => $error,
            ]);
        }
    }
}
