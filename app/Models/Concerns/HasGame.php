<?php


namespace App\Models\Concerns;


use App\Models\Game;
use Illuminate\Database\Eloquent\Builder;

trait HasGame
{
    public function scopeForGame(Builder $query, Game $game)
    {
        $query->whereHas('game', function (Builder $q) use ($game) {
            $q->where("{$game->getTable()}.id", $game->id);
        });
    }
}
