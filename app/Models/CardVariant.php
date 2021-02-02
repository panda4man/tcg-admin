<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CardVariant extends Model
{
    use HasFactory;

    public function card()
    {
        return $this->belongsTo(Card::class);
    }
}
