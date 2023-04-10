<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

use App\Models\Categories;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CategoriController extends Controller
{
    public function index()
    {

        try {
            $data = Categories::all();

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
        $validator = Validator::make($request->all(), [
            'name' => 'required|min:1|max:25'
        ]);
        if ($validator->fails()) {
            return response()->json([
                'status_code' => 401,
                'errors' => $validator->errors()
            ]);
        }
        try {
            $data = new Categories;
            $data->name = $request->name;
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

    public function show(Request $request, $id)
    {

        try {
            $data = Categories::select('name')->where('id', $id)->first();
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
            $data = Categories::where('id', $id)
                ->update([
                    'name' => $request->name,
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
    public function delete($id)
    {

        try {
            $data = Categories::find($id);
            if ($data) {
                $data->delete();
                Product::where('categori_id', $id)->delete();
            }
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
