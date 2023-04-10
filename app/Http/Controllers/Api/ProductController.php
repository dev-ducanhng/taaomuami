<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Categories;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    public function index()
    {

        try {
            $data = DB::table('products')
                ->join('categories', 'products.categori_id', '=', 'categories.id')
                ->select('products.name as product_name  ', 'categories.name as categories_name')
                ->get();
           
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
            'price' => 'required|numeric|min:1',
            'category_id'=>'required|numeric|min:1|exists:categories,id'


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
            $dataProduct->user_id = Auth::id();

            $dataProduct->price = $request->price;
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


    public function delete($id)

    {
        try {
            $dataProduct = Product::find($id);


            if ($dataProduct) {
                $dataProduct->delete();
            }

            return response([
                'status_code' => 200,

                'message' => 'xoa thanh cong '

            ]);
        } catch (\Exception $error) {
            return response()->json([
                'status_code' => 500,
                'error' => $error,
            ]);
        }
    }
}
