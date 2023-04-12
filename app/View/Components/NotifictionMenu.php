<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use Illuminate\Support\Facades\Auth;

class NotifictionMenu extends Component
{
    public $notifications;

    public $NewCountNotification;

    /**
     * Create a new component instance.
     */
    public function __construct()
    {
         $user = Auth::guard('store')->user();

        $this->notifications = $user->notifications()->take(5)->get();

        $this->NewCountNotification = $user->unreadNotifications()->count();
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.notifiction-menu');
    }
}
