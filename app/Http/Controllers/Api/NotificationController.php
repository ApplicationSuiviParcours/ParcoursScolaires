<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    /**
     * Get user notifications.
     */
    public function index(Request $request)
    {
        $notifications = Notification::query()->where('user_id', Auth::id())
            ->latest()
            ->paginate(20);

        return response()->json($notifications);
    }

    /**
     * Mark a notification as read.
     */
    public function markAsRead($id)
    {
        $notification = Notification::query()->where('user_id', Auth::id())
            ->findOrFail($id);

        $notification->markAsRead();

        return response()->json([
            'message' => 'Notification marquée comme lue',
            'notification' => $notification
        ]);
    }

    /**
     * Mark all notifications as read.
     */
    public function markAllAsRead()
    {
        /** @var \App\Models\User $user */
        Auth::user()->unreadNotifications()->update([
            'read' => true,
            'read_at' => now(),
        ]);

        return response()->json([
            'message' => 'Toutes les notifications ont été marquées comme lues'
        ]);
    }

    /**
     * Delete a notification.
     */
    public function destroy($id)
    {
        $notification = Notification::query()->where('user_id', Auth::id())
            ->findOrFail($id);

        $notification->delete();

        return response()->json([
            'message' => 'Notification supprimée avec succès'
        ]);
    }

    /**
     * Delete all read notifications.
     */
    public function destroyRead()
    {
        /** @var \App\Models\User $user */
        Auth::user()->notifications()->where('read', true)->delete();

        return response()->json([
            'message' => 'Notifications lues supprimées avec succès'
        ]);
    }

    /**
     * Get unread notifications count.
     */
    public function unreadCount()
    {
        /** @var \App\Models\User $user */
        $count = Auth::user()->unreadNotifications()->count();

        return response()->json([
            'unread_count' => $count
        ]);
    }
}
