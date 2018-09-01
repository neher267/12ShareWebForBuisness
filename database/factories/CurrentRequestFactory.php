<?php

use Faker\Generator as Faker;

$factory->define(App\CurrentRequest::class, function (Faker $faker) {
    return [
    	"user_id" => "1",
        "share_with"=> "B",
		"lat" => "23.7831459",
		"lng" => "90.3928238",
		"des_lat" => "23.749423099999998",
		"des_lng" => "90.3830754",
		"country_code" =>"BD",
		"address" =>"Dhanmondi"
    ];
});
