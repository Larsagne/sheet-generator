<?php

namespace App\Notifications;

use App\Models\Invitation;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class InvitationCreated extends Notification
{
    use Queueable;

    public function __construct(
        private readonly Invitation $invitation
    )
    {
    }

    public function via(): array
    {
        return ['mail'];
    }

    public function toMail(): MailMessage
    {
        return (new MailMessage)
            ->line(__('invitation.mail.intro'))
            ->action(__('invitation.mail.button'), url(
                route('invitations.accept', ['invitation' => $this->invitation]))
            )
            ->line(__('invitation.mail.thanks'));
    }
}
