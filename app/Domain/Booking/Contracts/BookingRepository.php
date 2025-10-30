<?php

namespace App\Domain\Booking\Contracts;

use App\Models\HuntingBooking;

interface BookingRepository
{
    public function existsForGuideOnDate(int $guideId, string $date): bool;

    public function create(array $attributes): HuntingBooking;
}
