<?php

namespace App\Models;

use App\Models\Concerns\HasGame;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CardAlignment extends Model
{
    use HasFactory;
    use SoftDeletes;
    use HasGame;

    // -----------------------
    //      Relationships

    public function cultures()
    {
        return $this->hasMany(CardCulture::class);
    }

    public function game()
    {
        return $this->belongsTo(Game::class);
    }
}
