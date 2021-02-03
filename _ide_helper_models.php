<?php

// @formatter:off
/**
 * A helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */


namespace App\Models{
/**
 * App\Models\Card
 *
 * @property int $id
 * @property string|null $title
 * @property string|null $subtitle
 * @property int|null $card_number
 * @property int|null $twilight_cost
 * @property string|null $type
 * @property string|null $subtype
 * @property string|null $game_text
 * @property string|null $lore
 * @property int|null $card_rarity_id
 * @property int|null $card_culture_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Collection[] $collections
 * @property-read int|null $collections_count
 * @property-read \App\Models\CardCulture $culture
 * @property-read \Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection|\Spatie\MediaLibrary\MediaCollections\Models\Media[] $media
 * @property-read int|null $media_count
 * @property-read \App\Models\CardRarity $rarity
 * @property-read \App\Models\Series $series
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\CardVariant[] $variants
 * @property-read int|null $variants_count
 * @method static \Illuminate\Database\Eloquent\Builder|Card newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Card newQuery()
 * @method static \Illuminate\Database\Query\Builder|Card onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Card query()
 * @method static \Illuminate\Database\Eloquent\Builder|Card whereCardCultureId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Card whereCardNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Card whereCardRarityId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Card whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Card whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Card whereGameText($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Card whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Card whereLore($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Card whereSubtitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Card whereSubtype($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Card whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Card whereTwilightCost($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Card whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Card whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|Card withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Card withoutTrashed()
 */
	class Card extends \Eloquent implements \Spatie\MediaLibrary\HasMedia {}
}

namespace App\Models{
/**
 * App\Models\CardAlignment
 *
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\CardCulture[] $cultures
 * @property-read int|null $cultures_count
 * @property-read \App\Models\Game $game
 * @method static \Illuminate\Database\Eloquent\Builder|CardAlignment forGame(\App\Models\Game $game)
 * @method static \Illuminate\Database\Eloquent\Builder|CardAlignment newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CardAlignment newQuery()
 * @method static \Illuminate\Database\Query\Builder|CardAlignment onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|CardAlignment query()
 * @method static \Illuminate\Database\Query\Builder|CardAlignment withTrashed()
 * @method static \Illuminate\Database\Query\Builder|CardAlignment withoutTrashed()
 */
	class CardAlignment extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\CardCulture
 *
 * @property int $id
 * @property string $name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \App\Models\CardAlignment $alignment
 * @property-read \App\Models\Game $game
 * @method static \Illuminate\Database\Eloquent\Builder|CardCulture forGame(\App\Models\Game $game)
 * @method static \Illuminate\Database\Eloquent\Builder|CardCulture newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CardCulture newQuery()
 * @method static \Illuminate\Database\Query\Builder|CardCulture onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|CardCulture query()
 * @method static \Illuminate\Database\Eloquent\Builder|CardCulture whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CardCulture whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CardCulture whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CardCulture whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CardCulture whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|CardCulture withTrashed()
 * @method static \Illuminate\Database\Query\Builder|CardCulture withoutTrashed()
 */
	class CardCulture extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\CardRarity
 *
 * @property int $id
 * @property string $label
 * @property string $name
 * @property int $game_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \App\Models\Game $game
 * @method static \Illuminate\Database\Eloquent\Builder|CardRarity forGame(\App\Models\Game $game)
 * @method static \Illuminate\Database\Eloquent\Builder|CardRarity newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CardRarity newQuery()
 * @method static \Illuminate\Database\Query\Builder|CardRarity onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|CardRarity query()
 * @method static \Illuminate\Database\Eloquent\Builder|CardRarity whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CardRarity whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CardRarity whereGameId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CardRarity whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CardRarity whereLabel($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CardRarity whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CardRarity whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|CardRarity withTrashed()
 * @method static \Illuminate\Database\Query\Builder|CardRarity withoutTrashed()
 */
	class CardRarity extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\CardVariant
 *
 * @property int $id
 * @property string $name
 * @property string|null $description
 * @property int $card_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \App\Models\Card $card
 * @property-read \Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection|\Spatie\MediaLibrary\MediaCollections\Models\Media[] $media
 * @property-read int|null $media_count
 * @method static \Illuminate\Database\Eloquent\Builder|CardVariant newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CardVariant newQuery()
 * @method static \Illuminate\Database\Query\Builder|CardVariant onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|CardVariant query()
 * @method static \Illuminate\Database\Eloquent\Builder|CardVariant whereCardId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CardVariant whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CardVariant whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CardVariant whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CardVariant whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CardVariant whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CardVariant whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|CardVariant withTrashed()
 * @method static \Illuminate\Database\Query\Builder|CardVariant withoutTrashed()
 */
	class CardVariant extends \Eloquent implements \Spatie\MediaLibrary\HasMedia {}
}

namespace App\Models{
/**
 * App\Models\Collection
 *
 * @property int $id
 * @property string|null $name
 * @property int $game_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Card[] $cards
 * @property-read int|null $cards_count
 * @method static \Illuminate\Database\Eloquent\Builder|Collection newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Collection newQuery()
 * @method static \Illuminate\Database\Query\Builder|Collection onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Collection query()
 * @method static \Illuminate\Database\Eloquent\Builder|Collection whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Collection whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Collection whereGameId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Collection whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Collection whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Collection whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|Collection withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Collection withoutTrashed()
 */
	class Collection extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Game
 *
 * @property int $id
 * @property string $name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection|\Spatie\MediaLibrary\MediaCollections\Models\Media[] $media
 * @property-read int|null $media_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Series[] $series
 * @property-read int|null $series_count
 * @method static \Illuminate\Database\Eloquent\Builder|Game newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Game newQuery()
 * @method static \Illuminate\Database\Query\Builder|Game onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Game query()
 * @method static \Illuminate\Database\Eloquent\Builder|Game whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Game whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Game whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Game whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Game whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|Game withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Game withoutTrashed()
 */
	class Game extends \Eloquent implements \Spatie\MediaLibrary\HasMedia {}
}

namespace App\Models{
/**
 * App\Models\Series
 *
 * @property int $id
 * @property string|null $name
 * @property int $game_id
 * @property int|null $set_number
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Card[] $cards
 * @property-read int|null $cards_count
 * @property-read \App\Models\Game $game
 * @property-read \Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection|\Spatie\MediaLibrary\MediaCollections\Models\Media[] $media
 * @property-read int|null $media_count
 * @method static \Illuminate\Database\Eloquent\Builder|Series forGame(\App\Models\Game $game)
 * @method static \Illuminate\Database\Eloquent\Builder|Series newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Series newQuery()
 * @method static \Illuminate\Database\Query\Builder|Series onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Series query()
 * @method static \Illuminate\Database\Eloquent\Builder|Series whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Series whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Series whereGameId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Series whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Series whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Series whereSetNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Series whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|Series withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Series withoutTrashed()
 */
	class Series extends \Eloquent implements \Spatie\MediaLibrary\HasMedia {}
}

namespace App\Models{
/**
 * App\Models\User
 *
 * @property int $id
 * @property string $name
 * @property string $email
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 * @property string $password
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @property-read int|null $notifications_count
 * @method static \Illuminate\Database\Eloquent\Builder|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User query()
 * @method static \Illuminate\Database\Eloquent\Builder|User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereUpdatedAt($value)
 */
	class User extends \Eloquent {}
}

