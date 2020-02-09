<?php

namespace Tests\Integration\Factories;

use App\Factories\RaceFactory;
use App\Race;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class RaceFactoryTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * @test
     */
    public function create_a_single_race()
    {
        $raceFactory = new RaceFactory();
        $race = $raceFactory->create();

        $this->assertTrue($race instanceof Race);
        $this->assertDatabaseHas('races', ['id' => $race->id]);
        $this->assertDatabaseHas('horses', ['race_id' => $race->id]);

        $this->assertEquals(Race::NUMBER_OF_HORSES, sizeof($race->horses));
    }
}
