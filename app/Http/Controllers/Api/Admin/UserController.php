<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    /**
     * List all users with role filter.
     */
    public function index(Request $request): AnonymousResourceCollection
    {
        $user = Auth::user();
        if (!$user->isAdmin()) abort(403);

        $query = User::with('roles');

        if ($request->filled('role')) {
            $query->role($request->role);
        }

        $users = $query->paginate(15);

        return UserResource::collection($users);
    }

    /**
     * Create user (admin only).
     */
    public function store(Request $request)
    {
        $user = Auth::user();
        if (!$user->isAdmin()) abort(403);

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'role' => 'required|exists:roles,name',
            'password' => 'required|string|min:8|confirmed',
            'is_active' => 'boolean',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $data = $validator->validated();
        $data['password'] = Hash::make($data['password']);

        $user = User::create($data);
        $user->assignRole($data['role']);

        return response()->json([
            'message' => 'Utilisateur créé',
            'user' => new UserResource($user->load('roles')),
        ], 201);
    }

    /**
     * Update user.
     */
    public function update(Request $request, $id)
    {
        $user = Auth::user();
        if (!$user->isAdmin()) abort(403);

        $targetUser = User::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'name' => 'string|max:255',
            'email' => 'email|unique:users,email,' . $id,
            'role' => 'exists:roles,name',
            'is_active' => 'boolean',
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $data = $validator->validated();
        if (isset($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        }

        $targetUser->update($data);

        if (isset($data['role'])) {
            $targetUser->syncRoles($data['role']);
        }

        return response()->json([
            'message' => 'Utilisateur mis à jour',
            'user' => new UserResource($targetUser->load('roles')),
        ]);
    }

    /**
     * Delete user (prevent last admin).
     */
    public function destroy($id)
    {
        $user = Auth::user();
        if (!$user->isAdmin()) abort(403);

        $targetUser = User::findOrFail($id);
        if ($targetUser->isAdmin() && User::role('administrateur')->count() === 1) {
            return response()->json(['error' => 'Impossible de supprimer le dernier administrateur'], 422);
        }

        $targetUser->delete();

        return response()->json(['message' => 'Utilisateur supprimé']);
    }
}