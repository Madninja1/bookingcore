<?php

namespace App\Http\Controllers\Api;

use App\Actions\Booking\CreateBooking;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreHuntingBookingRequest;
use App\Http\Resources\HuntingBookingResource;

class BookingController extends Controller
{
    public function store(StoreHuntingBookingRequest $request)
    {
        try {
            $booking = app(CreateBooking::class)($request->validated());

            return response()->json(new HuntingBookingResource($booking), 201);
        } catch (\DomainException $e) {
            return response()->json(['message' => $e->getMessage()], 409);
        }
    }
}
