<?php

use App\Http\Controllers\CartController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\UserAddressController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\CekRoleAdmin;
use App\Http\Middleware\CekToken;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


// User
Route::post("/customer/register", [UserController::class, "register"]);
Route::get("/customer/profile", [UserController::class, "profile"])->middleware([CekToken::class]);

// All - user
Route::post("/login", [UserController::class, "login"]);
Route::get("/product", [ProductController::class, "get"])->middleware([CekToken::class]);

// User Address
Route::post("/customer/profile/address", [UserAddressController::class, "post"])->middleware([CekToken::class]);
Route::get("/customer/profile/address", [UserAddressController::class, "get"])->middleware([CekToken::class]);
Route::delete("/customer/profile/address/{AddressId}", [UserAddressController::class, "delete"])->middleware([CekToken::class]);

// User Cart
Route::post("/customer/cart", [CartController::class, "post"])->middleware([CekToken::class]);
Route::get("/customer/cart", [CartController::class, "get"])->middleware([CekToken::class]);
Route::delete("/customer/cart/{CartId}", [CartController::class, "delete"])->middleware([CekToken::class]);

// User CheckOut
Route::post("/customer/transaction", [TransactionController::class, "post"])->middleware([CekToken::class]);

// User Transaction
Route::get("/customer/transaction", [TransactionController::class, "get"])->middleware([CekToken::class]);
Route::get("/customer/transaction/{TransactionId}", [TransactionController::class, "getDetail"])->middleware([CekToken::class]);


// Admin Category
Route::get("/admin/category", [CategoryController::class, "get"])->middleware([CekToken::class, CekRoleAdmin::class]);
Route::post("/admin/category", [CategoryController::class, "post"])->middleware([CekToken::class, CekRoleAdmin::class]);
Route::delete("/admin/category/{CategoryId}", [CategoryController::class, "delete"])->middleware([CekToken::class, CekRoleAdmin::class]);

// Admin Product
Route::post("/admin/product", [ProductController::class, "post"])->middleware([CekToken::class, CekRoleAdmin::class]);
Route::put("/admin/product/{ProductId}", [ProductController::class, "put"])->middleware([CekToken::class, CekRoleAdmin::class]);
Route::delete("/admin/product/{ProductId}", [ProductController::class, "delete"])->middleware([CekToken::class, CekRoleAdmin::class]);