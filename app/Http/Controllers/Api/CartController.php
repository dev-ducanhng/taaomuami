<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class CartController extends Controller
{
    public function index()
    {
        try {
            $user = Auth::user()->id;
            $data =  DB::table('users')
                ->join('products', 'users.id', '=', 'products.user_id')
                ->join('categories', 'products.categori_id', '=', 'categories.id')
                ->select('users.email', 'products.name as product_name', 'users.name as users_name', 'categories.name as categori_name')
                ->where('users.id', $user)
                ->where('products.deleted_at', null)
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

    public function store()
    {
        $user = Auth::user()->id;
        try {
            $data =  DB::table('users')
                ->join('products', 'users.id', '=', 'products.user_id')
                ->join('categories', 'products.categori_id', '=', 'categories.id')
                ->select('users.email', 'products.name as product_name', 'users.name as users_name', 'categories.name as categori_name', 'products.id as product_id', 'categories.id as categori_id')
                ->where('users.id', $user)
                ->where('products.deleted_at', null)
                ->first();

            $dataCart = new Cart();
            $dataCart->user_id = $user;
            $dataCart->product_id = $data->product_id;
            $dataCart->categori_id = $data->categori_id;
            $dataCart->save();
            return response([
                'status_code' => 200,
                'data' => $dataCart
            ]);
        } catch (\Exception $error) {
            return response()->json([
                'status_code' => 500,
                'error' => $error,
            ]);
        }
    }

    public function delete()
    {
        $user = Auth::user()->id;

        try {
            Cart::where('user_id', $user)->delete();
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
