<?php

namespace App\Notifications;

use App\Mail\VerifyCodeMail;
use App\Models\User;
use App\Models\UserEntry;
use App\Services\EmailVerifyService;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

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

    public function toMail(User $user): VerifyCodeMail
    {
        $code = EmailVerifyService::generateCode();

        EmailVerifyService::store($user->id, $code);

        return (new VerifyCodeMail($code))->to($this->entry->entry);
    }
}
