<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Photo;
use Faker\Generator as Faker;
use Illuminate\Support\Facades\DB;

$factory->define(Photo::class, function (Faker $faker) {

    $ann = DB::table('announcements')->select('id')->inRandomOrder()->first();

    return [
        'url' => $faker->imageUrl($width = 640, $height = 480, 'cats'),
        'announcement_id' => $ann->id,
    ];
});
