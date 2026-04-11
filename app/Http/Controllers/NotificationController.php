<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Liste paginée des notifications de l'utilisateur connecté
     */
    public function index(Request $request)
    {
        $user = Auth::user();

        $query = $user->notifications()->latest();

        // Filtre lu/non lu
        if ($request->filled('statut')) {
            if ($request->statut === 'non_lu') {
                $query->where('read', false);
            } elseif ($request->statut === 'lu') {
                $query->where('read', true);
            }
        }

        // Filtre par type
        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        $notifications = $query->paginate(15)->appends($request->query());
        $unreadCount   = $user->unreadNotifications()->count();

        return view('notifications.index', compact('notifications', 'unreadCount'));
    }

    /**
     * Marquer une notification comme lue
     */
    public function markAsRead(Notification $notification)
    {
        // Vérifier que la notification appartient à l'utilisateur connecté
        if ($notification->user_id !== Auth::id()) {
            abort(403);
        }

        $notification->markAsRead();

        if (request()->expectsJson()) {
            return response()->json(['success' => true]);
        }

        return back()->with('success', 'Notification marquée comme lue.');
    }

    /**
     * Marquer toutes les notifications comme lues
     */
    public function markAllAsRead()
    {
        Auth::user()->unreadNotifications()->update([
            'read'    => true,
            'read_at' => now(),
        ]);

        if (request()->expectsJson()) {
            return response()->json(['success' => true, 'count' => 0]);
        }

        return back()->with('success', 'Toutes les notifications ont été marquées comme lues.');
    }

    /**
     * Supprimer une notification
     */
    public function destroy(Notification $notification)
    {
        if ($notification->user_id !== Auth::id()) {
            abort(403);
        }

        $notification->delete();

        if (request()->expectsJson()) {
            return response()->json(['success' => true]);
        }

        return back()->with('success', 'Notification supprimée.');
    }

    /**
     * Supprimer toutes les notifications lues
     */
    public function destroyRead()
    {
        Auth::user()->notifications()->where('read', true)->delete();

        if (request()->expectsJson()) {
            return response()->json(['success' => true]);
        }

        return back()->with('success', 'Notifications lues supprimées.');
    }

    /**
     * Retourner le nombre de notifications non lues (pour AJAX polling)
     */
    public function unreadCount()
    {
        $count = Auth::user()->unreadNotifications()->count();

        // Retourner les 5 dernières non lues pour l'aperçu dans la nav
        $recent = Auth::user()->unreadNotifications()
            ->latest()
            ->limit(5)
            ->get(['id', 'type', 'title', 'message', 'link', 'created_at']);

        return response()->json([
            'count'  => $count,
            'recent' => $recent,
        ]);
    }
}
