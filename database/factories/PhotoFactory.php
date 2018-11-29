<?php

use Faker\Generator as Faker;

$imageExt = uniqid() . '.jpg';
$imagePathRel = '/local/' . $imageExt;
$imageFullPath = storage_path('app') . $imagePathRel;
copy("http://via.placeholder.com/250x250", $imageFullPath);

$factory->define(\App\Photo::class, function (Faker $faker) use ($imageExt, $imagePathRel) {
    return [
        'user_id' => function () {
            return factory(\App\User::class)->create()->id;
        },
        'title' => $faker->word,
        'path' => $imagePathRel,
        'name' => $imageExt
    ];
});
