<?php

namespace App\Console\Commands;

use App\Notifications\EventReminderNotification;
use Illuminate\Console\Command;
use Illuminate\Support\Str;

class SendEventReminders extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:send-event-reminders';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sends all game players that game is event';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $games = \App\Models\Game::with('players.user')
            ->whereBetween('start_time', [now(), now()->addDay()])
            ->get();

        $gameCount = $games->count();
        $gameLabel = Str::plural('game', $gameCount);


        $this->info("Sending reminders for {$gameCount} {$gameLabel}...");

        $games->each(fn ($game) => $game->players->each(
            fn ($player) => $player->user->notify(
                new EventReminderNotification($game)
            )
        ));
    }
}
