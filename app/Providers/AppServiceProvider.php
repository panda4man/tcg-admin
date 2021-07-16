<?php

namespace App\Providers;

use App\Models\Card;
use App\Models\Game;
use App\Models\Series;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Relation::morphMap([
            'card' => Card::class,
            'game' => Game::class,
            'series' => Series::class,
        ]);
    }
}
