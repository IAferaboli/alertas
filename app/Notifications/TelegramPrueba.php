<?php

namespace App\Notifications;

use Illuminate\Notifications\Notification;
use NotificationChannels\Telegram\TelegramChannel;
use NotificationChannels\Telegram\TelegramMessage;

class TelegramPrueba extends Notification
{
    public function via($notifiable)
    {
        return [TelegramChannel::class];
    }

    // public function toTelegram($notifiable)
    // {
    //     return TelegramLocation::create()
    //         ->to($notifiable->to)
    //         ->latitude($notifiable->lat)
    //         ->longitude($notifiable->lng);
    // }

    public function toTelegram($notifiable)
    {
        return TelegramMessage::create()
            ->to($notifiable->to)
            ->content($notifiable->content);
    }

}
