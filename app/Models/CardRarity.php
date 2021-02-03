<?php

namespace App\Models;

use App\Models\Concerns\HasGame;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CardRarity extends Model
{
    use HasFactory;
    use SoftDeletes;
    use HasGame;

    protected $fillable = ['name', 'label'];

    // -----------------------
    //      Relationships

    public function game()
    {
        return $this->belongsTo(Game::class);
    }
}
