<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreHuntingBookingRequest;
use App\Http\Resources\HuntingBookingResource;
use App\Models\Guide;
use App\Models\HuntingBooking;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Throwable;

class BookingController extends Controller
{
    public function store(StoreHuntingBookingRequest $request): JsonResponse
    {
        $data = $request->validated();

        $guide = Guide::query()->whereKey($data['guide_id'])->first();
        if (!$guide || !$guide->is_active) {
            return response()->json([
                'message' => 'Selected guide is not available.'
            ], 422); // либо 400, но 422 ближе к валидации
        }

        try {
            $booking = DB::transaction(function () use ($data) {
                $exists = HuntingBooking::query()
                    ->where('guide_id', $data['guide_id'])
                    ->whereDate('date', $data['date'])
                    ->exists();


                if ($exists) {
                    abort(response()->json([
                        'message' => 'Guide is already booked for this date.'
                    ], 409));
                }


                $booking = HuntingBooking::create($data);
                $booking->load('guide');
                return $booking;
            });
        } catch (Throwable $e) {
            if (str_contains($e->getMessage(), 'UNIQUE') || str_contains($e->getMessage(), 'Unique')) {
                return response()->json(['message' => 'Guide is already booked for this date.'], 409);
            }

            report($e);

            return response()->json(['message' => 'Unable to create booking.'], 500);
        }

        return response()->json(new HuntingBookingResource($booking), 201);
    }
}
