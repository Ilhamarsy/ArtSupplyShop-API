<?php

use App\Models\Role;
use Firebase\JWT\JWT;

if (! function_exists('create_jwt')) {
  function create_jwt($user) {
    $key = env("JWT_SECRET");

    $role = Role::where("id", $user->role_id)->first();
    $payload = [
      "data" => [
        "id" => $user->id,
        "name" => $user->name,
        "email" => $user->email,
        "role" => $role->name,
      ],
      "iat" => time(),
      "exp" => time() + 3600,
    ];
    $hash = env("JWT_HASH");

    $token = JWT::encode($payload, $key, $hash);

    return $token;
  }
}