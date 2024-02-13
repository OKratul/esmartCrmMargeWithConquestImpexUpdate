<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class QueryNotification extends Notification
{
    use Queueable;

    public $query;

    /**
     * Create a new notification instance.
     */
    public function __construct($query)
    {
        $this->query = $query;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database'];
    }

    /**
     * Get the mail representation of the notification.
     */

    public function toArray(object $notifiable): array
    {
        return [
            'query_id' => $this->query->id,
            'category' => $this->query->product_category,
            'product_name' => $this->query->product_name,
            'query_source' => $this->query->query_source,
            'phone_number' => $this->query->phone_number,
        ];
    }
}
