<?php

namespace Database\Seeders;

use App\Models\Game;
use App\Models\Series;
use Illuminate\Database\Seeder;

class SeriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $series = [
            [
                'name'       => 'Fellowship of the Ring',
                'set_number' => 1,
            ],
            [
                'name'       => 'Mines of Moria',
                'set_number' => 2
            ],
            [
                'name'       => 'Realms of the Elf-lords',
                'set_number' => 3
            ],
            [
                'name'       => 'The Two Towers',
                'set_number' => 4,
            ],
            [
                'name'       => 'Battle of Helm\'s Deep',
                'set_number' => 5,
            ],
            [
                'name'       => 'Ends of Fangorn',
                'set_number' => 6
            ],
            [
                'name'       => 'Return of the King',
                'set_number' => 7
            ],
            [
                'name'       => 'Siege of Gondor',
                'set_number' => 8,
            ],
            [
                'name'       => 'Reflections',
                'set_number' => 9
            ],
            [
                'name'       => 'Mount Doom',
                'set_number' => 10
            ],
            [
                'name'       => 'Shadows',
                'set_number' => 11,
            ],
            [
                'name'       => 'Black Rider',
                'set_number' => 12
            ],
            [
                'name'       => 'Bloodlines',
                'set_number' => 13
            ],
            [
                'name'       => 'Expanded Middle-earth',
                'set_number' => 14
            ],
            [
                'name'       => 'The Hunters',
                'set_number' => 15
            ],
            [
                'name'       => 'The Wraith Collection',
                'set_number' => 16
            ],
            [
                'name'       => 'Rise of Saruman',
                'set_number' => 17
            ],
            [
                'name'       => 'Treachery and Deceit',
                'set_number' => 18
            ],
            [
                'name'       => 'Ages End',
                'set_number' => 19
            ]
        ];

        $game = Game::firstWhere(['name' => 'The Lord of the Rings']);

        if (!$game) {
            return;
        }

        collect($series)->each(function ($block) use ($game) {
            $series = Series::where([
                'name' => $block['name'],
            ])
                ->forGame($game)
                ->first();

            if (!$series) {
                $series = Series::make([
                    'name'       => $block['name'],
                    'set_number' => $block['set_number']
                ]);

                $series->game()->associate($game)->save();
            } else {
                $series->update([
                    'set_number' => $block['set_number']
                ]);
            }
        });
    }
}
