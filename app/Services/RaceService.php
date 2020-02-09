<?php

namespace App\Services;

use App\Game;
use App\Race;

class RaceService
{
    /**
     * @var Race
     */
    private $race;

    /**
     * RaceService constructor.
     * @param Race $race
     */
    public function __construct(Race $race)
    {
        $this->race = $race;
    }

    /**
     * @param integer $timestamp
     * @throws \Exception
     */
    public function calculateCurrentRaceStatus($timestamp)
    {
        $durationOfRace = $timestamp - $this->race->start_ts;
        if ($durationOfRace < 0) {
            throw new \Exception('incorrect timestamp');
        }

        $horsesCoveredDistance = [];
        $numberOfHorsesFinished = 0;

        foreach ($this->race->horses as $horse) {
            $horseService = new HorseService($horse);
            $horsesCoveredDistance[$horse->id] = $horseService->getCoveredDistance($durationOfRace);
            if ($horsesCoveredDistance[$horse->id] == Game::RACE_DISTANCE) {
                $numberOfHorsesFinished++;
            }
        }

        if ($numberOfHorsesFinished == sizeof($this->race->horses)) {
            $this->race->markAsComplete();
        }
    }
}
