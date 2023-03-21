<?php

namespace App\Notifications;

use App\Models\User;
use App\Models\UserEntry;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\URL;

class UserAuthenticateNotification extends Notification
{
    use Queueable;

    private UserEntry $entry;

    public function __construct(UserEntry $entry)
    {
        $this->entry = $entry;
    }

    public function via(User $user)
    {
        if ($this->entry->type === 'email') {
            return ['mail'];
        }
        //todo sms channel;
        return null;
    }

    public function toMail(User $user): MailMessage
    {
        $signedUrl = URL::temporarySignedRoute('api.authenticate.verification', Carbon::now()->addMinutes(10), [
            'user' => $user->id,
            'entry' => $this->entry->id,
        ]);
//        $digit = ;

        return (new MailMessage)

            ->subject('Verify your email address')
            ->line('Please click the button below to verify your email address witch is: **'.$this->entry->entry.'**')
            ->action('Continue to '.config('app.name'), $signedUrl)
            ->line('Or use this code instead: **1233**');
    }
}
