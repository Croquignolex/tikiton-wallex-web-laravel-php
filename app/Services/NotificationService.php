<?php

namespace App\Services;

use Illuminate\Support\Facades\Auth;

class NotificationService
{
    private $notifications;

    /**
     * LanguageService constructor.
     */
    public function __construct()
    {
        $this->notifications = Auth::user()->notifications
            ->where('viewed', false)->sortByDesc('created_at');
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