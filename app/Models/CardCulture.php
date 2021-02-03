<?php

namespace App\Models;

use App\Models\Concerns\HasGame;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CardCulture extends Model
{
    use HasFactory;
    use SoftDeletes;
    use HasGame;

    // -----------------------
    //      Relationships

    public function game()
    {
        return $this->belongsTo(Game::class);
    }

    public function alignment()
    {
        return $this->belongsTo(CardAlignment::class, 'card_alignment_id');
    }
}
