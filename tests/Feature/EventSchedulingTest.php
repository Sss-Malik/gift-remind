<?php

namespace Tests\Feature;

use App\Models\Gift;
use App\Models\Recipient;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class EventSchedulingTest extends TestCase
{
    use RefreshDatabase;

    public function test_event_must_be_scheduled_at_least_seven_days_ahead(): void
    {
        $user = User::factory()->create();
        $recipient = Recipient::create([
            'user_id' => $user->id,
            'name' => 'Amina Ahmed',
            'relationship' => 'Mother',
        ]);

        $response = $this
            ->actingAs($user)
            ->post(route('events.store'), $this->eventPayload([
                'recipient_id' => $recipient->id,
                'event_date' => now()->addDays(6)->toDateString(),
                'notification_days' => 7,
            ]));

        $response->assertSessionHasErrors('event_date');
        $this->assertDatabaseCount('events', 0);
    }

    public function test_notification_days_cannot_exceed_days_remaining_before_event(): void
    {
        $user = User::factory()->create();
        $recipient = Recipient::create([
            'user_id' => $user->id,
            'name' => 'Amina Ahmed',
            'relationship' => 'Mother',
        ]);

        $response = $this
            ->actingAs($user)
            ->post(route('events.store'), $this->eventPayload([
                'recipient_id' => $recipient->id,
                'event_date' => now()->addDays(10)->toDateString(),
                'notification_days' => 11,
            ]));

        $response->assertSessionHasErrors('notification_days');
        $this->assertDatabaseCount('events', 0);
    }

    public function test_event_can_be_scheduled_exactly_seven_days_ahead(): void
    {
        $user = User::factory()->create();
        $recipient = Recipient::create([
            'user_id' => $user->id,
            'name' => 'Amina Ahmed',
            'relationship' => 'Mother',
        ]);

        $response = $this
            ->actingAs($user)
            ->post(route('events.store'), $this->eventPayload([
                'recipient_id' => $recipient->id,
                'event_date' => now()->addDays(7)->toDateString(),
                'notification_days' => 7,
            ]));

        $response->assertRedirect(route('events.index'));
        $this->assertDatabaseHas('events', [
            'user_id' => $user->id,
            'recipient_id' => $recipient->id,
            'notification_days' => 7,
        ]);
    }

    private function eventPayload(array $overrides = []): array
    {
        $gift = Gift::create([
            'name' => 'Premium Flower Bouquet',
            'description' => 'Fresh roses and lilies.',
            'price' => 5000,
            'category' => 'Flowers',
            'image_path' => 'https://example.com/flowers.jpg',
            'is_active' => true,
        ]);

        return array_merge([
            'title' => "Mom's Birthday",
            'event_date' => now()->addDays(8)->toDateString(),
            'type' => 'birthday',
            'notification_days' => 7,
            'recipient_id' => null,
            'new_recipient_name' => 'Amina Ahmed',
            'gift_id' => $gift->id,
        ], $overrides);
    }
}
