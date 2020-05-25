<?php

use Illuminate\Database\Seeder;

class ImagesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('images')->delete();

        \DB::table('images')->insert([
            0 => [
                'id' => 1,
                'title' => 'Limg logo #1',
                'pageName' => 'lNHJ8ot',
                'imageName' => 'lNHJ8ot',
                'path' => '/i/lNHJ8ot.png',
                'extension' => 'png',
                'is_public' => 1,
                'created_at' => '2019-12-19 10:00:00',
                'updated_at' => '2019-12-19 10:00:00',
                'user_id' => 2,
            ],
            1 => [
                'id' => 2,
                'title' => 'Limg banner #1',
                'pageName' => 'gQHOGpS',
                'imageName' => 'gQHOGpS',
                'path' => '/i/gQHOGpS.png',
                'extension' => 'png',
                'is_public' => 1,
                'created_at' => '2019-12-19 10:00:00',
                'updated_at' => '2019-12-19 10:00:00',
                'user_id' => 2,
            ],
            2 => [
                'id' => 3,
                'title' => 'Limg default #1',
                'pageName' => 'ANVbpsT',
                'imageName' => 'ANVbpsT',
                'path' => '/i/ANVbpsT.png',
                'extension' => 'png',
                'is_public' => 1,
                'created_at' => '2019-12-19 10:00:00',
                'updated_at' => '2019-12-19 10:00:00',
                'user_id' => 2,
            ],
            3 => [
                'id' => 4,
                'title' => 'Limg logo #2',
                'pageName' => 'Ujo5lMZ',
                'imageName' => 'Ujo5lMZ',
                'path' => '/i/Ujo5lMZ.png',
                'extension' => 'png',
                'is_public' => 1,
                'created_at' => '2019-12-19 10:00:00',
                'updated_at' => '2019-12-19 10:00:00',
                'user_id' => 2,
            ],
            4 => [
                'id' => 5,
                'title' => 'Limg banner #2',
                'pageName' => 'GsTcFDd',
                'imageName' => 'GsTcFDd',
                'path' => '/i/GsTcFDd.png',
                'extension' => 'png',
                'is_public' => 1,
                'created_at' => '2019-12-19 10:00:00',
                'updated_at' => '2019-12-19 10:00:00',
                'user_id' => 2,
            ],
            5 => [
                'id' => 6,
                'title' => 'Limg default #2',
                'pageName' => 'HoJQtbq',
                'imageName' => 'HoJQtbq',
                'path' => '/i/HoJQtbq.png',
                'extension' => 'png',
                'is_public' => 1,
                'created_at' => '2019-12-19 10:00:00',
                'updated_at' => '2019-12-19 10:00:00',
                'user_id' => 2,
            ],
            6 => [
                'id' => 7,
                'title' => 'Limg logo #3',
                'pageName' => '0aFSTHP',
                'imageName' => '0aFSTHP',
                'path' => '/i/0aFSTHP.png',
                'extension' => 'png',
                'is_public' => 1,
                'created_at' => '2019-12-19 10:00:00',
                'updated_at' => '2019-12-19 10:00:00',
                'user_id' => 2,
            ],
            7 => [
                'id' => 8,
                'title' => 'Limg banner #3',
                'pageName' => 'l1rdKdw',
                'imageName' => 'l1rdKdw',
                'path' => '/i/l1rdKdw.png',
                'extension' => 'png',
                'is_public' => 1,
                'created_at' => '2019-12-19 10:00:00',
                'updated_at' => '2019-12-19 10:00:00',
                'user_id' => 2,
            ],
            8 => [
                'id' => 9,
                'title' => 'Limg default #3',
                'pageName' => 'fDYOALi',
                'imageName' => 'fDYOALi',
                'path' => '/i/fDYOALi.png',
                'extension' => 'png',
                'is_public' => 1,
                'created_at' => '2019-12-19 10:00:00',
                'updated_at' => '2019-12-19 10:00:00',
                'user_id' => 2,
            ],
        ]);
    }
}
