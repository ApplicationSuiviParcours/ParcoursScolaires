<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Eleve;
use App\Models\Enseignant;
use App\Models\Classe;
use App\Models\AnneeScolaire;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    /**
     * Admin dashboard stats.
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        if (!$user->isAdmin()) abort(403);

        return response()->json([
            'stats' => [
                'total_users' => User::count(),
                'total_eleves' => Eleve::count(),
                'total_enseignants' => Enseignant::count(),
                'total_classes' => Classe::count(),
                'total_annees' => AnneeScolaire::count(),
                'latest_annee' => AnneeScolaire::latest()->first(),
            ],
            'recent_eleves' => Eleve::with('classe')->latest()->limit(5)->get(),
            'recent_classes' => Classe::withCount('eleves')->latest()->limit(5)->get(),
        ]);
    }
}