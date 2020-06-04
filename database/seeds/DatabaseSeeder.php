<?php

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
        $this->call(ImagesTableSeeder::class);
        $this->call(DomainsTableSeeder::class);
        $this->call(AlbumsSeeder::class);
    }
}
