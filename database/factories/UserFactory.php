<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\User;
use Faker\Generator as Faker;

$factory->define(User::class, function (Faker $faker) {
    return [
        'username' => $faker->name,
        //写死，不然不知道密码
        'password' => bcrypt('admin'),
    ];
});
