<?php

namespace Tests\Integration\Services;

use App\Factories\HorseFactory;
use App\Game;
use App\Services\HorseService;
use Tests\TestCase;

class HorseServiceTest extends TestCase
{

    /**
     * @test
     * @dataProvider providerTimeToFinish
     */
    public function test_get_time_to_finish($speed, $endurance, $strength, $expectedTime)
    {
        $horseFactory = new HorseFactory();
        $horse = $horseFactory->create();
        $horse->speed = $speed;
        $horse->endurance = $endurance;
        $horse->strength = $strength;

        $horseService = new HorseService($horse);

        $this->assertEquals($expectedTime, round($horseService->getTimeToFinish()));
    }

    /**
     * @return array
     */
    public function providerTimeToFinish(): array
    {
        return [
            'all 5s' => [
                'speed' => 5,
                'endurance' => 5,
                'strength' => 5,
                'expectedTime' => 193
            ],
        ];
    }

    /**
     * @test
     * @dataProvider providerDistanceInTime
     */
    public function get_distance_covered_in_time($speed, $endurance, $strength, $seconds, $expectedDistance)
    {
        $horseFactory = new HorseFactory();
        $horse = $horseFactory->create();
        $horse->speed = $speed;
        $horse->endurance = $endurance;
        $horse->strength = $strength;

        $horseService = new HorseService($horse);

        $this->assertEquals($expectedDistance, round($horseService->getCoveredDistance($seconds)));
    }

    /**
     * @return array
     */
    public function providerDistanceInTime(): array
    {
        return [
            'zero seconds' => [
                'speed' => 5,
                'endurance' => 5,
                'strength' => 5,
                'seconds' => 0,
                'expectedDistance' => 0,
            ],
            'many seconds' => [
                'speed' => 5,
                'endurance' => 5,
                'strength' => 5,
                'seconds' => 100000,
                'expectedDistance' => Game::RACE_DISTANCE,
            ],
        ];
    }
}
