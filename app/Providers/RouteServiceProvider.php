<?php

namespace App\Providers;

use App\Models\User;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * The path to your application's "home" route.
     *
     * Typically, users are redirected here after authentication.
     *
     * @var string
     */
    public const HOME = '/dashboard';

    /**
     * Define your route model bindings, pattern filters, and other route configuration.
     */
    public function boot(): void
    {
        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(60)->by($request->user()?->id ?: $request->ip());
        });

        $this->routes(function () {
            Route::middleware('api')
                ->prefix('api')
                ->group(base_path('routes/api.php'));

            Route::middleware('web')
                ->group(base_path('routes/web.php'));
        });
    }

    /**
     * Redirect to the appropriate home page based on user role.
     * This overrides the default behavior to avoid redirect loops.
     */
    public static function getHomeUrl()
    {
        /** @var User|null $user */
        $user = Auth::user();

        if (!$user) {
            return self::HOME;
        }

        // Utilisation de la méthode hasRole() de Spatie
        if ($user->hasRole('administrateur')) {
            return route('admin.dashboard'); // Gardez admin.dashboard
        }

        if ($user->hasRole('enseignant')) {
            return route('enseignant.dashboard'); // Changé de enseignant.classes à enseignant.dashboard
        }

        if ($user->hasRole('eleve')) {
            return route('eleve.dashboard'); // Changé de eleve.notes à eleve.dashboard
        }

        if ($user->hasRole('parent')) {
            return route('parent.dashboard'); // ✅ Correct
        }

        return self::HOME;
    }
}
