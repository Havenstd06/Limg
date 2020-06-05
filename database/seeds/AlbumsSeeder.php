<?php

use App\Album;
use Illuminate\Database\Seeder;

class AlbumsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Album::create([
            'name' => 'Brand Logo!',
            'slug' => 'brand-logo',
            'user_id' => 2,
        ])->images()->attach([
            1, 2, 3, 4, 5, 6, 7, 8, 9,
        ]);
    }
}
