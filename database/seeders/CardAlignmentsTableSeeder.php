<?php

namespace Database\Seeders;

use App\Models\CardAlignment;
use App\Models\Game;
use Illuminate\Database\Seeder;

class CardAlignmentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $alignments = [
            [
                'name' => 'Free Peoples'
            ],
            [
                'name' => 'Shadow'
            ]
        ];

        $game = Game::firstWhere(['name' => 'The Lord of the Rings']);

        if (!$game) {
            return;
        }

        collect($alignments)->each(function ($block) use ($game) {
            $al = CardAlignment::where([
                'name' => $block['name']
            ])
                ->forGame($game)
                ->first();

            if (!$al) {
                CardAlignment::make([
                    'name' => $block['name']
                ])
                    ->game()
                    ->associate($game)
                    ->save();
            }
        });
    }
}
