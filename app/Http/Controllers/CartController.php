<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function post(Request $request) {
        $product_id = $request->product_id;
        $qty = $request->qty;

        if ($qty == 0) {
            return response(
                [
                    "status" => "fail",
                    "message" => "qty harus lebih besar dari 0",
                ],
                401
            );
        }

        $cart = Cart::updateOrCreate(
            ['user_id' => $request->id, 'product_id' => $product_id],
            ['qty' => $qty]
        );

        return response(
            [
                "message" => "success",
                "data" => $cart,
            ],
            201
        );
    }

    public function get(Request $request) {
        $user_id = $request->id;

        $carts = Cart::with("product")->where("user_id", $user_id)->get();

        return response(
            [
                "message" => "success",
                "data" => $carts,
            ],
            200
        );
    }

    public function delete(Request $request) {
        $id = $request->route("CartId");

        $cart = Cart::where("id", $id)->where("user_id", $request->id)->first();

        if (!$cart) {
            return response(
                [
                    "status" => "fail",
                    "message" => "cart tidak ditemukan",
                ],
                404
            );
        } else {
            $cart->delete();
            return response(
                [
                    "status" => "success",
                    "message" => "Berhasil menghapus cart",
                ],
                200
            );
        }
    }
}
