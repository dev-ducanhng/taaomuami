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
                ->select('products.name as product_name  ', 'cost', 'promotional_price', 'categories.name as categories_name')
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

<<<<<<< HEAD
    public function show(Request $request, $id)
    {
        try {
            $dataProduct = Product::select('*')->where('id',  $id)->get();
=======

    public function show($id)
    {
        try {
            $dataProduct = Product::select('*')->where('id',  $id)->get();

>>>>>>> ee7cfcb0db10e18f9f3d332a6220db221aac011b
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
<<<<<<< HEAD
            'user_id' => 'required|numeric|min:1'

=======
>>>>>>> ee7cfcb0db10e18f9f3d332a6220db221aac011b
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
<<<<<<< HEAD

=======
            $dataProduct->cost = $request->cost;
            $dataProduct->promotional_price = promotionPercentage($dataProduct->cost,  $request->value);
>>>>>>> ee7cfcb0db10e18f9f3d332a6220db221aac011b
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

<<<<<<< HEAD

=======
>>>>>>> ee7cfcb0db10e18f9f3d332a6220db221aac011b
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status_code' => 401,
                'errors' => $validator->errors()
<<<<<<< HEAD
=======

>>>>>>> ee7cfcb0db10e18f9f3d332a6220db221aac011b
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

<<<<<<< HEAD
    public function delete(Request $request, $id)
=======

    public function delete($id)
>>>>>>> ee7cfcb0db10e18f9f3d332a6220db221aac011b

    {
        try {
            $dataProduct = Product::find($id);
<<<<<<< HEAD
=======

>>>>>>> ee7cfcb0db10e18f9f3d332a6220db221aac011b
            if ($dataProduct) {
                $dataProduct->delete();
            }

            return response([
                'status_code' => 200,
<<<<<<< HEAD
                'message' => 'xóa thanh cong '
=======
                'message' => 'xoa thanh cong '
>>>>>>> ee7cfcb0db10e18f9f3d332a6220db221aac011b

            ]);
        } catch (\Exception $error) {
            return response()->json([
                'status_code' => 500,
                'error' => $error,
            ]);
        }
    }
}
