<?php


namespace Tests\Integration;


use App\Factories\RaceFactory;
use App\Helpers\FakeTime;
use App\Race;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class RaceTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * @test
     * @throws \Exception
     */
    public function create_a_race_and_complete_it()
    {
        $faketime = FakeTime::getInstance();

        $race = (new RaceFactory())->create();
        $startDateTime = $faketime->getDateTime();
        $this->assertDatabaseHas('races', ['status' => Race::STATUS_IN_PROGRESS, 'start_ts' => $startDateTime]);

        $faketime->increment(10);
        $finishDateTime = $faketime->getDateTime();
        $race->markAsComplete();

        $this->assertDatabaseHas('races', ['status' => Race::STATUS_COMPLETE, 'start_ts' => $startDateTime]);

    }
}
