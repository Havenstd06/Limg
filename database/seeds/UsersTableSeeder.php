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
        ])->save();

        factory(App\User::class, 10)->create();
    }
}
