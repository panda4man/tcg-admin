<?php

namespace Database\Seeders;

use App\Models\CardAlignment;
use App\Models\CardCulture;
use App\Models\Game;
use Illuminate\Database\Seeder;

class CardCulturesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $cultures = [
            [
                'name'      => 'Dwarven',
                'alignment' => 'free',
            ],
            [
                'name'      => 'Elven',
                'alignment' => 'free',
            ],
            [
                'name'      => 'Gandalf',
                'alignment' => 'free',
            ],
            [
                'name'      => 'Gollum',
                'alignment' => 'free',
            ],
            [
                'name'      => 'Gondor',
                'alignment' => 'free',
            ],
            [
                'name'      => 'Rohan',
                'alignment' => 'free',
            ],
            [
                'name'      => 'Shire',
                'alignment' => 'free',
            ],
            [
                'name'      => 'Dunland',
                'alignment' => 'shadow',
            ],
            [
                'name'      => 'Gollum',
                'alignment' => 'shadow',
            ],
            [
                'name'      => 'Isengard',
                'alignment' => 'shadow',
            ],
            [
                'name'      => 'Moria',
                'alignment' => 'shadow',
            ],
            [
                'name'      => 'Raider',
                'alignment' => 'shadow',
            ],
            [
                'name'      => 'Ringwraith',
                'alignment' => 'shadow',
            ],
            [
                'name'      => 'Sauron',
                'alignment' => 'shadow',
            ],
            [
                'name'      => 'Men',
                'alignment' => 'shadow',
            ],
            [
                'name'      => 'Orc',
                'alignment' => 'shadow',
            ],
            [
                'name'      => 'Uruk-hai',
                'alignment' => 'shadow',
            ],
            [
                'name'      => 'Wraith',
                'alignment' => 'shadow',
            ]
        ];

        $game = Game::firstWhere(['name' => 'The Lord of the Rings']);
        $map  = [
            'shadow' => CardAlignment::whereName('Shadow')->first(),
            'free'   => CardAlignment::whereName('Free Peoples')->first()
        ];

        if (!$game || !$map['shadow'] || !$map['free']) {
            return;
        }

        collect($cultures)->each(function ($block) use ($game, $map) {
            $culture = CardCulture::where([
                'name' => $block['name']
            ])
                ->forAlignment($map[$block['alignment']])
                ->forGame($game)
                ->first();

            if (!$culture) {
                $culture = CardCulture::make([
                    'name' => $block['name']
                ]);
                $culture->alignment()->associate($map[$block['alignment']]);
                $culture->game()->associate($game)->save();
            }
        });
    }
}
