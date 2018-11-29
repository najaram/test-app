<?php

use App\Photo;
use Illuminate\Database\Seeder;

class PhotoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker\Factory::create();

        $imageExt = uniqid() . '.jpg';
        $imagePathRel = '/local/' . $imageExt;
        $imageFullPath = storage_path('app') . $imagePathRel;
        copy("http://via.placeholder.com/250x250", $imageFullPath);

        for ($i = 0; $i < 5; $i++) {
            Photo::create([
                'user_id' => $i + 1,
                'title'   => $faker->word,
                'path'    => $imagePathRel,
                'name'    => $imageExt
            ]);
        }
    }
}
