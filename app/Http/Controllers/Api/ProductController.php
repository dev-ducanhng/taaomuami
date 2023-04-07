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

<<<<<<< HEAD
    public function show(Request $request, $id)
    {
        try {
            $dataProduct = Product::select('*')->where('id',  $id)->get();
=======
    public function show(Request $request,$id)
    {
        try {
            $dataProduct = Product::select('*')->where('id', $id)->first();
>>>>>>> fd44de15f497f5fb824483ce764c958d34f86394
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
           'user_id'=>'required|numeric|min:1'
>>>>>>> fd44de15f497f5fb824483ce764c958d34f86394
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status_code' => 401,
                'errors' => $validator->errors()
            ]);
        }
<<<<<<< HEAD

        try {
            $dataProduct = new Product();
            $dataProduct->name = $request->name;
            $dataProduct->user_id = $request->user_id;
=======
    
        try {
            $dataProduct = new Product();
            $dataProduct->name= $request->name;
            $dataProduct->user_id= $request->user_id;
>>>>>>> fd44de15f497f5fb824483ce764c958d34f86394
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
<<<<<<< HEAD
        $validator = Validator::make($request->all(), [
            'name' => 'required|min:1|max:25',

=======
    
        $validator = Validator::make($request->all(), [
            'name' => 'required|min:1|max:25',
           
>>>>>>> fd44de15f497f5fb824483ce764c958d34f86394
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status_code' => 401,
                'errors' => $validator->errors()
<<<<<<< HEAD
=======
            ]);
        }
        try {
            $dataProduct = Product::where('id',$request->id)
            ->update([
                'name'=> $request->name,
>>>>>>> fd44de15f497f5fb824483ce764c958d34f86394
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
    public function delete(Request $request,$id)
>>>>>>> fd44de15f497f5fb824483ce764c958d34f86394
    {
        try {
            $dataProduct = Product::find($id);
<<<<<<< HEAD
            if ($dataProduct) {
                $dataProduct->delete();
            }

            return response([
                'status_code' => 200,
                'message' => 'xoa thanh cong '
=======
            if($dataProduct){
                $dataProduct->delete();
            }
       
            return response([
                'status_code' => 200,
                'message' => 'Xóa sản phẩm thành công'
>>>>>>> fd44de15f497f5fb824483ce764c958d34f86394
            ]);
        } catch (\Exception $error) {
            return response()->json([
                'status_code' => 500,
                'error' => $error,
            ]);
        }
    }
}
