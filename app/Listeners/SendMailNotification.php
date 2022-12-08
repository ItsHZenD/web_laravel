<?php

namespace App\Listeners;

use App\Events\UserRegisteredEvent;
use App\Notifications\UserRegisteredNotificationMail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Notification;

class SendMailNotification
{

    public function handle(UserRegisteredEvent $event)
    {
        Notification::send($event->user, new UserRegisteredNotificationMail($event->user));
    }
}
