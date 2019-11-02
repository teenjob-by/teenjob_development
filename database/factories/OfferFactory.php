<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */
use App\Offer;
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

$factory->define(Offer::class, function (Faker $faker) {



    return [
        'title' => $faker->jobTitle,
        'city_id' => $faker->numberBetween(1, 5),
        'speciality' => $faker->numberBetween(1, 20),
        'age' => $faker->numberBetween(16, 20),
        'type' => $faker->numberBetween(1, 3),
        'description' => $faker->text(255),
        'contact' => $faker->name,
        'phone' => $faker->e164PhoneNumber,
        'email' => $faker->email,
        'alt_phone' => $faker->e164PhoneNumber,
        'status' => $faker->numberBetween(0, 5),
        'offer_type' => $faker->numberBetween(0, 1),
        'published_at'=>$faker->dateTimeBetween('-1 month', '+1 month'),
        'organisation_id' => $faker->numberBetween(1, 1)
    ];
});
