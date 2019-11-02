<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */
use App\Organisation;
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

$factory->define(Organisation::class, function (Faker $faker) {



    return [
        'name' => $faker->company,
        'link' => $faker->domainName,
        'type' => $faker->numberBetween(1,3),
        'unique_identifier' => $faker->numberBetween(100000000, 999999999),
        'email' => $faker->unique()->safeEmail,
        'alt_email' => $faker->unique()->safeEmail,
        'phone' => $faker->e164PhoneNumber,
        'alt_phone' => $faker->e164PhoneNumber,
        'contact' => $faker->name,
        'request' => $faker->text(255),
        'status' => $faker->numberBetween(0, 5),
        'email_verified_at' => now(),
        'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
        'remember_token' => Str::random(10),
        'role' => $faker->numberBetween(1,3)
    ];
});
