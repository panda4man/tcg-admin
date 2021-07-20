<?php

namespace App\Nova;

use Ebess\AdvancedNovaMediaLibrary\Fields\Images;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\BelongsToMany;
use Laravel\Nova\Fields\HasMany;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;

class Card extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = \App\Models\Card::class;

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'title';

    public static $perPageOptions = [25, 50, 100];

    public static $perPageViaRelationship = 25;

    public static $group = 'General';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'id',
        'title',
        'game_text'
    ];

    public static function uriKey()
    {
        return 'tcgCards';
    }

    public function title() //maybe optimize this..loading unecessary models with series and rarity..
    {
        return sprintf("%d%s%d %s", $this->series->set_number, $this->rarity->name, $this->card_number, $this->title);
    }

    /**
     * Get the fields displayed by the resource.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function fields(Request $request)
    {
        return [
            ID::make(__('ID'), 'id')->sortable()->hideFromIndex(),
            Number::make('Card #', 'card_number')->rules('nullable')->sortable(),
            Text::make('Title')->sortable()->rules('required'),
            Images::make('Photo', 'primary')
                  ->conversionOnIndexView('thumb')
                  ->rules('nullable'),
            BelongsTo::make('Rarity', 'rarity', CardRarity::class)->sortable()->rules('required'),
            BelongsTo::make('Culture', 'culture', CardCulture::class)->sortable(),
            Text::make('Game Text')->rules('nullable')->hideFromIndex(),
            Text::make('Lore')->nullable()->hideFromIndex(),
            BelongsTo::make('Series')->rules('required'),
            HasMany::make('Variants', 'variants', CardVariant::class),
            BelongsToMany::make('Collections')->fields(function () {
                return [
                    Number::make('Count')
                ];
            }),
            BelongsToMany::make('Decks')->fields(function () {
                return [
                    Number::make('Count')
                ];
            })
        ];
    }

    /**
     * Get the cards available for the request.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function cards(Request $request)
    {
        return [];
    }

    /**
     * Get the filters available for the resource.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function filters(Request $request)
    {
        return [
            new \App\Nova\Filters\CardRarity(),
            new \App\Nova\Filters\CardCulture(),
            new \App\Nova\Filters\CardVariant()
        ];
    }

    /**
     * Get the lenses available for the resource.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function lenses(Request $request)
    {
        return [];
    }

    /**
     * Get the actions available for the resource.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function actions(Request $request)
    {
        return [];
    }

    public static function relatableQuery(NovaRequest $request, $query)
    {
        //attaching a card to a collection
        //filter to only cards not that collection
        if($request->route('resource') == 'collections') {
            /** @var \App\Models\Collection $collection */
            $collection = $request->findModelOrFail();

            $query->notInCollection($collection);
        }

        //attaching a card to a deck
        //filter to only cards in that deck's collection
        if($request->route('resource') == 'decks') {
            /** @var \App\Models\Deck $deck */
            $deck = $request->findModelOrFail();

            $query->forCollection($deck->collection);
        }

        return $query;
    }
}
