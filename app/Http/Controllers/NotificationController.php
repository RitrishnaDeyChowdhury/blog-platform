<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class NotificationController extends Controller
{
  public function index()
    {
        $notifications = auth()->user()->notifications()->latest()->get();
        return view('admin.notifications.index', compact('notifications'));
    }

    public function read($id){
        $notification = auth()->user()
            ->notifications()
            ->where('id', $id)
            ->firstOrFail();

        $notification->markAsRead();

        // Optional: redirect based on notification data
        if (isset($notification->data['blog_id'])) {
            return redirect()->route('notifications.show');
        }

        return redirect()->route('notifications.show');
    }
}
