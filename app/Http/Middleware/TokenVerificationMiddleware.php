<?php

namespace App\Http\Middleware;

use App\Helper\JWTToken;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class TokenVerificationMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {

        // $token = $request->header('token');
        $token = $request->cookie('token');
        $result = JWTToken::verifyToken($token);
        // dd($result);
        if ($result === "unauthorized") {
            // return response()->json([
            //     'status' => 'failed',
            //     'message' => 'unauthorized',
            // ], 401);

            return redirect()->route('userLogin.loginPage');
        } else {
            $request->headers->set('email', $result->userEmail);
            $request->headers->set('userId', $result->userId);
            return $next($request);
        }
    }
}
