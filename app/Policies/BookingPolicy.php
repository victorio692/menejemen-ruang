<?php

namespace App\Policies;

use App\Models\Booking;
use App\Models\User;

class BookingPolicy
{
    /**
     * Determine if the user can view the booking.
     */
    public function view(User $user, Booking $booking)
    {
        // User can view their own booking
        return $user->id === $booking->user_id;
    }

    /**
     * Determine if the user can create a booking.
     */
    public function create(User $user)
    {
        return $user->role === 'user';
    }

    /**
     * Determine if the user can update the booking.
     */
    public function update(User $user, Booking $booking)
    {
        // User can only update their own pending booking
        return $user->id === $booking->user_id && $booking->status === 'pending';
    }

    /**
     * Determine if the user can delete the booking.
     */
    public function delete(User $user, Booking $booking)
    {
        // User can only delete their own pending booking
        return $user->id === $booking->user_id && $booking->status === 'pending';
    }
}
