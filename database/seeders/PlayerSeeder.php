<?php

namespace Database\Seeders;

use App\Models\Game;
use App\Models\player;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PlayerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::all();
        $games = Game::all();
        foreach($users as $user)
        {
            $gamesToAttend = $games->random(rand(1,3));

            foreach($gamesToAttend as $game)
            {
                Player::create([
                    'user_id' => $user->id,
                    'game_id' => $game->id,
                ]);
            }
        }
    }
}
