<?php

namespace App\Observers;

use App\Models\User;
use App\Notifications\SendUserPasswordNotification;
use Filament\Facades\Filament;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserObserver
{

    public function creating(User $user): void
    {
        if (Filament::isServing()) {
            $user->plain_password = Str::random(10);
            $user->password = Hash::make($user->plain_password);
        } else {
            // recupere password depuis le formulaire
            if (isset($user->password) && !empty($user->password) && !Hash::isHashed($user->password)) {
                $user->plain_password = $user->password;
            }

        }
    }

    public function created(User $user): void
    {
        // Envoi du mot de passe par mail
        if (!empty($user->plain_password)) {
            $user->notify(new SendUserPasswordNotification($user->plain_password));
            unset($user->plain_password); // Nettoyage
        }
    }
    public function updating(User $user): void
    {
    }

    public function updated(User $user): void
    {
    }

    public function saving(User $user): void
    {
    }

    public function saved(User $user): void
    {
    }

    public function deleting(User $user): void
    {
    }

    public function deleted(User $user): void
    {
    }

    public function restored(User $user): void
    {
    }
}
