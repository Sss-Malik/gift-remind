<?php

namespace Tests\Feature;

use App\Models\Gift;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class GiftDetailsTest extends TestCase
{
    use RefreshDatabase;

    public function test_authenticated_user_can_view_active_gift_details(): void
    {
        $user = User::factory()->create();
        $gift = Gift::create([
            'name' => 'Premium Flower Bouquet',
            'description' => 'Fresh roses and lilies.',
            'price' => 5000,
            'category' => 'Flowers',
            'image_path' => 'https://example.com/flowers.jpg',
            'is_active' => true,
        ]);

        $response = $this
            ->actingAs($user)
            ->get(route('gifts.show', $gift));

        $response->assertOk();
        $response->assertSee('Gift Details');
        $response->assertSee($gift->name);
        $response->assertSee(route('events.create', ['gift_id' => $gift->id]), false);
    }

    public function test_inactive_gift_details_page_is_not_accessible(): void
    {
        $user = User::factory()->create();
        $gift = Gift::create([
            'name' => 'Hidden Gift',
            'description' => 'Hidden gift.',
            'price' => 2500,
            'category' => 'Secret',
            'image_path' => 'https://example.com/hidden.jpg',
            'is_active' => false,
        ]);

        $this
            ->actingAs($user)
            ->get(route('gifts.show', $gift))
            ->assertNotFound();
    }
}
