<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    public function index()
    {
        $user = Auth::guard('store')->user();

        return view('admin.notifications.index', [
            'notifications' => $user->notifications,  //$user->notifications(relation inside store model)
        ]);
    }

    public function read()
    {
        Auth::guard('store')->user()->unreadNotifications->markAsRead();
    }
}
