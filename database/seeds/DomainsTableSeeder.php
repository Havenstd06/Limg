<?php

use Illuminate\Database\Seeder;

class DomainsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('domains')->insert([
            'name'       => str_replace('https://', '', config('app.url')),
            'url'        => config('app.url'),
            'created_at' => '2020-05-29 00:07:00',
            'updated_at' => '2020-05-29 00:07:00',
        ]);
    }
}
