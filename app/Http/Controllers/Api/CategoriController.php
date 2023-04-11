<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

use App\Models\Categories;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;


/**
 * @group Category
 *
 * Danh sách api liên quan tới danh mục 
 */
class CategoriController extends Controller
{

    /**
     * Danh sách danh mục 
     *
     * 
     *Api hiển thị danh sách danh mục sản phẩm 
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
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
        /**
         * Thêm danh mục sản phẩm 
         *
         * Api thêm danh mục mới 
         *
         * @param Request $request
         * @return \Illuminate\Http\JsonResponse
         */
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


    public function show($id)
    {
        /**
         * Hiển thị chi tiết danh mục 
         *
         * Api hiển thị chi tiết danh mục và sản phẩm theo danh mục 
         *
         * @param Request $request
         * * @param  id
         * @return \Illuminate\Http\JsonResponse
         */
        try {
            $data = Categories::select('name')->where('id', $id)->first();
            $dataProduct = Product::select('*')->where('category_id', $id)->get();
            foreach ($dataProduct as $pr) {
                $pr->discount = DB::table('discounts')
                    ->select('discount', 'product_id', DB::raw('count(*)'))
                    ->groupBy('discount', 'product_id')->where('deleted_at', null)
                    ->where('product_id', $pr->id)
                    ->get();
            }
            return response([
                'status_code' => 200,
                'data' => $data,
                'dataPro' => $dataProduct
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
        /**
         * Chỉnh sửa  danh mục 
         *Api chỉnh sửa  danh mục sản phẩm theo id 
         * Validator dữ liệu đầu vào 
         *
         * @param Request $request
         * @param id 
         * @return \Illuminate\Http\JsonResponse
         */
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
        /**
         * xóa mềm danh mục 
         *Api xóa mềm  danh mục sản phẩm theo id 
         *  
         *
         * @param Request $request
         * @param id 
         * @return \Illuminate\Http\JsonResponse
         */
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
