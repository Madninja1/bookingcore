<?php

namespace App\Domain\Booking\Services;

use App\Domain\Booking\Contracts\BookingRepository;
use App\Domain\Guides\Contracts\GuideRepository;
use App\Domain\Booking\Events\BookingCreated;
use Illuminate\Contracts\Events\Dispatcher;
use Illuminate\Support\Facades\DB;
use DomainException;

final class BookingService
{
    public function __construct(
        private BookingRepository $bookings,
        private GuideRepository   $guides,
        private Dispatcher        $events
    )
    {
    }

    /** @throws DomainException */
    public function create(array $data)
    {
        if (($data['participants_count'] ?? 0) > 10) {
            throw new DomainException('Participants must be ≤ 10.');
        }
        $guide = $this->guides->findActive((int)$data['guide_id']);
        if (!$guide) throw new DomainException('Selected guide is not available.');
        if ($this->bookings->existsForGuideOnDate((int)$data['guide_id'], (string)$data['date'])) {
            throw new DomainException('Guide is already booked for this date.');
        }

        return DB::transaction(function () use ($data) {
            $booking = $this->bookings->create($data);
            $this->events->dispatch(new BookingCreated($booking));
            return $booking->load('guide');
        });
    }
}
