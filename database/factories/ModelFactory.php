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
    $ownerID = $faker->randomElement($userIDs);
    $forward = $ownerID;
    if($faker->boolean(20)) {
        $forward = $faker->randomElement($userIDs);
    }
    return [
        'title' => $faker->sentence,
        'language_id' => $faker->biasedNumberBetween(1, 2),
        'original_id' => $forward,
        'content' => $faker->paragraph(5, true),
        'updated_by' => $ownerID,
        'created_by' => $ownerID,
    ];
});

$factory->define(App\UserRelation::class, function (Faker\Generator $faker) {
    $userIDs = \App\User::pluck('id')->toArray();
    $relationTypes = \App\RelationType::pluck('id')->toArray();
    $userID = $faker->randomElement($userIDs);
    $relationID = $faker->randomElement($userIDs);
    $repeat = true;
    while($userID == $relationID || $repeat) {
        $relationID = $faker->randomElement($userIDs);
        $relation = App\UserRelation::where('user_id', $userID)->where('relation_id', $relationID)->first();
        $repeat = count($relation) ? true : false;
    }
    return [
        'user_id' => $userID,
        'relation_id' => $relationID,
        'relation_type' => $faker->randomElement($relationTypes),
        'review_articles' => $faker->boolean(80) ? 1 : 0,
        'articles_reviewed' => $faker->boolean(80) ? 1 : 0,
        'notify_activities' => $faker->boolean(70) ? 1 : 0,
    ];
});

$factory->define(App\Comment::class, function (Faker\Generator $faker) {
    $articleIDs = \App\Article::pluck('id')->toArray();
    $userIDs = \App\User::pluck('id')->toArray();
    $ownerID = $faker->randomElement($userIDs);
    return [
        'article_id' => $faker->randomElement($articleIDs),
        'content' => $faker->paragraph(2, true),
        'updated_by' => $ownerID,
        'created_by' => $ownerID,
    ];
});

$factory->define(App\MediaResource::class, function (Faker\Generator $faker) {
    $articleIDs = \App\MediaResource::pluck('id')->toArray();
    $userIDs = \App\User::pluck('id')->toArray();
    $ownerID = $faker->randomElement($userIDs);
    return [
        'article_id' => $faker->randomElement($articleIDs),
        'content' => $faker->paragraph(2, true),
        'updated_by' => $ownerID,
        'created_by' => $ownerID,
    ];
});