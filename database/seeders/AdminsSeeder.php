<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class AdminsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $admins = [
            [
                'email' => 'ddrew.clinton@gmail.com',
                'name'  => 'Andrew Clinton',
            ]
        ];

        collect($admins)->each(function ($user) {
            User::updateOrCreate([
                'email' => $user['email']
            ], [
                'password' => bcrypt(Str::random(16)),
                'name'     => $user['name']
            ]);
        });
    }
}
