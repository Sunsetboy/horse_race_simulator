<?php

namespace Tests\Integration;

use App\Factories\RaceFactory;
use App\Game;
use App\Horse;
use App\Race;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class GameTest extends TestCase
{

    use DatabaseMigrations;

    /**
     * @test
     */
    public function create_new_races_if_no_races_exist()
    {
        $game = new Game();

        $game->createRaces();

        $this->assertDatabaseHas('races', []);

        $races = Race::all();
        $this->assertEquals(Game::RACES_LIMIT, sizeof($races));

        $horses = Horse::all();
        $this->assertEquals(Game::RACES_LIMIT * Race::NUMBER_OF_HORSES, sizeof($horses));
    }

    /**
     * @test
     */
    public function create_new_races_when_active_races_exist()
    {
        $raceFactory = new RaceFactory();
        $raceFactory->create();

        $game = new Game();
        $game->createRaces();
        $races = Race::all();

        $this->assertEquals(Game::RACES_LIMIT, sizeof($races));
    }

}
