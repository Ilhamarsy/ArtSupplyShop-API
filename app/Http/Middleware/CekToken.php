<?php

namespace App\Http\Middleware;

use Closure;
use Exception;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CekToken
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $key = env("JWT_SECRET");
        $hash = env("JWT_HASH");
        $token = $request->header("Authorization");

        if (!$token) {
            return response(
                [
                    "status" => "fail",
                    "message" => "Unauthenticate",
                ],
                401
            );
        }

        $jwt_token = explode(" ", $token)[1];

        try{
            $payload = JWT::decode($jwt_token, new Key($key, $hash));
        } catch (Exception) {
            return response(
                [
                    "status" => "fail",
                    "message" => "Token expired",
                ],
                401
            );
        }

        $request["id"] = $payload->data->id;
        $request["role"] = $payload->data->role;

        return $next($request);
    }
}
