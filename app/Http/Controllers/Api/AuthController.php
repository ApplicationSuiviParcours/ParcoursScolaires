<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\LoginRequest;
use App\Http\Resources\UserResource;

use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    /**
     * Handle login request (email/password or matricule/password).
     */
    public function login(LoginRequest $request): JsonResponse
    {
    $email = $request->input('email');
        $password = $request->input('password');
        $remember = $request->boolean('remember', false);

        $credentials = ['email' => $email, 'password' => $password];

        if (!Auth::attempt($credentials, $remember)) {
            throw ValidationException::withMessages([
            'email' => ['Email ou mot de passe incorrects.'],
            ]);
        }

        $user = Auth::user();
        if (!$user->is_active) {
            Auth::logout();
            throw ValidationException::withMessages([
            'email' => ['Compte désactivé. Contactez l\'administrateur.'],
            ]);
        }

        $token = $user->createToken('mobile-app')->plainTextToken;

        return response()->json([
            'message' => 'Connexion réussie',
            'user' => new UserResource($user),
            'token' => $token,
            'token_type' => 'Bearer',
        ]);
    }

    /**
     * Get authenticated user.
     */
    public function user(): JsonResponse
    {
        return response()->json([
            'user' => new UserResource(Auth::user()),
        ]);
    }

    /**
     * Logout and revoke token.
     */
    public function logout(): JsonResponse
    {
        $user = Auth::user();
        $user->tokens()->delete();

        return response()->json(['message' => 'Déconnexion réussie']);
    }


}