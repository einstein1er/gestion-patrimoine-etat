<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Symfony\Component\HttpFoundation\Response;

class VerifierTokenAuth
{
    public function handle(Request $request, Closure $next): Response
    {
        $token = $request->bearerToken();

        if (! $token) {
            return response()->json([
                'message' => 'Token manquant.',
            ], 401);
        }

        $reponse = Http::withToken($token)
            ->acceptJson()
            ->get('http://auth:8000/api/verifier-token');

        if ($reponse->failed()) {
            return response()->json([
                'message' => 'Token invalide ou expire.',
            ], 401);
        }

        $utilisateur = $reponse->json();

        $request->merge([
            'utilisateur_id' => $utilisateur['utilisateur_id'],
            'utilisateur_role' => $utilisateur['role'],
        ]);

        return $next($request);
    }
}
