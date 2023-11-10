<?php

namespace App\Observers;

use App\Mail\NotifikasiMail;
use App\Models\Notifikasi;
use Illuminate\Support\Facades\Mail;

class NotifikasiObserver
{
    /**
     * Handle the Notifikasi "created" event.
     */
    public function created(Notifikasi $notifikasi): void
    {
        if ($notifikasi->send_email == 'yes') {
            Mail::to($notifikasi->user)->send(new NotifikasiMail($notifikasi));
        }
    }

    /**
     * Handle the Notifikasi "updated" event.
     */
    public function updated(Notifikasi $notifikasi): void
    {
        //
    }

    /**
     * Handle the Notifikasi "deleted" event.
     */
    public function deleted(Notifikasi $notifikasi): void
    {
        //
    }

    /**
     * Handle the Notifikasi "restored" event.
     */
    public function restored(Notifikasi $notifikasi): void
    {
        //
    }

    /**
     * Handle the Notifikasi "force deleted" event.
     */
    public function forceDeleted(Notifikasi $notifikasi): void
    {
        //
    }
}
