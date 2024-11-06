<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\PlayerResource;
use App\Http\Traits\CanLoadRelationships;
use App\Models\Game;
use App\Models\player;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class PlayerController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    use CanLoadRelationships;
    private array $relations = ['user'];
    public function index(Game $game)
    {
        //Gate::authorize('viewAny', Player::class);
        $players = $this->loadRelationships(
            $game->players()->latest(),
            $this->relations
        );

        return PlayerResource::collection($players->paginate());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Game $game)
    {
        //Gate::authorize('create', Player::class);
       $player = $this->loadRelationships(
           $game->players()->create([
            'user_id' => $request->user()->id,
        ]), $this->relations
       );

       return new PlayerResource($player);
    }

    /**
     * Display the specified resource.
     */
    public function show(Game $game, Player $player)
    {
       // Gate::authorize('view', $player);
        return new PlayerResource($this->loadRelationships($player, $this->relations));
    }

    /**
     * Update the specified resource in storage.
     */


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Game $game, Player $player)
    {
        Gate::authorize('delete-player', [$game, $player]);
        $player->delete();

        return response(status: 204);
    }

}
