<?php

namespace App\Listeners;

use App\Events\BookingCanceled;
use App\Models\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendBookingCanceledNotification
{
    /**
     * Handle the event.
     *
     * @param  \App\Events\BookingCanceled  $event
     * @return void
     */
    public function handle(BookingCanceled $event)
    {
        // Get staff members or a specific staff member
        $staffMembers = User::get(); // Modify based on your user model

        // Send notification to each staff member
        foreach ($staffMembers as $staffMember) {
            $staffMember->notify(new BookingCanceledNotification($event->booking));
        }
    }
}
