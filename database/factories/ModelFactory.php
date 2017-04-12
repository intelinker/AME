<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\User::class, function (Faker\Generator $faker) {
    static $password;

    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'password' => $password ?: $password = bcrypt('secret'),
        'remember_token' => str_random(10),
        'avatar' => $faker->imageUrl(256, 256),
//        'phone' => $faker->unique()->phoneNumber(11),
//        'status' => $faker->randomDigit(1, 5),
        'uid' => str_random(18),
    ];
});

$factory->define(App\Article::class, function (Faker\Generator $faker) {
    $userIDs = \App\User::pluck('id')->toArray();

    return [
        'title' => $faker->sentence,
        'language_id' => $faker->biasedNumberBetween(1, 2),
//        'original_id' => $faker->biasedNumberBetween(0, 2),
        'content' => $faker->paragraph(5, true),
        'forwarded' => $faker->biasedNumberBetween(0,5),
        'updated_by' => $faker->randomElement($userIDs),
        'created_by' => $faker->randomElement($userIDs),
    ];
});