<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Announcement;
use Faker\Generator as Faker;
use Illuminate\Support\Facades\DB;

$factory->define(Announcement::class, function (Faker $faker) {

    $user = DB::table('users')->select('id')->inRandomOrder()->first();

    return [
        'title' => rtrim($faker->sentence(rand(2,4)), '.'),
        'description' => $faker->text(rand(400, 1000)),
        'price' => $faker->randomFloat(2, 1),
        'user_id' =>  $user->id,

    ];
});
