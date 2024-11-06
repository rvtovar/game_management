<?php

namespace App\Policies;

use App\Models\Player;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class PlayerPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(?User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(?User $user, Player $player): bool
    {
        return true;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return true;
    }

    public function delete(User $user, Player $player): bool
    {
        return $user->id === $player->user_id || $user->id === $player->game->user_id;
    }

    /**
     * Determine whether the user can restore the model.
     */
//    public function restore(User $user, Player $player): bool
//    {
//        //
//    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Player $player): bool
    {
        //
    }
}
