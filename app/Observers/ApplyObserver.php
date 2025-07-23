<?php

namespace App\Observers;

use App\Models\Apply;
use App\Notifications\SendAppyNotification;
use Illuminate\Support\Facades\Notification;

class ApplyObserver
{
    public function creating(Apply $apply): void
    {

    }

    public function created(Apply $apply)
    {
        dispatch(function () use ($apply) {
            $apply->user->notify(new SendAppyNotification($apply));
        });
    }

    public function updating(Apply $apply): void
    {
    }

    public function updated(Apply $apply): void
    {
    }

    public function saving(Apply $apply): void
    {
    }

    public function saved(Apply $apply): void
    {
    }

    public function deleting(Apply $apply): void
    {
    }

    public function deleted(Apply $apply): void
    {
    }

    public function restored(Apply $apply): void
    {
    }
}
