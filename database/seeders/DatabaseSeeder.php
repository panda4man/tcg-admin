<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(AdminsSeeder::class);
        $this->call(GamesTableSeeder::class);
        $this->call(SeriesTableSeeder::class);
        $this->call(CardRaritiesTableSeeder::class);
        $this->call(CardAlignmentsTableSeeder::class);
        $this->call(CardCulturesTableSeeder::class);
    }
}
