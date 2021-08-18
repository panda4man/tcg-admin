<?php

namespace App\Nova;

use App\Models\CardRarity;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\BelongsToMany;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;

class Collection extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = \App\Models\Collection::class;

    public static $group = 'Personal';

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'name';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'id',
        'name'
    ];

    /**
     * Get the fields displayed by the resource.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function fields(Request $request)
    {
        return [
            ID::make(__('ID'), 'id')->sortable(),
            Text::make('Name')->sortable()->rules('required'),
            BelongsTo::make('Game')->rules('required'),
            BelongsTo::make('User')->rules('required'),
            BelongsToMany::make('Cards', 'cards', TcgCard::class)->searchable()->fields(function () {
                return [
                    Number::make('Count')
                ];
            }),
            Number::make('Cards Count', 'cards_total_count')->exceptOnForms(),
            Number::make('Rare Count')->displayUsing(function ($target, $resource) {
                return $resource->cards()->forRarity(
                    CardRarity::whereName('R')->first()
                )->count();
            })->onlyOnDetail()
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
        return [];
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

    public static function indexQuery(NovaRequest $request, $query)
    {
        return $query->withCardCount();
    }

    public static function detailQuery(NovaRequest $request, $query)
    {
        return $query->withCardCount();
    }

    public static function relatableQuery(NovaRequest $request, $query)
    {
        //only show collections owned by the user when attaching to cards
        if ($request->route('resource') === TcgCard::uriKey()
            || $request->route('resource') == Deck::uriKey()) {
            $query->forUser(auth()->user());
        }

        return $query;
    }
}
