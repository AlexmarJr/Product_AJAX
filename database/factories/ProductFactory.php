<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Product;
use Faker\Generator as Faker;

$factory->define(App\Product::class, function (Faker $faker) {
    $array = ['Ativo', 'Desativado'];
    return [
        'name' => $faker->sentence(4),
        'type' => $faker->sentence(2),
        'quant' => $faker->sentence(1),
        'price' =>  Arr::random($array),
    ];
});