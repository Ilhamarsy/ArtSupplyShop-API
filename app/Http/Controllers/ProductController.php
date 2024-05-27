<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class ProductController extends Controller
{
    public function post(Request $request) {
        $name = $request->name;
        $photo = $request->photo;
        $price = $request->price;
        $about = $request->about;
        $category_id = $request->category_id;

        $newProduct = Product::create([
            "name" => $name,
            "photo" => $photo,
            "price" => $price,
            "about" => $about,
            "category_id" => $category_id,
            "is_delete" => false,
        ]);

        return response(
            [
                "status" => "success",
                "data" => $newProduct,
            ],
            201
        );
    }

    public function get() {
        $products = Product::with("category")->get();
        return response(
            [
                "status" => "success",
                "data" => $products,
            ],
            200
        );
    }

    public function put(Request $request) {
        $id = $request->route("ProductId");
        $name = $request->name;
        $photo = $request->photo;
        $price = $request->price;
        $about = $request->about;
        $category_id = $request->category_id;

        $product = Product::where("id", $id)->first();

        if (!$product) {
            return response(
                [
                    "status" => "fail",
                    "message" => "Product tidak ditemukan",
                ],
                404
            );
        } else {
            $product->update([
                "name" => $name,
                "photo" => $photo,
                "price" => $price,
                "about" => $about,
                "category_id" => $category_id,
                "is_delete" => false,
            ]);
            return response(
                [
                    "status" => "success",
                    "message" => "Data berhasil diupdate",
                ],
                200
            );
        }

    }

    public function delete(Request $request) {
        $id = $request->route("ProductId");

        $product = Product::where("id", $id)->first();

        if (!$product) {
            return response(
                [
                    "status" => "fail",
                    "message" => "Product tidak ditemukan",
                ],
                404
            );
        } else {
            $product->delete();
            return response(
                [
                    "status" => "success",
                    "message" => "Berhasil menghapus product",
                ],
                200
            );
        }
    }
}