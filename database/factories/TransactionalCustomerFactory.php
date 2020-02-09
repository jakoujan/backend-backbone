<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */
use App\TransactionalCustomer;
use Faker\Generator as Faker;

$factory->define(TransactionalCustomer::class, function (Faker $faker) {
    return [
        'businessName' => $faker->name,
        'system_customer' => rand(1, 32),
        'tax_id' => $faker->unique()->sentence(1),
        'contact' => $faker->name,
        'telephone' => '5556543210',
        'email' => $faker->unique()->safeEmail,
        'street' => $faker->sentence(3),
        'internal_number' => rand(0, 200),
        'external_number' => rand(1, 200),
        'settlement' => $faker->sentence(1),
        'city' => $faker->sentence(1),
        'county' => $faker->sentence(1),
        'state' => rand(1, 32),
        'postal_code' => rand(1000, 99999),
        'country' => '52',
        'status' => '1'
    ];
});
