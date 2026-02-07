<?php

namespace Database\Seeders;

use App\Models\Event;
use App\Models\Recipient;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database with demo-ready data.
     */
    public function run(): void
    {
        // Seed gifts first
        $this->call(GiftSeeder::class);

        // Create demo user with pre-verified account
        $user = User::create([
            'name' => 'Sarah Ahmed',
            'email' => 'demo@giftsync.com',
            'password' => Hash::make('password'),
            'phone' => '0312-3456789',
            'email_verified_at' => now(),
            'phone_verified_at' => now(),
            'role' => 'user',
        ]);

        // Create admin user
        User::create([
            'name' => 'Admin',
            'email' => 'admin@giftsync.com',
            'password' => Hash::make('password'),
            'phone' => '0300-0000000',
            'email_verified_at' => now(),
            'phone_verified_at' => now(),
            'role' => 'admin',
        ]);

        // Create recipients for the demo user
        $mom = Recipient::create(['user_id' => $user->id, 'name' => 'Amina Ahmed', 'relationship' => 'Mother']);
        $friend = Recipient::create(['user_id' => $user->id, 'name' => 'Ali Hassan', 'relationship' => 'Friend']);
        $sister = Recipient::create(['user_id' => $user->id, 'name' => 'Fatima Ahmed', 'relationship' => 'Sister']);

        // Create demo events
        Event::create([
            'user_id' => $user->id,
            'recipient_id' => $mom->id,
            'gift_id' => 1, // Premium Flower Bouquet
            'title' => "Mom's Birthday",
            'event_date' => now()->addDays(5),
            'type' => 'birthday',
            'notification_days' => 3,
            'status' => 'scheduled',
        ]);

        Event::create([
            'user_id' => $user->id,
            'recipient_id' => $friend->id,
            'gift_id' => 5, // Smart Watch
            'title' => "Ali's Graduation Party",
            'event_date' => now()->addDays(14),
            'type' => 'custom',
            'notification_days' => 7,
            'status' => 'scheduled',
        ]);

        Event::create([
            'user_id' => $user->id,
            'recipient_id' => $sister->id,
            'gift_id' => null,
            'title' => "Fatima's Anniversary",
            'event_date' => now()->addDays(30),
            'type' => 'anniversary',
            'notification_days' => 7,
            'status' => 'pending',
        ]);
    }
}
