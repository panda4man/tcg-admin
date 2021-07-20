<?php

namespace App\Models;

use App\Models\Concerns\HasGame;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class CardRarity extends Model
{
    use HasFactory;
    use SoftDeletes;
    use HasGame;

    protected $fillable = ['name', 'label'];

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
}
