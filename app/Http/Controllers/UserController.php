<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function register(Request $request) {
        $name = $request->name;
        $email = $request->email;
        $password = Hash::make($request->password);
        $role = Role::where("name", "user")->first();

        $newUser = User::create([
            "name" => $name,
            "email" => $email,
            "password" => $password,
            "role_id" => $role->id,
        ]);

        return response(
            [
                "status" => "success",
                "data" => $newUser,
            ],
            201
        );
    }

    public function login(Request $request) {
        $email = $request->email;
        $password = $request->password;

        $user = User::where("email", $email)->first();

        if(!$user || !Hash::check($password, $user->password)) {
            return response(
                [
                    "status" => "fail",
                    "message" => "email atau password salah",
                ],
                401
            );
        }

        $token = create_jwt($user);

        return response(
            [
                "status" => "success",
                "message" => "login berhasil",
                "token" => $token,
            ],
            200
        );
    }

    public function profile(Request $request) {
        $user = User::with("addresses")->where("id", $request->id)->first();

        return response(
            [
                "status" => "success",
                "data" => $user,
            ],
            200
        );
    }
}
