<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Transaction;
use App\Models\TransactionItem;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function post(Request $request) {
        $user_id = $request->id;
        $address_id = $request->address_id;
        $total_amount = 0;

        $carts = Cart::with("product")->where("user_id", $user_id)->get();

        foreach ($carts as $key => $value) {
            $total_amount += $value->product->price * $value->qty;
        }

        $transaction = Transaction::create([
            "user_address_id" => $address_id,
            "user_id" => $request->id,
            "total_amount" => $total_amount,
            "is_paid" => false
        ]);


        foreach ($carts as $key => $value) {
            TransactionItem::create([
                "transaction_id" => $transaction->id,
                "product_id" => $value->product->id,
                "price" => $value->product->price * $value->qty,
                "qty" => $value->qty,
            ]);

            Cart::where("user_id", $request->id)->where("product_id", $value->product->id)->delete();
        }

        return response(
            [
                "status" => "success",
                "message" => "Berhasil membuat transaksi",
            ],
            201
        );
    }

    public function get(Request $request) {
        $transaction = Transaction::where("user_id", $request->id)
        ->with("address")
        ->with("user")
        ->get();

        return response(
            [
                "status" => "success",
                "data" => $transaction,
            ],
            200
        );
    }

    public function getDetail(Request $request) {
        $id = $request->route("TransactionId");

        $transaction = Transaction::where("user_id", $request->id)
        ->where("id", $id)
        ->with("items")
        ->with("address")
        ->with("user")
        ->get();

        return response(
            [
                "status" => "success",
                "data" => $transaction,
            ],
            200
        );
    }
}
