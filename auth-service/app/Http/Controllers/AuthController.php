<?php

namespace App\Http\Controllers;

use App\Models\Utilisateur;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function register(Request $request): JsonResponse
    {
        $donnees = $request->validate([
            'nom' => ['required', 'string', 'max:255'],
            'prenom' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:utilisateurs,email'],
            'mot_de_passe' => ['required', 'string', 'min:8'],
            'role' => ['sometimes', 'string', 'in:utilisateur,administrateur'],
        ]);

        $utilisateur = Utilisateur::create([
            'nom' => $donnees['nom'],
            'prenom' => $donnees['prenom'],
            'email' => $donnees['email'],
            'mot_de_passe' => $donnees['mot_de_passe'],
            'role' => $donnees['role'] ?? 'utilisateur',
            'actif' => true,
        ]);

        $token = $utilisateur->createToken('auth-service')->plainTextToken;

        return response()->json([
            'utilisateur' => $utilisateur,
            'token' => $token,
        ], 201);
    }

    public function login(Request $request): JsonResponse
    {
        $donnees = $request->validate([
            'email' => ['required', 'string', 'email'],
            'mot_de_passe' => ['required', 'string'],
        ]);

        $utilisateur = Utilisateur::where('email', $donnees['email'])->first();

        if (! $utilisateur || ! Hash::check($donnees['mot_de_passe'], $utilisateur->mot_de_passe)) {
            throw ValidationException::withMessages([
                'email' => ['Identifiants incorrects.'],
            ]);
        }

        if (! $utilisateur->actif) {
            return response()->json([
                'message' => 'Compte desactive.',
            ], 403);
        }

        $token = $utilisateur->createToken('auth-service')->plainTextToken;

        return response()->json([
            'utilisateur' => $utilisateur,
            'token' => $token,
        ]);
    }

    public function profil(Request $request): JsonResponse
    {
        return response()->json([
            'utilisateur' => $request->user(),
        ]);
    }

    public function logout(Request $request): JsonResponse
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'message' => 'Deconnexion reussie.',
        ]);
    }
}
