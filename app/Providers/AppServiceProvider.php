<?php

namespace App\Providers;

use App\Models\Game;
use App\Models\player;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */


    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
//        Gate::define('update', function($user, Game $game){
//            return $user->id === $game->user_id;
//        });
//
//        Gate::define('delete', function($user, Game $game){
//            return $user->id === $game->user_id;
//        });
//
//        Gate::define('delete-player', function($user, Game $game, Player $player){
//            return $user->id === $game->user_id || $user->id === $player->user_id;
//
//        });
        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(60)->by(
                $request->user()?->id ?: $request->ip()
            );
        });

    }
}
