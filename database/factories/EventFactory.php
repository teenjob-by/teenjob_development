<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */
use App\Event;
use Illuminate\Support\Str;
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

$factory->define(Event::class, function (Faker $faker) {


    return [
        'title' => $faker->word,
        'city_id' => $faker->numberBetween(1, 5),
        'address' => $faker->address,
        'age' => $faker->numberBetween(16, 20),
        'type_id' => $faker->numberBetween(1, 3),
        'description' => $faker->text(255),
        'location' => $faker->latitude.', '.$faker->longitude,
        'image' => $faker->imageUrl(),
        'date_start' => $faker->dateTimeBetween('-1 month', '+1 month'),
        'date_finish' => $faker->dateTimeBetween('-1 month', '+1 month'),
        'status' => $faker->numberBetween(0, 5),
        'published_at'=>$faker->dateTimeBetween('-1 month', '+1 month'),
        'organisation_id' => $faker->numberBetween(1, 1)
    ];
});
