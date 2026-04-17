<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

// Public routes
Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']); // TODO: implement if needed

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', [AuthController::class, 'user']);
    Route::post('/logout', [AuthController::class, 'logout']);

    // Notifications
    Route::get('/notifications', [\App\Http\Controllers\Api\NotificationController::class, 'index']);
    Route::post('/notifications/{id}/read', [\App\Http\Controllers\Api\NotificationController::class, 'markAsRead']);

    // -------------------------------------------------------
    // Parent APIs
    // -------------------------------------------------------
    Route::prefix('parent')->middleware('role:parent')->group(function () {
        Route::get('/dashboard', [\App\Http\Controllers\Api\Parent\DashboardController::class, 'index']);
        Route::get('/enfants', [\App\Http\Controllers\Api\Parent\EnfantsController::class, 'index']);

        Route::prefix('eleve/{eleve_id}')->group(function () {
            Route::get('/bulletins', [\App\Http\Controllers\Api\Parent\BulletinController::class, 'index']);
            Route::get('/bulletins/{bulletin_id}', [\App\Http\Controllers\Api\Parent\BulletinController::class, 'show']);
            Route::get('/notes', [\App\Http\Controllers\Api\Parent\NoteController::class, 'index']);
            Route::get('/absences', [\App\Http\Controllers\Api\Parent\AbsenceController::class, 'index']);
            Route::get('/emploi-du-temps', [\App\Http\Controllers\Api\Parent\EmploiController::class, 'show']);
        });
    });

    // -------------------------------------------------------
    // Eleve APIs
    // -------------------------------------------------------
    Route::prefix('eleve')->middleware('role:eleve')->group(function () {
        Route::get('/dashboard', [\App\Http\Controllers\Api\Eleve\DashboardController::class, 'index']);
        Route::get('/notes', [\App\Http\Controllers\Api\Eleve\NoteController::class, 'index']);
        Route::get('/absences', [\App\Http\Controllers\Api\Eleve\AbsenceController::class, 'index']);
        Route::get('/bulletins', [\App\Http\Controllers\Api\Eleve\BulletinController::class, 'index']);
        Route::get('/bulletins/{bulletin_id}', [\App\Http\Controllers\Api\Eleve\BulletinController::class, 'show']);
        Route::get('/emploi-du-temps', [\App\Http\Controllers\Api\Eleve\EmploiController::class, 'index']);
    });

    // -------------------------------------------------------
    // Enseignant APIs
    // -------------------------------------------------------
    Route::prefix('enseignant')->middleware('role:enseignant')->group(function () {
        Route::get('/dashboard', [\App\Http\Controllers\Api\Enseignant\DashboardController::class, 'index']);

        Route::prefix('evaluations')->group(function () {
            Route::get('/', [\App\Http\Controllers\Api\Enseignant\EvaluationController::class, 'index']);
            Route::post('/', [\App\Http\Controllers\Api\Enseignant\EvaluationController::class, 'store']);
            Route::get('/{id}', [\App\Http\Controllers\Api\Enseignant\EvaluationController::class, 'show']);
            Route::put('/{id}', [\App\Http\Controllers\Api\Enseignant\EvaluationController::class, 'update']);
            Route::delete('/{id}', [\App\Http\Controllers\Api\Enseignant\EvaluationController::class, 'destroy']);
        });

        Route::prefix('notes')->group(function () {
            Route::get('/', [\App\Http\Controllers\Api\Enseignant\NoteController::class, 'index']);
            Route::post('/', [\App\Http\Controllers\Api\Enseignant\NoteController::class, 'store']);
        });

        Route::prefix('absences')->group(function () {
            Route::get('/', [\App\Http\Controllers\Api\Enseignant\AbsenceController::class, 'index']);
            Route::post('/', [\App\Http\Controllers\Api\Enseignant\AbsenceController::class, 'store']);
        });

        Route::prefix('classes')->group(function () {
            Route::get('/{id}/eleves', [\App\Http\Controllers\Api\Enseignant\ClasseController::class, 'eleves']);
        });
    });

    // -------------------------------------------------------
    // Admin APIs
    // -------------------------------------------------------
    Route::prefix('admin')->middleware('role:administrateur')->group(function () {
        Route::get('/dashboard', [\App\Http\Controllers\Api\Admin\DashboardController::class, 'index']);

        Route::prefix('users')->group(function () {
            Route::get('/', [\App\Http\Controllers\Api\Admin\UserController::class, 'index']);
            Route::post('/', [\App\Http\Controllers\Api\Admin\UserController::class, 'store']);
            Route::get('/{id}', [\App\Http\Controllers\Api\Admin\UserController::class, 'show']);
            Route::put('/{id}', [\App\Http\Controllers\Api\Admin\UserController::class, 'update']);
            Route::delete('/{id}', [\App\Http\Controllers\Api\Admin\UserController::class, 'destroy']);
        });
    });
});