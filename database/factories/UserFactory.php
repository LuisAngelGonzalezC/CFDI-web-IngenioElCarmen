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

$factory->define(App\User::class, function (Faker $faker) {
    return [
    	'number' => $faker->unique()->numberBetween($min = 1000, $max = 9000),
        'name' => $faker->firstName,
        'last_name' => $faker->lastName,
        'second_last_name' => $faker->lastName,
        'rfc' => str_random(11),
        'curp' => str_random(18),
        'imss' => str_random(10).'-F'.random_int(1, 9),
        'email' => $faker->unique()->safeEmail,
        'password' => '$2y$10$6N1N1Fr1x7Qtqpb2A2AsV.dTqhRUzBaxS4mVXkWzWThhUxU8qQyc2', // 12345678
        'confirmation_code' => str_random(25),
    ];
});
