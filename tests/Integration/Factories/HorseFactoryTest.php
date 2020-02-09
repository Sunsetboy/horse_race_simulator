<?php

namespace Tests\Integration\Factories;

use App\Factories\HorseFactory;
use App\Horse;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class HorseFactoryTest extends TestCase
{

    use DatabaseMigrations;

    /**
     * @test
     */
    public function create_a_single_horse()
    {
        $horseFactory = new HorseFactory();
        $horse  = $horseFactory->create();

        $this->assertTrue($horse instanceof Horse);
        $this->assertIsNumeric($horse->strength);
        $this->assertIsNumeric($horse->speed);
        $this->assertIsNumeric($horse->endurance);
        $this->assertIsString($horse->name);

        $horse->race_id = 10;

        $horse->save();
        $this->assertDatabaseHas('horses', ['name' => $horse->name]);
    }
}
