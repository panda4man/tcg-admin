<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Card extends Model implements HasMedia
{
    use HasFactory;
    use SoftDeletes;
    use InteractsWithMedia;

    protected $fillable = ['title', 'card_number', 'game_text', 'lore'];

    // -----------------------
    //      Relationships

    public function collections()
    {
        return $this->belongsToMany(Collection::class)->withPivot(['count'])->withTimestamps();
    }

    public function culture()
    {
        return $this->belongsTo(CardCulture::class, 'card_culture_id');
    }

    public function series()
    {
        return $this->belongsTo(Series::class);
    }

    public function rarity()
    {
        return $this->belongsTo(CardRarity::class, 'card_rarity_id');
    }

    public function variants()
    {
        return $this->hasMany(CardVariant::class);
    }

    // -----------------------
    //      Scopes

    public function scopeForSeries(Builder $query, Series $series)
    {
        $query->whereHas('series', function (Builder $q) use($series) {
            $q->where("{$series->getTable()}.id", $series->id);
        });
    }

    // -----------------------
    //      Media

    public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion('thumb')
            ->width(80)
            ->height(80);
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('primary')->singleFile();
    }
}
