<?php

namespace App\Observers;

use App\Models\Profile;
use App\Models\User;

class UserProfileObserver
{
    /**
     * Handle the User "created" event.
     */
    public function created(User $user): void
    {
        $profile = new Profile([
            'id_users' => $user->id_users,
        ]);

        $profile->save();
    }

    /**
     * Handle the User "updated" event.
     */
    public function updated(User $user): void
    {
        //
    }

    /**
     * Handle the User "deleted" event.
     */
    public function deleted(User $user): void
    {
        //
    }

    /**
     * Handle the User "restored" event.
     */
    public function restored(User $user): void
    {
        //
    }

    /**
     * Handle the User "force deleted" event.
     */
    public function forceDeleted(User $user): void
    {
        //
    }
}
