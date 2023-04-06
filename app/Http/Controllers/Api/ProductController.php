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

    public function request(Request $request)
    {
        try {
            $dataProduct = Product::select('*')->where('id', $request->id)->get();
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

    public function addProduct(Request $request)
    {
    
        try {
            $dataProduct = new Product();
            $dataProduct->name= $request->name;
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

    public function update(Request $request)
    {
    
        try {
            $dataProduct = Product::where('id',$request->id)
            ->update([
                'name'=> $request->name,
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

    public function delete(Request $request)
    {
    
        try {
            $dataProduct = Product::where('id',$request->id)
            ->update([
                'is_deleted'=>1,
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
}
