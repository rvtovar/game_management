<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\GameResource;
use App\Http\Traits\CanLoadRelationships;
use App\Models\Game;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class GameController extends Controller
{
    use CanLoadRelationships;
    /**
     * Display a listing of the resource.
     */
    private array $relations = ['user', 'players', 'players.user'];



    public function index()
    {
        Gate::authorize('viewAny', Game::class);
        $query = Game::query();
        //$relations = ['user', 'players', 'players.user'];

        $query = $this->loadRelationships($query, $this->relations);
        return GameResource::collection($query->latest()->paginate());
    }



    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        Gate::authorize('create', Game::class);
        $game = Game::create([
            ...$request->validate([
                'name'=>'required|string|max:255',
                'description'=>'nullable|string',
                'location'=>'required|string|max:255',
                'start_time'=>'required|date',
                'end_time'=>'required|date|after:start_date'
            ]),
            'user_id' => $request->user()->id
        ]);

        $game = $this->loadRelationships($game, $this->relations);
        return new GameResource($game);
    }

    /**
     * Display the specified resource.
     */
    public function show(Game $game)
    {
        Gate::authorize('view', $game);
        return new GameResource($this->loadRelationships($game, $this->relations));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Game $game)
    {
        Gate::authorize('update', $game);
        $game->update($request->validate([
            'name'=>'sometimes|string|max:255',
            'description'=>'nullable|string',
            'location'=>'sometimes|string|max:255',
            'start_time'=>'sometimes|date',
            'end_time'=>'sometimes|date|after:start_date'
        ]));

        return new GameResource($this->loadRelationships($game, $this->relations));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Game $game)
    {
        Gate::authorize('delete', $game);
        $game->delete();
        return response()->json(['message' => 'Game deleted']);
    }
}
