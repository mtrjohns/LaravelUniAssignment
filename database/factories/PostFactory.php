<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Post;
use Faker\Generator as Faker;

$factory->define(Post::class, function (Faker $faker) {
    return [
        // Assign a User to each post
        'user_id' => $faker->unique(true)->numberBetween(1, 50),
        // Assign post to a thread
        'thread_id' => $faker->unique(true)->numberBetween(1, 50),
        // Assign a sentence to a post
        'post_content' => $faker->sentence($nbWords = 23, $variableNbWords = true),
    ];
});