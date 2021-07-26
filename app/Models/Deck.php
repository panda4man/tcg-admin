<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Deck extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['name'];

    protected $withCount = ['cards'];

    // ---------------------
    //      Relationships

    public function cards(): BelongsToMany
    {
        return $this->belongsToMany(Card::class)->withPivot('count')->withTimestamps();
    }

    public function collection(): BelongsTo
    {
        return $this->belongsTo(Collection::class);
    }

    // ---------------------
    //      Scopes

    public function scopeInCollection(Builder $query, Collection $collection)
    {
        $query->whereHas('collection', function ($query) use ($collection) {
            $query->where("{$collection->getTable()}.id", $collection->id);
        });
    }
}
