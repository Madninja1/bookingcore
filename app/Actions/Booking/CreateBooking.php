<?php

namespace App\Actions\Booking;

use App\Domain\Booking\Services\BookingService;

final class CreateBooking
{
    public function __construct(private BookingService $service)
    {
    }

    public function __invoke(array $validated)
    {
        return $this->service->create($validated);
    }
}
