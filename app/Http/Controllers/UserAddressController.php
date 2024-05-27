<?php

namespace App\Http\Controllers;

use App\Models\UserAddress;
use Illuminate\Http\Request;

class UserAddressController extends Controller
{
    public function post(Request $request) {
        $address = $request->address;
        $city = $request->city;
        $post_code = $request->post_code;
        $phone_number = $request->phone_number;
        $notes = $request->notes;

        $newAddress = UserAddress::create([
            "address" => $address,
            "city" => $city,
            "post_code" => $post_code,
            "phone_number" => $phone_number,
            "notes" => $notes,
            "user_id" => $request->id,
        ]);

        return response(
            [
                "message" => "success",
                "data" => $newAddress,
            ],
            201
        );
    }

    public function get(Request $request) {
        $addresses = UserAddress::where("user_id", $request->id)->get();

        return response(
            [
                "status" => "success",
                "data" => $addresses,
            ],
            200
        );
    }

    public function delete(Request $request) {
        $id = $request->route("AddressId");

        $address = UserAddress::where("id", $id)->where("user_id", $request->id)->first();

        if (!$address) {
            return response(
                [
                    "status" => "fail",
                    "message" => "address tidak ditemukan",
                ],
                404
            );
        } else {
            $address->delete();
            return response(
                [
                    "status" => "success",
                    "message" => "Berhasil menghapus address",
                ],
                200
            );
        }
    }
}
