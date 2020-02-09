<?php

namespace App\Factories;

use App\Horse;
use Faker\Factory;

class HorseFactory
{
    /**
     * Creates a Horse object
     * @return Horse
     */
    public function create(): Horse
    {
        $horse = new Horse();
        $faker = Factory::create();

        $horse->name = $faker->name;
        $horse->strength = mt_rand(0, 100) / 10;
        $horse->speed = mt_rand(0, 100) / 10;
        $horse->endurance = mt_rand(0, 100) / 10;

        return $horse;
    }
}
