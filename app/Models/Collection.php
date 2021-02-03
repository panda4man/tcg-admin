<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Collection extends Model
{
    use HasFactory;
    use SoftDeletes;

    public function cards()
    {
        return $this->belongsToMany(Card::class)->withPivot([
            'count'
        ])->withTimestamps();
    }
}
