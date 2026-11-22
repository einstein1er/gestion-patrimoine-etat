<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class VerifierTokenAuth
{
    public function handle(Request $request, Closure $next)
    {
        $token = $request->bearerToken();

        if (!$token) {
            return response()->json([
                'message' => 'Token manquant'
            ], 401);
        }

        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->get('http://auth:8000/api/verifier-token');

        if ($response->failed()) {
            return response()->json([
                'message' => 'Token invalide'
            ], 401);
        }

        $request->merge([
            'utilisateur' => $response->json('utilisateur'),
        ]);

        return $next($request);
    }
}
