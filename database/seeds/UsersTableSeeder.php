<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Auto generated seed file.
     *
     * @return void
     */
    public function run()
    {
        factory(App\User::class)->create([
            'username' => 'Anonymous',
            'email' => 'anonymous@example.com',
            'password' => bcrypt(env('ANON_PASSWORD')),
        ])->save();

        factory(App\User::class)->create([
            'username' => 'Havens',
            'email' => 'me@hvs.cx',
            'role' => 1,
        ])->save();

        factory(App\User::class, 3)->create();
    }
}
