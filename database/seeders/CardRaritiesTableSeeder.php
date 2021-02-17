<?php

namespace Database\Seeders;

use App\Models\CardRarity;
use App\Models\Game;
use Illuminate\Database\Seeder;

class CardRaritiesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $rarities = [
            [
                'name' => 'AFD',
                'label' => 'April Fool\'s Day'
            ],
            [
                'name' => 'D',
                'label' => 'Reprint',
            ],
            [
                'name' => 'M',
                'label' => 'Oversized'
            ],
            [
                'name' => 'SPD',
                'label' => 'Saint Patrick\'s Day'
            ],
            [
                'name' => 'W',
                'label' => 'Online only'
            ],
            [
                'name'  => 'R',
                'label' => 'Rare'
            ],
            [
                'name'  => 'U',
                'label' => 'Uncommon'
            ],
            [
                'name'  => 'C',
                'label' => 'Common'
            ],
            [
                'name'  => 'P',
                'label' => 'Promo'
            ],
            [
                'name'  => 'S',
                'label' => 'Starter'
            ]
        ];

        $game = Game::firstWhere(['name' => 'The Lord of the Rings']);

        if (!$game) {
            return;
        }

        collect($rarities)->each(function ($block) use($game) {
            $rarity = CardRarity::where([
                'name' => $block['name']
            ])->forGame($game)->first();

            if(!$rarity) {
                $rarity = CardRarity::make([
                    'label' => $block['label'],
                    'name' => $block['name'],
                ]);

                $rarity->game()->associate($game)->save();
            } else {
                $rarity->update([
                    'label' => $block['label']
                ]);
            }
        });
    }
}
