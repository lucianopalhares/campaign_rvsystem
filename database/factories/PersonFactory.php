<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Person;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

$factory->define(Person::class, function (Faker $faker) {

    $slug = $faker->unique()->sentence;
    $slug = Str::slug($slug, '-');  
  
    return [
        'first_name' => $faker->first_name,
        'last_name' => $faker->last_name,
        'cpf' => $faker->unique()->randomNumber(11),
        'sex' => $faker->randomElement($array = array ('M','F'));
        'slug' => $slug
    ];
});
