<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Categories;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;


/**
 * @group Product
 *
 * Danh sách api liên quan tới sản phẩm 
 */
class ProductController extends Controller
{
    /**
     * Danh sách sản phẩm 
     *
     * API này sẽ trả về thông tin hiển thị sản phẩm và mã giảm giá theo từng sản phẩm 
     *list ra mã giảm giá cho người dùng lựa chọn 
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $limit = $request->limit ?? 10;

        try {
            $data = DB::table('products')
                ->join('categories', 'products.category_id', '=', 'categories.id')
                ->select(
                    'products.id',
                    'category_id',
                    'products.name as product_name',
                    'categories.name as categories_name'
                )
                ->where('products.deleted_at', '=', null)
                ->paginate($limit);

            foreach ($data as $d) {
                $d->discount = DB::table('discounts')
                    ->select('discount', 'product_id', DB::raw('count(*)'))
                    ->groupBy('discount', 'product_id')->where('deleted_at', null)
                    ->where('product_id', $d->id)
                    ->get();
            }

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



    /**
     * Chi tiết sản phẩm theo id 
     *
     * API này sẽ trả về thông tin hiển thị sản phẩm và mã giảm giá theo từng sản phẩm 
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        try {

            $dataProduct = DB::table('products')
                ->join('discounts', 'products.id', '=', 'discounts.product_id')
                ->select('discount', 'name', 'products.user_id', 'products.image', 'products.category_id')
                ->where('products.deleted_at', '=', null)
                ->where('products.id',  $id)
                ->get();

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

    /**
     * Thêm sản phẩm 
     *
     * API này thêm thông tin sản phẩm vào db 
     * list ra mã giảm giá cho người dùng lựa chọn 
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {

        $data = DB::table('products')
            ->join('categories', 'products.category_id', '=', 'categories.id')
            ->select(
                'products.id',
                'category_id',
                'products.name as product_name',
                'categories.name as categories_name'
            )
            ->where('products.deleted_at', '=', null)
            ->get();
        foreach ($data as $d) {
            $d->discount = DB::table('discounts')
                ->select('discount', 'product_id', DB::raw('count(*)'))
                ->groupBy('discount', 'product_id')->where('deleted_at', null)
                ->where('product_id', $d->id)
                ->get();
        }

        $validator = Validator::make($request->all(), [
            'name' => 'required|min:1|max:25',
            'category_id' => 'required|numeric|min:1|exists:categories,id'
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
            $dataProduct->category_id = $request->category_id;
            $dataProduct->save();

            return response([
                'status_code' => 200,
                'dataPro' => $dataProduct,
                'data' => $data
            ]);
        } catch (\Exception $error) {
            return response()->json([
                'status_code' => 500,
                'error' => $error,
            ]);
        }
    }

    /**
     * Chỉnh sửa thông tin sản phẩm  
     *
     * API này sửa thông tin sản phẩm và lưu vào db 
     * list ra mã giảm giá cho người dùng lựa chọn 
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */

    public function update(Request $request, $id)
    {

        $data = DB::table('products')
            ->join('categories', 'products.category_id', '=', 'categories.id')
            ->select(
                'products.id',
                'category_id',
                'products.name as product_name',
                'categories.name as categories_name'
            )
            ->where('products.deleted_at', '=', null)
            ->get();
        foreach ($data as $d) {
            $d->discount = DB::table('discounts')
                ->select('discount', 'product_id', DB::raw('count(*)'))
                ->groupBy('discount', 'product_id')->where('deleted_at', null)
                ->where('product_id', $d->id)
                ->get();
        }
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

    /**
     * Xóa mềm dữ liệu 
     *
     * API này xóa mềm dữ liệu dựa vào id và lưu vào db
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */

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
