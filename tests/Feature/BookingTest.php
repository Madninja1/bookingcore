<?php

namespace Tests\Feature;

use App\Models\Guide;
use App\Models\HuntingBooking;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BookingTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_create_booking(): void
    {
        $guide = Guide::factory()->create(['is_active' => true]);

        $payload = [
            'tour_name'          => 'Test Tour',
            'hunter_name'        => 'Tester',
            'guide_id'           => $guide->id,
            'date'               => now()->addDay()->format('Y-m-d'),
            'participants_count' => 2,
        ];

        $res = $this->postJson('/api/bookings', $payload);

        $res->assertCreated()
            ->assertJsonPath('tour_name', 'Test Tour');

        $this->assertDatabaseHas('hunting_bookings', [
            'guide_id' => $guide->id,
            'date'     => $payload['date'],
        ]);
    }


    public function test_cannot_double_book_same_guide_same_date(): void
    {
        $guide = Guide::factory()->create(['is_active' => true]);

        HuntingBooking::factory()->create([
            'guide_id' => $guide->id,
            'date'     => now()->addDays(2)->toDateString(),
        ]);

        $res = $this->postJson('/api/bookings', [
            'tour_name'          => 'Another',
            'hunter_name'        => 'Tester',
            'guide_id'           => $guide->id,
            'date'               => now()->addDays(2)->format('Y-m-d'),
            'participants_count' => 3,
        ]);

        $res->assertStatus(409)
            ->assertJson(['message' => 'Guide is already booked for this date.']);
    }
}
