<?php

namespace Domain\Invite\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use function trans;

class InviteNotification extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(
        private readonly string $url,
        private readonly string $name,
        private readonly string $subject
    ) {
        //
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param mixed $notifiable
     *
     * @return array
     */
    public function via(mixed $notifiable): array
    {
        return ['mail'];
    }

    /**
     * @return string[]
     */
    public function viaQueues(): array
    {
        return [
            'mail' => 'mail',
        ];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param mixed $notifiable
     *
     * @return MailMessage
     */
    public function toMail(mixed $notifiable): MailMessage
    {
        return (new MailMessage())
            ->subject($this->subject)
            ->line(trans('You are receiving this email because you are invited for :name.', ['name' => $this->name]))
            ->action(trans('Accept Request'), $this->url)
            ->line(trans('This link will expire in :count days.', ['count' => 7]))
            ->line(trans("If you don't want to join, no further action is required."));
    }
}
