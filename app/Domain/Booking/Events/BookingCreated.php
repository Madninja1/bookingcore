<?php

namespace App\Domain\Booking\Events;

use App\Models\HuntingBooking;

final class BookingCreated
{
    public function __construct(public readonly HuntingBooking $booking)
    {
    }
}
