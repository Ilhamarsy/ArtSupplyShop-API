<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function post(Request $request) {
        $name = $request->name;

        $newCategory = Category::create([
            "name" => $name,
        ]);

        return response(
            [
                "status" => "success",
                "data" => $newCategory,
            ],
            201
        );
    }

    public function get() {
        $categories = Category::get();

        return response(
            [
                "status" => "success",
                "data" => $categories,
            ],
            200
        );
    }

    public function delete(Request $request) {
        $id = $request->route("CategoryId");

        $category = Category::where("id", $id)->first();

        if (!$category) {
            return response(
                [
                    "status" => "fail",
                    "message" => "Category tidak ditemukan",
                ],
                404
            );
        } else {
            $category->delete();
            return response(
                [
                    "status" => "success",
                    "message" => "Berhasil menghapus Category",
                ],
                200
            );
        }
    }
}
