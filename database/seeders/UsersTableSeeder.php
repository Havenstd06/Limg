<?php

namespace Database\Seeders;

use App\User;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeders.
     *
     * @return void
     */
    public function run()
    {
        User::factory()->create([
            'username' => 'Anonymous',
            'email'    => 'anonymous@example.com',
            'password' => bcrypt(env('ANON_PASSWORD')),
        ])->save();

        User::factory()->create([
            'username' => 'Havens',
            'email'    => 'me@hvs.cx',
            'role'     => 1,
        ])->save();


        User::factory(3)->create();
    }
}
