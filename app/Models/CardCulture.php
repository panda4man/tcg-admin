<?php

namespace App\Models;

use App\Models\Concerns\HasGame;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class CardCulture extends Model
{
    use HasFactory;
    use SoftDeletes;
    use HasGame;

    // -----------------------
    //      Relationships

    public function cards(): HasMany
    {
        return $this->hasMany(Card::class);
    }

    public function game(): BelongsTo
    {
        return $this->belongsTo(Game::class);
    }

    public function alignment(): BelongsTo
    {
        return $this->belongsTo(CardAlignment::class, 'card_alignment_id');
    }

    // -----------------------
    //      Scopes

    public function scopeForAlignment(Builder $query, CardAlignment $alignment): void
    {
        $query->whereHas('alignment', function (Builder $q) use($alignment) {
            $q->where("{$alignment->getTable()}.id", $alignment->id);
        });
    }

    public function scopeWithCardCount(Builder $query)
    {
        $query->withCount('cards');
    }
}
