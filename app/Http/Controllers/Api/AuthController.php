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
     * Handle login request (email/password or matricule).
     */
    public function login(LoginRequest $request): JsonResponse
    {
        $credential = $request->input('credential');
        $password = $request->input('password');
        $role = $request->input('role', 'user');
        $remember = $request->boolean('remember', false);

        // Logic from Web's LoginRequest
        $user = $this->findUserByRoleAndCredential($role, $credential);

        if (!$user) {
            throw ValidationException::withMessages([
                'credential' => ['Identifiant incorrect ou compte introuvable.'],
            ]);
        }

        if (!$user->is_active) {
            throw ValidationException::withMessages([
                'credential' => ['Votre compte est désactivé. Contactez l\'administration.'],
            ]);
        }

        // PASSWORDLESS for non-admin roles (matching web logic)
        if ($role !== 'administrateur' && $user->hasAnyRole(['eleve', 'enseignant', 'parent'])) {
            // Auto-login / Token creation
            Auth::login($user);
        } else {
            // Admin or explicit password check
            if (!Auth::attempt(['email' => $user->email, 'password' => $password], $remember)) {
                throw ValidationException::withMessages([
                    'credential' => ['Mot de passe incorrect.'],
                ]);
            }
        }

        $user = Auth::user();
        $token = $user->createToken('mobile-app')->plainTextToken;
        $user->update(['last_login_at' => now()]);

        return response()->json([
            'message' => 'Connexion réussie',
            'user' => new UserResource($user),
            'token' => $token,
            'token_type' => 'Bearer',
        ]);
    }

    /**
     * Find user based on role and credential (matricule/email)
     * Replicated from Web LoginRequest
     */
    private function findUserByRoleAndCredential($role, $credential)
    {
        if ($role === 'administrateur') {
            return User::where('email', $credential)
                ->whereHas('roles', fn($q) => $q->where('name', 'administrateur'))
                ->first();
        }

        // Non-admin lookups (Eleve, Enseignant, Parent)
        $user = \App\Models\Eleve::where('matricule', $credential)
            ->whereHas('user.roles', fn($q) => $q->where('name', 'eleve'))
            ->with('user')->first()?->user;

        if (!$user) {
            $user = \App\Models\Enseignant::where('matricule', $credential)
                ->whereHas('user.roles', fn($q) => $q->where('name', 'enseignant'))
                ->with('user')->first()?->user;
        }

        if (!$user) {
            $user = \App\Models\ParentEleve::where('matricule', $credential)
                ->whereHas('user.roles', fn($q) => $q->where('name', 'parent'))
                ->with('user')->first()?->user;
        }

        return $user;
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