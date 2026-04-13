<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
class DashboardController extends Controller
{
    public function index()
    {
        /** @var User $user */
        $user = Auth::user();

        if (!$user) {
            return redirect('/login');
        }

        // Log pour le débogage
        $roles = $user->roles->pluck('name')->implode(', ');
        $dbRole = $user->role;
        Log::info('DashboardController - User: ' . $user->id . ', Roles: [' . $roles . '], DB role: ' . $dbRole . ', Matricule: ' . ($user->eleve?->matricule ?? $user->enseignant?->matricule ?? $user->parentEleve?->matricule ?? 'N/A'));

        $effectiveRole = $roles ?: $dbRole;

        // Priorité: Spatie > DB column
        if (in_array('administrateur', explode(',', $roles)) || $effectiveRole === 'administrateur') {
            Log::info('Redirecting to admin.dashboard');
            return redirect()->route('admin.dashboard');
        }

        if (in_array('enseignant', explode(',', $roles)) || $effectiveRole === 'enseignant') {
            Log::info('Redirecting to enseignant.dashboard');
            return redirect()->route('enseignant.dashboard');
        }

        if (in_array('eleve', explode(',', $roles)) || $effectiveRole === 'eleve') {
            Log::info('Redirecting to eleve.dashboard');
            return redirect()->route('eleve.dashboard');
        }

        if (in_array('parent', explode(',', $roles)) || $effectiveRole === 'parent') {
            Log::info('Redirecting to parent.dashboard');
            return redirect()->route('parent.dashboard');
        }

        // Debug fallback - show generic dashboard instead of logout
        Log::warning('No valid role for user: ' . $user->id . ' - Showing generic dashboard');
        return view('dashboard', ['user' => $user]);
    }
}