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

    $addresses = [
        'Москва, шоссе Осташковское, 59',
        'Москва, Южнопортовая, 7/Д',
        'Москва, ул. Новослободская, 31',
        'Москва, ул. Чагинская, 4-207',
        'ул. Улагашева, д. 13, г. Горно-Алтайск',
        'пр-т Калинина, д. 8, г. Барнаул',
        'ул. Ленина, д. 40, г. Майкоп',
        'ул. Амурская, д. 150, г. Благовещенск',
        'ул. Пушкина, д. 95, г. Уфа',
        'ул. Преображенская, д. 82, г. Белгород',
        'ул. Дуки, д. 80, г. Брянск',
        'ул. Ленина, д. 55, г. Улан-Удэ',
        'ул. Большая Московская, д. 1, г. Владимир',
        'ул. 7-я Гвардейская, д. 12, г. Волгоград',
        'ул. Пушкинская, д. 25, г. Вологда',
    ];

    return [
        'fullname' => $faker->name,
        'mobile_phone' => $faker->unique()->numerify('79#########'),
        'email' => $faker->unique()->safeEmail,
        'address' => $addresses[mt_rand(0, count($addresses) - 1)],
    ];
});
