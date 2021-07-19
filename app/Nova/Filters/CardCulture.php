<?php

namespace App\Nova\Filters;

use App\Models\CardCulture as CardCultureModel;
use Illuminate\Http\Request;
use Laravel\Nova\Filters\Filter;

class CardCulture extends Filter
{
    /**
     * The filter's component.
     *
     * @var string
     */
    public $component = 'select-filter';

    /**
     * Apply the filter to the given query.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param mixed $value
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function apply(Request $request, $query, $value)
    {
        return $query->whereHas('culture', function ($q) use ($value) {
            $q->where('id', $value);
        });
    }

    /**
     * Get the filter's available options.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function options(Request $request)
    {
        return CardCultureModel::orderBy('name')->get()->mapWithKeys(function (CardCultureModel $culture) {
            return [
                $culture->name => $culture->id
            ];
        });
    }
}
