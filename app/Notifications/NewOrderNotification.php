<?php

namespace App\Notifications;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Messages\BroadcastMessage;

class NewOrderNotification extends Notification
{
    use Queueable;

    public $order;

    /**
     * Create a new notification instance.
     */
    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database','broadcast'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
                    ->line('The introduction to the notification.')
                    ->action('Notification Action', url('/'))
                    ->line('Thank you for using our application!');
    }

    public function toDatabase($notifiable)
    {
        $user = Auth::user();

        return [
                'title' => 'New Order',
                'body' => 'A new order has beeen created by '. $user->name,
                'action' => url('admin/dashboard'),
                'icon' => 'fas fa-file',
                'order_id' => $this->order->id,
        ];

    }

    public function toBroadcast($notifiable)
    {
        $message = new BroadcastMessage([

            'title' => 'New Order',
            'body' => 'A new order has beeen created.',
            'action' => url('admin/dashboard'),
            'icon' => '',
            'order_id' => $this->order->id,
        ]);

        return $message ;

    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
