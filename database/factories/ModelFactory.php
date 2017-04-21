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
        'location' =>$faker->address,
    ];
});

$factory->define(App\Location::class, function (Faker\Generator $faker) {
    $articleIDs = \App\Article::pluck('id')->toArray();
    $articleID = $faker->randomElement($articleIDs);

    $exist = true;
    while($exist) {
        $locations = \App\Location::where('locationtable_id', $articleID)->where('locationtable_type', 'App\Article')->get();
        if(count($locations)) {
            $articleID = $faker->randomElement($articleIDs);
        } else
            $exist = false;

    }
    return [
        'title' => $faker->streetName,
        'address' => $faker->address,
        'locationtable_type' => 'App\Article',
        'locationtable_id' => $articleID,
        'x' => $faker->latitude,
        'y' => $faker->longitude,
    ];
});

$factory->define(App\UserRelation::class, function (Faker\Generator $faker) {
    $userIDs = \App\User::pluck('id')->toArray();
    $relationTypes = \App\RelationType::pluck('id')->toArray();
    $userID = $faker->randomElement($userIDs);
    $relationID = $faker->randomElement($userIDs);
    $locations = \App\Location::pluck('id')->toArray();
    $repeat = true;
    while($userID == $relationID || $repeat) {
        $relation = App\UserRelation::where('user_id', $userID)->where('relation_id', $relationID)->first();
        if(count($relation)) {
            $relationID = $faker->randomElement($userIDs);
        } else
            $repeat = false;
    }
    return [
        'user_id' => $userID,
        'relation_id' => $relationID,
        'relation_type' => $faker->randomElement($relationTypes),
        'review_articles' => $faker->boolean(80) ? 1 : 0,
        'articles_reviewed' => $faker->boolean(80) ? 1 : 0,
        'notify_activities' => $faker->boolean(70) ? 1 : 0,
        'location' =>$faker->randomElement($locations),
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
    $articleIDs = \App\Article::pluck('id')->toArray();
    $id = $faker->randomElement($articleIDs);
    $order = $faker->biasedNumberBetween(1, 4);
    $repeat = true;
    while($repeat) {
        $resource = \App\MediaResource::where('resourcetable_id', $id)->where('order', $order)->first();
        if(count($resource)) {
            $id = $faker->randomElement($articleIDs);
            $order = $faker->biasedNumberBetween(1, 4);
        } else
            $repeat = false;
    }
    return [
        'resourcetable_type' => 'App\Article',
        'resourcetable_id' => $id,
        'url' => $faker->imageUrl(320, 320),
        'order' => $order,
    ];
});