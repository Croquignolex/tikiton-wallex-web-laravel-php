<?php

namespace App\Services;

use App\Models\AdminNotification;
use App\Models\Role;
use Illuminate\Support\Facades\Auth;

class NotificationService
{
    private $notifications;

    /**
     * LanguageService constructor.
     */
    public function __construct()
    {
        $user =  Auth::user();
        if($user->role->type === Role::USER) $this->notifications = $user->notifications->where('viewed', false)->sortByDesc('created_at');
        else $this->notifications = AdminNotification::where('viewed', false)->get()->sortByDesc('created_at');
    }

    /**
     * @return mixed
     */
    public function getBlinkClass()
    {
        return $this->getNotificationsNumber() === 0 ? '' : 'flash-theme';
    }

    /**
     * @return mixed
     */
    public function getNotificationsNumber()
    {
        return $this->notifications->where('viewed', false)->count();
    }

    /**
     * @return mixed
     */
    public function getNotifications()
    {
        $this->notifications->splice(4);
        return $this->notifications->all();
    }

    /**
     * @return string
     */
    public function getBadgeColor()
    {
        return $this->getNotificationsNumber() === 0 ? 'success' : 'danger';
    }
}