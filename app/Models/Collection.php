<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Collection extends Model
{
    use HasFactory;
    use SoftDeletes;

    public function cards(): BelongsToMany
    {
        return $this->belongsToMany(Card::class)->withPivot([
            'count'
        ])->withTimestamps();
    }

    public function decks(): HasMany
    {
        return $this->hasMany(Deck::class);
    }

    public function game(): BelongsTo
    {
        return $this->belongsTo(Game::class);
    }

    public function scopeWithCardCount(Builder $query)
    {
        $query->addSelect([
            'cards_total_count' => \DB::table('card_collection as cc')
                                      ->whereColumn('cc.collection_id', 'collections.id')
                                      ->selectRaw('SUM(cc.count)')

        ]);
    }
}
