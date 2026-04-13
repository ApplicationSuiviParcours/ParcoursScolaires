<?php

namespace App\Http\Requests\Auth;

use Illuminate\Auth\Events\Lockout;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use App\Models\Eleve;
use App\Models\Enseignant;
use App\Models\ParentEleve;
use App\Models\User;

class LoginRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'role' => ['sometimes', 'string', 'in:eleve,enseignant,parent,administrateur,user'],
            'credential' => ['required', 'string'],
            'password' => ['required', 'string'],
        ];
    }


    /**
     * Attempt to authenticate the request's credentials.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function authenticate(): void
    {
        $this->ensureIsNotRateLimited();

        $credential = $this->credential;
        $password = $this->password ?? ''; // Optional for non-admin
        $role = $this->role ?? 'user';

        // Find user based on role/matricule
        $user = $this->findUserByRoleAndCredential($role, $credential);

        if (!$user) {
            $errorMsg = $this->getNoUserErrorMessage($role);
            RateLimiter::hit($this->throttleKey(), 60);
            throw ValidationException::withMessages([
                'credential' => $errorMsg,
            ]);
        }

        // Check if user is active
        if (!$user->is_active) {
            RateLimiter::hit($this->throttleKey(), 60);
            throw ValidationException::withMessages([
                'credential' => 'Votre compte est désactivé. Contactez l\'administration.',
            ]);
        }

        // PASSWORDLESS for non-admin roles (eleve, enseignant, parent, user)
        if (!in_array($role, ['administrateur'])) {
            // Auto-login for matricule users
            Auth::login($user);
        } else {
            // Admin: require password
            if (!Auth::attempt(['email' => $user->email, 'password' => $password])) {
                RateLimiter::hit($this->throttleKey(), 60);
                throw ValidationException::withMessages([
                    'credential' => 'Mot de passe incorrect.',
                ]);
            }
        }

        RateLimiter::clear($this->throttleKey());
        $user->update(['last_login_at' => now()]);
    }

    /**
     * Find user based on role and credential (matricule/email)
     */
    private function findUserByRoleAndCredential($role, $credential)
    {
        $users = [];

        // Specific role lookup
        if ($role === 'administrateur') {
            return User::where('email', $credential)
                ->whereHas('roles', fn($q) => $q->where('name', 'administrateur'))
                ->first();
        }

        // Non-admin lookups
        $users[] = Eleve::where('matricule', $credential)
            ->whereHas('user.roles', fn($q) => $q->whereIn('name', ['eleve']))
            ->with('user')
            ->first()?->user;

        $users[] = Enseignant::where('matricule', $credential)
            ->whereHas('user.roles', fn($q) => $q->whereIn('name', ['enseignant']))
            ->with('user')
            ->first()?->user;

        $users[] = ParentEleve::where('matricule', $credential)
            ->whereHas('user.roles', fn($q) => $q->whereIn('name', ['parent']))
            ->with('user')
            ->first()?->user;

        // Return first valid user
        foreach ($users as $user) {
            if ($user && $user->is_active) {
                return $user;
            }
        }

        return null;
    }

    /**
     * Get error message for no user found
     */
    private function getNoUserErrorMessage($role): string
    {
        return match($role) {
            'administrateur' => 'Aucun compte administrateur trouvé avec cet email.',
            default => 'Aucun compte trouvé avec ce matricule. Vérifiez votre numéro matricule.',
        };
    }

    /**
     * Ensure the login request is not rate limited.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    protected function ensureIsNotRateLimited(): void
    {
        if (! RateLimiter::tooManyAttempts($this->throttleKey(), 5)) {
            return;
        }

        event(new Lockout($this));

        $seconds = RateLimiter::availableIn($this->throttleKey());

        throw ValidationException::withMessages([
            'credential' => trans('auth.throttle', [
                'seconds' => $seconds,
                'minutes' => ceil($seconds / 60),
            ]),
        ]);
    }


    /**
     * Get the rate limiting throttle key for the request.
     */
    protected function throttleKey(): string
    {
        return Str::transliterate(Str::lower($this->input('role') . '|' . $this->input('credential').$this->ip()));
    }
}