<?php

namespace App\Policies;

use App\Models\Booking;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class BookingPolicy
{
    /**
     * Determine whether the user can perform the action on the booking.
     *
     * @param \App\Models\User $user
     * @param \App\Models\Booking $booking
     * @return bool
     */
    public function manage(User $user, Booking $booking): bool
    {
        return $user->id === $booking->user_id;
    }
}