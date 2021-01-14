<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Pupil;
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

$factory->define(Pupil::class, function (Faker $faker) {
    return [
        'fullname' => $faker->name,
        'mobile_phone' => $faker->unique()->numerify('79#########'),
        'email' => $faker->unique()->safeEmail,
        'address' => $faker->address,
    ];
});
