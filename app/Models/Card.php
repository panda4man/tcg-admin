<?php

namespace App\Models;

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

    // -----------------------
    //      Relationships

    public function collections()
    {
        return $this->belongsToMany(Collection::class)->withPivot(['count'])->withTimestamps();
    }

    public function culture()
    {
        return $this->belongsTo(CardCulture::class);
    }

    public function series()
    {
        return $this->belongsTo(Series::class);
    }

    public function rarity()
    {
        return $this->belongsTo(CardRarity::class);
    }

    public function variants()
    {
        return $this->hasMany(CardVariant::class);
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
