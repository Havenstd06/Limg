<?php

use Illuminate\Database\Seeder;
use TCG\Voyager\Models\Role;
use TCG\Voyager\Models\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Auto generated seed file.
     *
     * @return void
     */
    public function run()
    {
        if (User::count() == 0) {
            $roleAdmin = Role::where('name', 'admin')->firstOrFail();
            $roleUser = Role::where('name', 'user')->firstOrFail();

            factory(App\User::class)->create([
                'username' => 'Anonymous',
                'email' => 'anonymous@example.com',
                'password' => bcrypt(env('ANON_PASSWORD')),
                'role_id' => $roleAdmin->id,
            ])->save();

            factory(App\User::class)->create([
                'username' => 'Havens',
                'email' => 'me@hvs.cx',
                'role_id' => $roleAdmin->id,
            ])->save();

            factory(App\User::class, 10)->create([
                'role_id' => $roleUser->id,
            ]);
        }
    }
}
