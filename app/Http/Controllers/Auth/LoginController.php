<?php
// app/Http/Controllers/Auth/LoginController.php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Eleve;
use App\Models\Enseignant;
use App\Models\ParentEleve;
use App\Models\User;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    protected $redirectTo = '/dashboard';

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function login(Request $request)
    {
        $role = $request->input('role');

        if ($role === 'administrateur') {
            $request->validate([
                'credential' => 'required|email',
                'password' => 'required|string',
            ], [
                'credential.required' => 'L\'adresse email est requise.',
                'credential.email' => 'Veuillez entrer une adresse email valide.',
                'password.required' => 'Le mot de passe est requis.'
            ]);

            if (Auth::attempt(['email' => $request->credential, 'password' => $request->password, 'is_active' => true], $request->boolean('remember'))) {
                $request->session()->regenerate();
                return redirect()->intended($this->redirectPath());
            }

            // Check if user exists but is inactive
            $user = User::query()->where('email', $request->credential)->first();
            if ($user && !$user->is_active && Hash::check($request->password, $user->password)) {
                 return back()->withErrors([
                    'credential' => 'Votre compte a été désactivé. Veuillez contacter l\'administration.',
                ])->withInput($request->except('password'))->with('login_type', 'admin');
            }

            return back()->withErrors([
                'credential' => 'Les identifiants fournis ne correspondent pas à nos enregistrements.',
            ])->withInput($request->except('password'))->with('login_type', 'admin');
        }

        // Sinon, c'est une connexion par matricule (user)
        $request->validate([
            'credential' => 'required|string',
        ], [
            'credential.required' => 'Le matricule est requis.'
        ]);

        $matricule = $request->credential;
        $user = null;

        // Rechercher dans Eleve
        $eleve = Eleve::query()->where('matricule', $matricule)->first();
        if ($eleve) {
            $user = $eleve->user;
        }

        // Rechercher dans Enseignant si pas trouvé
        if (!$user) {
            $enseignant = Enseignant::query()->where('matricule', $matricule)->first();
            if ($enseignant) {
                $user = $enseignant->user;
            }
        }

        // Rechercher dans Parent si pas trouvé
        if (!$user) {
            $parent = ParentEleve::query()->where('matricule', $matricule)->first();
            if ($parent) {
                $user = $parent->user;
            }
        }

        if ($user) {
            // Vérifier si l'utilisateur est actif
            if (!$user->is_active) {
                 return back()->withErrors([
                    'credential' => 'Votre compte a été désactivé. Veuillez contacter l\'administration.',
                ])->withInput();
            }

            Auth::login($user, $request->boolean('remember'));
            $request->session()->regenerate();
            return redirect()->intended($this->redirectPath());
        }

        return back()->withErrors([
            'credential' => 'Matricule introuvable ou aucun compte associé.',
        ])->withInput();
    }
}