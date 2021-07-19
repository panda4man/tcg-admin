<?php

namespace App\Nova\Filters;

use App\Models\CardRarity as CardRarityModel;
use Illuminate\Http\Request;
use Laravel\Nova\Filters\Filter;

class CardRarity extends Filter
{
    public $name = 'Car Rarity';

    /**
     * The filter's component.
     *
     * @var string
     */
    public $component = 'select-filter';

    /**
     * Apply the filter to the given query.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  mixed  $value
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function apply(Request $request, $query, $value)
    {
        return $query->whereHas('rarity', function ($q) use($value) {
             $q->where('id', $value);
        });
    }

    /**
     * Get the filter's available options.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function options(Request $request)
    {
        return CardRarityModel::orderBy('name')->get()->mapWithKeys(function (CardRarityModel $rarity) {
            return [
                $rarity->label => $rarity->id
            ];
        })->toArray();
    }
}
