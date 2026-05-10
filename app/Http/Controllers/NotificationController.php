<?php

namespace App\Http\Controllers;

use App\Models\ComplaintNotification;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function index()
    {
        $notifications = ComplaintNotification::where('user_id', auth()->id())
            ->orderBy('created_at', 'desc')
            ->get();

        ComplaintNotification::where('user_id', auth()->id())
            ->where('is_read', false)
            ->update(['is_read' => true]);

        return view('resident.notifications', compact('notifications'));
    }

    public function markRead(ComplaintNotification $notification)
    {
        if ($notification->user_id === auth()->id()) {
            $notification->update(['is_read' => true]);
        }
        return response()->json(['success' => true]);
    }

    public function unreadCount()
    {
        $count = ComplaintNotification::where('user_id', auth()->id())
            ->where('is_read', false)
            ->count();
        return response()->json(['count' => $count]);
    }
}