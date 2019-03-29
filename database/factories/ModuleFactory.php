<?php

use Faker\Generator as Faker;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(App\Course::class, function (Faker $faker) {
    require_once('TestData.php');
    $options = getKeys();
    $selection = $faker->randomElement($options);
    return [
        'name' => $faker->name,
        'course_key' => $selection[0],
    ];
});
