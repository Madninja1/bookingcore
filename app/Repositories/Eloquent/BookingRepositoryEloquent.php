<?php

namespace App\Repositories\Eloquent;

use App\Domain\Booking\Contracts\BookingRepository;
use App\Models\HuntingBooking;

final class BookingRepositoryEloquent implements BookingRepository
{
    public function existsForGuideOnDate(int $guideId, string $date): bool
    {
        return HuntingBooking::query()
            ->where('guide_id', $guideId)->whereDate('date', $date)->exists();
    }

    public function create(array $attributes): HuntingBooking
    {
        return HuntingBooking::create($attributes);
    }
}
