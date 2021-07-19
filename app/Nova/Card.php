<?php

namespace App\Nova;

use Ebess\AdvancedNovaMediaLibrary\Fields\Images;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\BelongsTo;
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
        return 'tcg-cards';
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
            Text::make('Title')->sortable(),
            Images::make('Photo', 'primary')
                  ->conversionOnIndexView('thumb')
                  ->rules('nullable'),
            BelongsTo::make('Rarity', 'rarity', CardRarity::class)->sortable(),
            BelongsTo::make('Culture', 'culture', CardCulture::class)->sortable(),
            Text::make('Game Text')->rules('nullable')->hideFromIndex(),
            BelongsTo::make('Series'),
            HasMany::make('Variants', 'variants', CardVariant::class)->hideFromIndex()
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
        if($request->route('field') == 'tcg-cards') {
            $collection = $request->findModelOrFail();

            $query->whereDoesntHave('collections', function ($q) use($collection) {
                $q->where('collections.id', $collection->id);
            });
        }

        return $query;
    }
}
