<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

use App\Models\Discount;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

 /**
     * @group Discount
     *
     * Danh sách api liên quan tới danh mục 
     */
class DiscountController extends Controller
{
   


    public function index()
    {
        /**
         * Danh sách mã giảm giá 
         *
         * 
         *Api hiển thị danh sách mã giảm giá ứng với từng user 
         *
         * @return \Illuminate\Http\JsonResponse
         */

        $user = Auth::user()->id;
        try {
            $data = Discount::select('*')->where('user_id', $user)->get();
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
         * Thêm mã giảm giá 
         *
         * 
         *Api  thêm mã giảm giá ứng với user đăng nhập 
         * @param Request $request
         * @return \Illuminate\Http\JsonResponse
         */
        $user = Auth::user()->id;
        $validator = Validator::make($request->all(), [
            'discount' => 'required|min:1|max:25',
            'product_id' => 'required|numeric|min:1|exists:products,id',
            'end_date' => 'date_format:H:i|after:time_start',
            'start_date' => 'date_format:H:i'

        ]);

        if ($validator->fails()) {
            return response()->json([
                'status_code' => 401,
                'errors' => $validator->errors()
            ]);
        }
        try {
            $data = new Discount();
            $data->discount = $request->discount;
            $data->product_id = $request->product_id;
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
        /**
         * Chỉnh sửa  mã giảm giá 
         *
         * 
         *Api  chỉnh sửa mã giảm giá ứng với user đăng nhập 
         * @param Request $request
         * @param id
         * @return \Illuminate\Http\JsonResponse
         */
        $user = Auth::user()->id;
        $validator = Validator::make($request->all(), [
            'discount' => 'required|min:1|max:25',
            'product_id' => 'required|numeric|min:1|exists:products,id',
            'end_date' => 'date_format:H:i|after:time_start',
            'start_date' => 'date_format:H:i'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status_code' => 401,
                'errors' => $validator->errors()
            ]);
        }

        try {
            $data = Discount::where('user_id', $user)->where('id', $id)
                ->update([
                    'discount' => $request->discount,
                    'product_id' => $request->product_id,
                    'end_date' => $request->end_date,
                    'start_date' => $request->start_date,
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
        /**
         * Hiển thị chi tiết  mã giảm giá 
         *
         * 
         *Api  hiển thị mã giảm giá ứng với user đăng nhập và id
         * @param Request $request
         * @param id
         * @return \Illuminate\Http\JsonResponse
         */
        $user = Auth::user()->id;
        try {
            $data = Discount::select('*')->where('user_id', $user)->where('id', $id)->get();
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
         * Xóa mềm  mã giảm giá 
         *
         * 
         *Api xóa mềm mã giảm giá ứng với user đăng nhập và id
         * @param Request $request
         * @param id
         * @return \Illuminate\Http\JsonResponse
         */

        $user = Auth::user()->id;
        try {
            Discount::where('id', $id)->where('user_id', $user)->delete();
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
