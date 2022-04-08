<?php

namespace App\Notifications;

use Illuminate\Notifications\Notification;
use NotificationChannels\Telegram\TelegramChannel;
use NotificationChannels\Telegram\TelegramMessage;

/**
 * Para poder enviar notificaciones por TG, añadir a cada modelo
 * use Illuminate\Notifications\Notifiable;
 * use Notifiable;
 * 
 * y en el controlador que lo envía,
 * use Illuminate\Notifications\Notifiable;
 * use App\Notifications\TelegramNotification;
 * 
 */

class TelegramNotification extends Notification
{
       
    public function via($notifiable)
    {
        return [TelegramChannel::class];
    }

    public function toTelegram($notifiable)
    {
        return TelegramMessage::create()
            ->to($notifiable->to)
            ->content($notifiable->content);
    }
    
 
}
