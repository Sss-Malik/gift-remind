<?php

namespace App\Console\Commands;

use App\Models\Event;
use App\Notifications\EventReminder;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class SendEventReminders extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:send-reminders';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check for upcoming events and send notifications based on user preferences';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Scanning for upcoming events...');

        // Logic:
        // We need to find events where:
        // (Event Date - Today) == User's Notification Days Setting

        // We iterate through all "Scheduled" events.
        // Note: In a massive scale app, we would query via SQL DATEDIFF,
        // but for MVP PHP logic is clearer and safer for database abstraction.

        $events = Event::with(['user', 'recipient', 'gift', 'payment'])
            ->where('status', 'scheduled')
            ->whereDate('event_date', '>', Carbon::now()) // Future events only
            ->chunk(100, function ($events) {

                foreach ($events as $event) {
                    $daysUntilEvent = Carbon::now()->startOfDay()->diffInDays($event->event_date, false);

                    // Check if today is the day to notify
                    if ($daysUntilEvent == $event->notification_days) {

                        $this->info("Sending reminder for event ID: {$event->id} ({$event->title})");

                        // Send Email
                        try {
                            $event->user->notify(new EventReminder($event));

                            // Trigger SMS Stub manually since it's not a standard driver yet
                            (new EventReminder($event))->toSmsStub($event->user);

                        } catch (\Exception $e) {
                            Log::error("Failed to notify User {$event->user_id}: " . $e->getMessage());
                        }
                    }
                }
            });

        $this->info('Reminder process completed.');
    }
}
