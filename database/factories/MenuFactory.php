<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Models\Menu;
use Faker\Generator as Faker;

$factory->define(Menu::class, function (Faker $faker) {
	return [
		'name' => $faker->name,
		'link' => $faker->url,
		'type' => config('custom.menu.header_menu'),
		'order' => 99999,
	];
});
